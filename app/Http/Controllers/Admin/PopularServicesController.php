<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PopularServices;
use App\Http\Controllers\Controller;

class PopularServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PopularServices::all();
        return view('admin.pages.popularServices.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.popularServices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'ru_title' => 'required|unique:popular_services|max:255',
        ]);
            
        $service = new PopularServices();
        $service->uz_title = $request->input('uz_title');
        $service->ru_title = $request->input('ru_title');
        $service->en_title = $request->input('en_title');
        $service->uz_content = $request->input('uz_content');
        $service->ru_content = $request->input('ru_content');
        $service->en_content = $request->input('en_content');
        $service->url = $request->input('url');
        if ($request->hasFile('image')){
            $service->uploadImage($request->file('image'));
        }
        else {
            $service->image = $request->input('image-text');
        }
        $service->save();

        if ($request->has('saveQuit')) {
            return redirect()->route('admin.popular.index');
        }
        return redirect()->route('admin.popular.create');
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
        $current = PopularServices::find($id);
        return view('admin.pages.popularServices.edit', compact('current'));
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
        $service = PopularServices::find($id);
        $service->uz_title = $request->input('uz_title');
        $service->ru_title = $request->input('ru_title');
        $service->en_title = $request->input('en_title');
        $service->uz_content = $request->input('uz_content');
        $service->ru_content = $request->input('ru_content');
        $service->en_content = $request->input('en_content');
        $service->url = $request->input('url');
        if ($request->hasFile('image')){
            $service->uploadImage($request->file('image'));
        }
        else if($request->input('image-text') != '') {
            $service->image = $request->input('image-text');
        }
        $service->save();

        return redirect()->route('admin.popular.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $current = PopularServices::find($id);
        $current->delete();
        return redirect()->route('admin.popular.index');
    }

    public function removeImage($id)
    {
        $current = PopularServices::find($id);
        $current->removeImage();

        return redirect()->route('admin.popular.edit', $current->id);
    }
}
