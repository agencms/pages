<?php

namespace Agencms\Pages\Controllers;

use Illuminate\Http\Request;
use Agencms\Pages\Models\Page;
use Agencms\Settings\Settings;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Page::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Page::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return $page;
    }

    public function render(string $slug)
    {
        if (!$page = Page::where('slug', '=', $slug)->first()) {
            abort(404);
        }

        $twitter_handle = Settings::get('global', 'twitter-handle', '');
        $github_handle = Settings::get('global', 'github-handle', 'm2de');
        $title = Settings::get('global', 'title', 'My Portfolio');
        $social = Settings::get('global', 'sociallinks', []);
        $copyright = Settings::get('global', 'copyright', '');
        $shareimage = Settings::get('global', 'sharingimage', '');

        return view('agencms::page', compact([
            'page',
            'social',
            'copyright',
            'shareimage',
            'title',
            'github_handle',
            'twitter_handle',
        ]));
    }

    public function homepage()
    {
        if (!$homepage_id = Settings::get('global', 'homepage')) {
            abort(404);
        }

        if (!$page = Page::find($homepage_id)) {
            abort(404);
        }

        $twitter_handle = Settings::get('global', 'twitter-handle', '');
        $github_handle = Settings::get('global', 'github-handle', '');
        $title = Settings::get('global', 'title', 'My Portfolio');
        $social = Settings::get('global', 'sociallinks', []);
        $copyright = Settings::get('global', 'copyright', '');
        $shareimage = Settings::get('global', 'sharingimage', '');

        return view('agencms::page', compact([
            'page',
            'social',
            'copyright',
            'shareimage',
            'title',
            'github_handle',
            'twitter_handle',
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $page)
    {
        $page = Page::findOrFail($page)->update($request->all());

        return $page
            ? response()->json('Saved', 200)
            : abort(500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();
    }
}
