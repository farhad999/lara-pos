<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    function index()
    {

        if (\request()->ajax()) {
            $categories = Category::select('id', 'name', 'image', 'description', 'parent_id');
            return DataTables::of($categories)
                ->editColumn('image', function ($row) {
                    return "
                            <div class='table-image-container'>
                                <img src='$row->image_url' alt='category image' />
                            </div>";
                })
                ->addColumn('actions', function ($row) {
                    return "<button class='btn btn-primary btn-sm edit-category-btn' data-href='/categories/$row->id/edit' >Edit</button>
                            <button class='btn btn-danger btn-sm delete-category-btn' data-href='/categories/$row->id'>Delete</button>";
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
        }

        return view('category.index');
    }

    function store()
    {
        \request()->validate([
            'name' => 'required|string',
        ]);

        try {
            $category = new Category();
            $category->name = \request()->input('name');

            if (\request()->has('image')) {
                $image = \request()->file('image');
                $imageName = time() . '.' . $image->clientExtension();
                $category->image = $imageName;
                $image->move(public_path() . '/images', $imageName);
                //move_uploaded_file($imageName, $image);
            }

            $category->description = \request()->input('description');
            $category->save();

            return response(['status' => 'success', 'message' => 'Category Added']);

        } catch (\Exception $exception) {
            \Log::emergency('Line: ' . $exception->getLine() . 'Message: ' . $exception->getMessage());
            return response(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    function edit($id)
    {

        $category = Category::find($id);

        $parentCategories = Category::whereNull('parent_id')->get()->pluck('name', 'id')->toArray();

        return view('category.edit', compact('category', 'parentCategories'));
    }

    function update($id)
    {
        \request()->validate([
            'name' => 'required|string',
        ]);

        try {
            $category = Category::find($id);

            $category->name = \request()->input('name');

            if (\request()->has('image')) {
                $image = \request()->file('image');
                $imageName = time() . '.' . $image->clientExtension();
                $category->image = $imageName;
                $image->move(public_path() . '/images', $imageName);
            }

            $category->description = \request()->input('description');
            $category->save();
            return response()->json(['status' => 'success', 'message' => 'Category Updated']);
        } catch (\Exception $exception) {

            Log::emergency('Line: ' . $exception->getLine() . 'Message: ' . $exception->getMessage());
            return response(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category) {

            $category->delete();

            return response()->json(['status' => 'success']);
        } else {
            return \response()->json(['status' => 'failed']);
        }


    }

    function parentCategories()
    {

        $parentCategories = Category::
        select('id', 'name')
            ->whereNull('parent_id')->get();

        return response(['parentCategories' => $parentCategories]);
    }

    function getSubCategories($id)
    {
        $subCategories = Category::select('id', 'name')
            ->where('parent_id', '=', $id)
            ->get();

        return response($subCategories);
    }
}
