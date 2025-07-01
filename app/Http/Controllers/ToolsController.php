<?php

namespace App\Http\Controllers;

use App\Helpers\MyHelper;


class ToolsController extends Controller
{
    public function converter()
    {
        // SEO Optimizations
        MyHelper::setGlobalSEOData(__('seo.converter.title'), __('seo.converter.description'));

        return view('tools.font-converter');
    }

    public function fontDownload()
    {
        // SEO Optimizations
        MyHelper::setGlobalSEOData(__('seo.font-download.title'), __('seo.font-download.description'));

        return view('tools.font-download');
    }
}
