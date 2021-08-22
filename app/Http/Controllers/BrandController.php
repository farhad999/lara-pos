<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    function index()
    {

        if (\request()->ajax()) {
            $brands = Brand::select('id', 'name', 'image', 'description');
            return DataTables::of($brands)
                ->editColumn('image', function ($row) {
                    return "
                            <div class='table-image-container'>
                                <img src='$row->image_url' />
                            </div>";
                })
                ->addColumn('actions', function ($row){
                    return "<button class='btn btn-primary btn-sm edit-brand-btn' data-href='/brands/$row->id/edit' >Edit</button>
                            <button class='btn btn-danger btn-sm delete-brand-btn' data-href='/brands/$row->id'>Delete</button>";
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
        }

        return view('brand.index');
    }

    function store()
    {
        \request()->validate([
            'name' => 'required|string',
        ]);


        try {
            $brand = new Brand();
            $brand->name = \request()->input('name');

            if (\request()->has('image')) {
                $image = \request()->file('image');
                $imageName = time() . '.' . $image->clientExtension();
                $brand->image = $imageName;
                $image->move(public_path() . '/images', $imageName);
                //move_uploaded_file($imageName, $image);
            }

            $brand->description = \request()->input('description');
            $brand->save();

            return response(['status' => 'success', 'message' => 'Brand Added']);

        } catch (\Exception $exception) {
            Log::emergency('Line: ' . $exception->getLine() . 'Message: ' . $exception->getMessage());
            return response(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    function edit($id)
    {

        $brand = Brand::find($id);

        return view('brand.edit', compact('brand'));
    }

    function update($id)
    {


        \request()->validate([
            'name' => 'required|string',
        ]);

        try {
            $brand = Brand::find($id);

            $brand->name = \request()->input('name');

            if (\request()->has('image')) {
                $image = \request()->file('image');
                $imageName = time() . '.' . $image->clientExtension();
                $brand->image = $imageName;
                $image->move(public_path() . '/images', $imageName);
            }

            $brand->description = \request()->input('description');
            $brand->save();
            return response()->json(['status' => 'success', 'message' => 'Brand Updated']);
        } catch (\Exception $exception) {

            Log::emergency('Line: ' . $exception->getLine() . 'Message: ' . $exception->getMessage());
            return response(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand) {

            $brand->delete();

            return response()->json(['status' => 'success']);
        } else {
            return \response()->json(['status' => 'failed']);
        }


    }
}
