<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TagDataTable;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TagDataTable $dataTable)
    {

        return $dataTable->render('admin.tag.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'tag_name' => ['required' ,'max:20' ,'unique:tags,name'],
        ]);

        $tag = new Tag();
        $tag->name = $request->tag_name;
        $tag->save();

        return response(['status' => 'success' ,'msg' => 'Tag Created !']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $tag = Tag::findOrFail($id);

        return $tag;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'tag_name' => ['required' ,'max:20' ,'unique:tags,name,'.$id],
        ]);

        $tag = Tag::findOrFail($id);
        $tag->name = $request->tag_name;
        $tag->update();

        return response(['status' => 'success' ,'msg' => 'Tag Updated !']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
