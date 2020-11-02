<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageRequest;
use App\Models\Language;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = getAllLanguages();
        return view('admin.language.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.language.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LanguageRequest $request)
    {
        try
        {
            $language = Language::create($request->all());
            if ($language)
            {
                return redirect()->route('languages.index')->with(['success' => 'تم ادخال اللغه بنجاح']);
            }
        }
        catch (\Exception $ex)
        {
            return redirect()->route('languages.index')->with(['error' => 'حدث خطا اثناء الادخال حاول مره اخرى']);
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
        $language = Language::withoutGlobalScope(ActiveScope::class)->find($id);
        if ($language)
        {
            return view('admin.language.edit', compact('language'));
        }
        return redirect()->route('languages.index')->with(['error' => 'هذه اللغه غير موجوده']);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LanguageRequest $request, $id)
    {
        try
        {
            $language = Language::withoutGlobalScope(ActiveScope::class)->find($id);
            if ($language) {
                if ($language->update($request->all())) {
                    return redirect()->route('languages.index')->with(['success' => 'تم تحديث اللغه بنجاح']);
                }
            }
            return redirect()->back()->with(['error' => 'اللغه غير موجوده']);
        } catch (\Exception $ex)
        {
            return redirect()->back()->with(['error' => 'حدث خطا اثناء تحديث البيانات']);
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
        try
        {
            $language = Language::withoutGlobalScope(ActiveScope::class)->find($request->langId);
            if ($language)
            {
                if ($language->delete())
                {
                    return response()->json([
                        "success" => true,
                        "msg" => 'تم حذف اللغه بنجاح',
                        'id' => $language->id
                    ]);
                }
            }
            return response()->json([
                "success" => false,
                "msg" => 'هذه اللغه غير موجوده'
            ]);
        }
        catch(\Exception $ex)
        {
            return response()->json([
                "success" => false,
                "msg" => 'حدث خطا اثناء حذف اللغه'
            ]);
        }
    }
}
