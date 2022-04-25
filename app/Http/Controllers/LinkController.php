<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLinkRequest;
use App\Models\Link;
use App\Services\ShortLinkCreator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class LinkController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('links.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLinkRequest $request, 
                          ShortLinkCreator $shortLinkCreator)
    {
        try {
            $linkModel = $shortLinkCreator->createNewLink($request);
            return redirect()->route('links.show',['link' => $linkModel->id]) 
                    ->with('success','Short link created successfully.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()
                ->withErrors(['msg' => 'Oops something went wrong try again later']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link)
    {
        $link->fullShortUrl = URL::to($link->short_code);
        return view('links.show', compact('link'));
    }
}
