<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoriesDataTable $dataTable)
    {

        return $dataTable->render('admin.category.index');
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
            'category_name' => ['required', 'string', 'max:50', 'unique:categories,name'],
        ]);

        $category = new Category();
        $category->name = $request->category_name;
        $category->save();

        return response(['status' => 'success' ,'msg' => 'Category Added !']);
    }

    /**
     * return resource for updating.
     */
    public function show(string $id)
    {

        $category = Category::findOrFail($id);
        return $category;

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'category_name' => ['required', 'string', 'max:50', 'unique:categories,name,'.$id],
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->category_name;
        $category->update();

        return response(['status' => 'success' ,'msg' => 'Category Updated !']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
