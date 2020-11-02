<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VendorRequest;
use App\Models\MainCategory;
use App\Models\Vendor;
use App\Notifications\VendorNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = getActivatedVendors();
        return view("admin.vendors.index", compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $maincats = getActivatedMainCats();
        return view("admin.vendors.create", compact('maincats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRequest $request)
    {
        try {
            $logo = saveImage("assets/admin/images/uploads/vendors/", $request->logo);
            $vendor = Vendor::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'logo' => $logo,
                'address' => $request->address,
                'password' => bcrypt($request->password),
                'active' => $request->active,
                'cat_id' => $request->cat_id
            ]);
            if ($vendor)
            {
                Notification::send($vendor, new VendorNotify($vendor));
                return redirect()->route('vendors.index')->with(['success' => 'تم اضافه تاجر جديد']);
            }
        }
        catch(\Exception $ex)
        {
            return $ex;
            return redirect()->route('vendors.index')->with(['error' => 'حدث خطاء اثناء ادخال البيانات برجاء المحاوله لاحقا']);
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
        $vendor = Vendor::find($id);
        if (!$vendor)
        {
            return redirect()->route('vendors.index')->with(['error' => 'هذا التاجر غير موجود او تم حذفه']);
        }
        $maincats = getActivatedMainCats();
        return view('admin.vendors.edit', compact('vendor','maincats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorRequest $request, $id)
    {
        try{
            $vendor = Vendor::find($id);
            if (!$vendor)
            {
                return redirect()->route('vendors.index')->with(['error' => 'هذا التاجر غير موجود او تم حذفه']);
            }

            if ($request->has('logo'))
                $logo = saveImage("assets/admin/images/uploads/vendors/", $request->logo);
            else
                $logo = $request->logo_if_notsend;

            if ($request->password != "")
                $pass = bcrypt($request->password);
            else
                $pass = $request->pass_if_notsend;

            $vendor->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'logo' => $logo,
                'address' => $request->address,
                'password' => $pass,
                'active' => $request->active,
                'cat_id' => $request->cat_id
            ]);
            return redirect()->route('vendors.index')->with(['success' => 'تم تعديل بيانات التاجر بنجاح']);
        }
        catch(\Exception $ex)
        {
            return redirect()->route('vendors.index')->with(['error' => 'حدث خطا اثناء تحديث البيانات برجاء المحاوله لاحقا']);
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
            $vendor = Vendor::find($request->id);
            if(!$vendor)
            {
                return response()->json([
                    "error" => true,
                    "msg"   => "هذا المتجر غير موجود"
                ], 403);
            }
            // remove image from folder
            $image = base_path($vendor->getLogo());
            unlink($image);
            // delete category
            if ($vendor->delete())
            {
                return response()->json([
                    "success" => true,
                    "msg"   => "تم حذف المتجر بنجاح",
                    "id"    => $request->id
                ], 200);
            }
        }
        catch(\Exception $e)
        {
            return response()->json([
                "error" => true,
                "msg"   => "حدث خطا اثناء حذف المتجر برجاء المحاوله لاحقا"
            ], 403);
        }
    }

    public function activate(Request $request)
    {
        try{
            $vendor = Vendor::find($request->id);
            if(!$vendor)
            {
                return response()->json([
                    "error" => true,
                    "msg"   => "هذا المتجر غير موجود"
                ], 403);
            }
            $msg = "";
            if ($vendor->active == 0)
            {
                $vendor->update(['active' => 1]);
                $msg = "تم تفعيل المتجر بنجاح";
            }
            else
            {
                // "0" not 0 for not matching with "on" string when type casting
                $vendor->update(['active' => "0"]);
                $msg = "تم الغاء تفعيل المتجر بنجاح";
            }
            return response()->json([
                "success" => true,
                "msg"   => $msg,
                "active" => $vendor->active,
                'id'     => $vendor->id
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                "error" => true,
                "msg"   => "حدث خطا اثناء تعديل المتجر برجاء المحاوله لاحقا"
            ], 403);
        }
    }
}
