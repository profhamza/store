<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MainCatRequest;
use App\Models\Language;
use App\Models\MainCategory;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class MainCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = getAllMainCats();
        return view('admin.maincats.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.maincats.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MainCatRequest $request)
    {
        try {
            // get category array of array and convert it to collection
            $cat_collection = collect($request->category);
            // use filter to extract default language category
            $filter_cats = $cat_collection->filter(function ($value, $key) {
                return $value['translation'] == getCurrentLocale();
            });
            // get default lang category collection
            $default_lang = array_values($filter_cats->all())[0];
            // call helper function to save image in our custom path
            $image = saveImage("assets/admin/images/uploads/maincats/", $request->photo);
            DB::beginTransaction();
            // store default language category in db and get the id
            $cat = MainCategory::create([
                'name' => $default_lang['name'],
                'description' => $default_lang['description'],
                'translation' => $default_lang['translation'],
                'active' => $default_lang['active'],
                'photo' => $image
            ]);
            $default_cat_id = $cat->id;
            // get the other categories
            $other_cats = $cat_collection->filter(function ($value, $key) {
                return $value['translation'] != getCurrentLocale();
            });
            // for each in categories and store it in array
            $cats_arr = [];
            foreach ($other_cats as $cat) {
                $cat['active'] = ($cat['active']) == "on" ? 1 : 0;
                $cats_arr[] = [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'translation' => $cat['translation'],
                    'active' => $cat['active'],
                    'translate_of' => $default_cat_id,
                    'photo' => $image
                ];
            }
            // insert categories in database
            MainCategory::insert($cats_arr);
            DB::commit();
            return redirect()->route("main-categories.index")->with(['success' => 'تم ادخال القسم بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'حدث خطا اثناء الحفظ برجاء المحاوله لاحقا']);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = MainCategory::find($id);
        if (!$category)
        {
            return redirect()->route("main-categories.index")->with(['error' => 'هذا القسم غير موجود']);
        }
        return view("admin.maincats.edit", compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = MainCategory::find($id);
        if (!$category)
        {
            return redirect()->route("main-categories.index")->with(['error' => 'هذا القسم غير موجود']);
        }
        try {
            // get category array of array and convert it to collection
            $cat_collection = collect($request->category);
            $image = "";
            if ($request->photo)
                $image = saveImage("assets/admin/images/uploads/maincats/", $request->photo);
            else
                $image = $request->image_not_send;
            // use filter to extract default language category
            $filter_cats = $cat_collection->filter(function ($value, $key) {
                return $value['translation'] == getCurrentLocale();
            });
            // get default lang category collection
            $default_cat = array_values($filter_cats->all())[0];
            // begin transactions
            DB::beginTransaction();
            // update default language category in db and get the id
            $main_cat = $category->update([
                'name' => $default_cat['name'],
                'description' => $default_cat['description'],
                'translation' => $default_cat['translation'],
                'active' => $default_cat['active'],
                'photo'  => $image
            ]);
            // get the other categories
            $other_cats = $cat_collection->filter(function ($value, $key) {
                return $value['translation'] != getCurrentLocale();
            });
            // for each in categories and store it in array
            foreach ($other_cats as $cat) {
                $cat['active'] = ($cat['active'] == "on") ? 1 : 0;
                MainCategory::where('translate_of', $id)->where("id", $cat['id'])->update([
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'translation' => $cat['translation'],
                    'active' => $cat['active'],
                    'translate_of' => $id,
                    'photo' => $image
                ]);
            }
            DB::commit();
            return redirect()->route("main-categories.index")->with(['success' => 'تم تحديث بيانات القسم بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'حدث خطا اثناء تحديث البيانات برجاء المحاوله لاحقا']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            $category = MainCategory::find($request->id);
            if(!$category)
            {
                return response()->json([
                    "error" => true,
                    "msg"   => "هذا القسم غير موجود"
                ], 403);
            }
            $vendors = $category->vendors;
            if ($vendors->count() > 0)
            {
                return response()->json([
                    "error" => true,
                    "msg"   => "لا يمكن حذف هذا القسم"
                ], 403);
            }
            // remove image from folder
            $image = base_path($category->photo);
            unlink($image);
            // delete category
            if ($category->delete())
            {
                return response()->json([
                    "success" => true,
                    "msg"   => "تم حذف القسم بنجاح",
                    "id"    => $request->id
                ], 200);
            }
        }
        catch(\Exception $e)
        {
            return response()->json([
                "error" => true,
                "msg"   => "حدث خطا اثناء حذف القسم برجاء المحاوله لاحقا"
            ], 403);
        }
    }

    public function activate(Request $request)
    {
        try{
            $category = MainCategory::find($request->id);
            if(!$category)
            {
                return response()->json([
                    "error" => true,
                    "msg"   => "هذا القسم غير موجود"
                ], 403);
            }
            $msg = "";
            if ($category->active == 0)
            {
                $category->update(['active' => 1]);
                $msg = "تم تفعيل القسم بنجاح";
            }
            else
            {
                // "0" not 0 for not matching with "on" string when type casting
                $category->update(['active' => "0"]);
                $msg = "تم الغاء تفعيل القسم بنجاح";
            }
            return response()->json([
                "success" => true,
                "msg"   => $msg,
                "active" => $category->active,
                'id'     => $category->id
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                "error" => true,
                "msg"   => "حدث خطا اثناء تعديل القسم برجاء المحاوله لاحقا"
            ], 403);
        }
    }

    public function createAnotherLanguages($id)
    {
        $category = MainCategory::with("categories")->find($id);
        if(!$category)
        {
            return redirect()->back()->with(['success' => "هذا القسم غير موجود"]);
        }
        $translations = [];
        $translations[] = $category->translation;
        foreach($category->categories as $cat)
        {
            $translations[] = $cat->translation;
        }
        $languages = collect(Language::get());
        $languages = $languages->filter(function ($value, $key) use ($translations) {
            return !in_array($value['abbr'], $translations);
        });
        $languages = array_values($languages->all());
        if (empty($languages))
        {
            return redirect()->route("main-categories.edit", $id)->with(["error" => "لا توجد لغات اخرى لاضافتها لهذا القسم"]);
        }
        return view("admin.maincats.createLanguages", compact(['category', 'languages']));
    }

    public function storeAnotherLanguages(MainCatRequest $request)
    {
        try {
            $categories = collect($request->category);
            $cats = [];
            foreach ($categories as $cat)
            {
                $cat['active'] = ($cat['active']) == "on" ? 1 : 0;
                $cats[] = [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'translation' => $cat['translation'],
                    'translate_of' => $request->id,
                    'active' => $cat['active'],
                ];
            }
            if (MainCategory::insert($cats))
            {
                return redirect()->route("main-categories.index")->with(["success" => "تم تحديث القسم باضافه بعض اللغات"]);
            }
        }
        catch(\Exception $ex)
        {
            return redirect()->route("main-categories.edit", $request->id)->with(["error" => "حدث خطا اثناء اضافه اللغات لهذا القسم"]);
        }
    }
}
