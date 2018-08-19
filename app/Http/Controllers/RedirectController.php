<?php

namespace App\Http\Controllers;

use App\Redirect;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RedirectController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redirects = Redirect::latest()->get();
        
        return view('admin.redirect.index',compact('redirects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.redirect.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'source_url' => 'required|unique:redirects',
            'redirect_url' => 'required|different:source_url',
            'type' => 'required',
        ]);

        $redirect = Redirect::create(request(['source_url','redirect_url','type']));

        if (request()->wantsJson()) {
            return response($redirect, 201);
        }

        return redirect()->route('redirects-index');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Redirect  $redirect
     * @return \Illuminate\Http\Response
     */
    public function show(Redirect $redirect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Redirect  $redirect
     * @return \Illuminate\Http\Response
     */
    public function edit(Redirect $redirect)
    {
        return view('admin.redirect.edit', compact('redirect'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Redirect  $redirect
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Redirect $redirect)
    {
        
        $validatedData = $request->validate(
            [
            'source_url' => [
                'required',
                Rule::unique('redirects')->ignore($redirect->id),
            ],
            'redirect_url' => 'required|different:source_url',
            'type' => 'required',
        ],
        [
            'source_url.unique' => "That URL is taken please choose a unique URL",
        ]);

        $redirect->update(request(['source_url','redirect_url','type']));

        return redirect()->route('redirects-index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Redirect  $redirect
     * @return \Illuminate\Http\Response
     */
    public function destroy(Redirect $redirect)
    {
        $redirect->destroy($redirect->id);
        return redirect()->route('redirects-index');
    }
}
