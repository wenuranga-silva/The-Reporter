<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ImpCategories;
use Illuminate\Http\Request;

class CategoryHome extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::all(['id' ,'name']);

        return view('admin.category.home' ,compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $category = Category::findOrFail($request->id);

        $count = ImpCategories::where('cat_id' ,$request->id)->count();

        if ($count == 0) {

            $data = new ImpCategories();
            $data->cat_id = $request->id;
            $data->save();
        }

        return response(['status' => 'success', 'msg' => 'Category Added !']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $check = ImpCategories::where('cat_id' ,$id)->firstOrFail();

        $check->delete();

        return response(['msg' => "Category removed !"]);

    }
}
