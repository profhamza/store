<?php

use App\Models\Language;
use App\Models\MainCategory;
use App\Models\Vendor;
use App\Scopes\ActiveScope;
use Illuminate\Support\Facades\Config;

/*
 * withoutGlobalScope() ==> to get all main cats activated or not
 * LocalLangCats()==> locale scope to get main cats in the config app locale lang
 * COUNT_PAGINATION ==> pagination count constant
 * */
function getAllMainCats()
{
    return MainCategory::LocalLangCats()->paginate(COUNT_PAGINATION);
}

function getActivatedMainCats()
{
    return MainCategory::active()->LocalLangCats()->paginate(COUNT_PAGINATION);
}

/*
 * withoutGlobalScope() ==> to get all languages activated or not
 * COUNT_PAGINATION ==> pagination count constant
 * */
function getAllLanguages()
{
    return Language::paginate(COUNT_PAGINATION);
}

/*
 * to get only activated languages
 * COUNT_PAGINATION ==> pagination count constant
 * */
function getActivatedLanguages()
{
    return Language::activeLanguages()->paginate(COUNT_PAGINATION);
}

/*
 * to get current language in confix app locale
 * */
function getCurrentLocale()
{
    return Config::get("app.locale");
}

/*
 * to upload photos
 * */
function saveImage($folderSave,$image)
{
    $img_extension = $image->getClientOriginalExtension();
    $img_name = $image->getClientOriginalName();
    $_image = time() . "_" . $img_name . "." . $img_extension;
    $image->move($folderSave, $_image);
    return $_image;
}

/*
 * to get all activated vendors
 * active() && selectVendors are locale scopes
 * */
function getActivatedVendors()
{
    return Vendor::activeVendors()->selectVendors()->paginate(COUNT_PAGINATION);
}
function getAllVendors()
{
    return Vendor::SelectVendors()->paginate(COUNT_PAGINATION);
}
