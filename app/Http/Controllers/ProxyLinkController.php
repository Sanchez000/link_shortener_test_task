<?php

namespace App\Http\Controllers;

use App\Models\Link;

class ProxyLinkController extends Controller
{
    public function show($shortCode)
    {
        $link = Link::getActiveByShortCode($shortCode)->firstOrFail();

        if($link->clicks_limit > 0 && $link->clicks >= $link->clicks_limit){
            abort(404);
        }

        $link->increment('clicks');
        return redirect($link->original_url);
    }
}
