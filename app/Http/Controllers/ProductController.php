<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    function index()
    {

        if (\request()->ajax()) {
            $products = Product::select('id', 'name', 'sku', 'image', 'purchase_price', 'sell_price', 'description');
            return DataTables::of($products)
                ->editColumn('image', function ($row) {
                    return "
                            <div class='table-image-container'>
                                <img src='$row->image_url' />
                            </div>";
                })
                ->addColumn('actions', function ($row) {
                    return "
                            <button class='btn btn-primary btn-sm view-product-btn' data-href='/products/$row->id' >View</button>
                            <a class='btn btn-primary btn-sm edit-product-btn' href='/products/$row->id/edit' >Edit</a>
                            <button class='btn btn-danger btn-sm delete-product-btn' data-href='/products/$row->id'>Delete</button>";
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
        }

        return view('product.index');
    }

    function create()
    {

        $brands = Brand::pluck('name', 'id')->toArray();

        $units = Unit::pluck('name', 'id')->toArray();

        $categories = Category::select('name', 'id')
            ->whereNull('parent_id')
            ->get()->pluck('name', 'id')
            ->toArray();

        return view('product.create', compact('brands', 'units', 'categories'));
    }

    function show($id)
    {

        $product = Product::with('unit', 'brand', 'category')->find($id);

        return view('product.view', compact('product'));
    }

    function store()
    {
        \request()->validate([
            'sku' => 'string|nullable|min:6',
            'name' => 'required|string',
            'unit_id' => 'string',
            'quantity' => 'required|integer',
            'purchase_price' => 'required|integer',
            'sell_price' => 'required|integer',

        ]);

        //dd(\request()->all());

        $data = \request()->only([
            'name', 'unit_id', 'brand_id', 'category_id', 'sub_category_id',
            'quantity', 'purchase_price', 'sell_price', 'description',
        ]);

        if (empty(\request()->input('sku'))) {
            try {
                $data['sku'] = random_int(100000, 999999);
            } catch (\Exception $e) {
                \Log::emergency('Number Exeception: ' . $e->getMessage());
            }
        }

        try {

            if (\request()->has('image')) {
                $image = \request()->file('image');
                $imageName = time() . '.' . $image->clientExtension();
                $data['image'] = $imageName;
                $image->move(public_path() . '/images', $imageName);
            }

            Product::create($data);
            session()->flash('message', 'Product Added');

            return redirect('/products');

        } catch (\Exception $exception) {
            \Log::emergency('Line: ' . $exception->getLine() . 'Message: ' . $exception->getMessage());
            return response(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    function edit($id)
    {

        $product = Product::find($id);

        $brands = Brand::all()->pluck('name', 'id')->toArray();

        $brands[''] = 'Select Brand';

        $units = Unit::all()->pluck('name', 'id')->toArray();

        $units[''] = 'Select Unit';

        $categories = Category::select('name', 'id')
            ->whereNull('parent_id')
            ->get()->pluck('name', 'id')
            ->toArray();

        $categories[''] = 'Select Category';

        // return view('product.create', compact('brands', 'units', 'categories'));

        return view('product.edit', compact('product', 'brands', 'units', 'categories'));
    }

    function update($id)
    {
        \request()->validate([
            'name' => 'required|string',
            'unit_id' => 'string',
            'purchase_price' => 'required|integer',
            'sell_price' => 'required|integer',

        ]);

        $product = Product::find($id);


        try {

            $product->name = \request()->input('name');
            $product->unit_id = \request()->input('unit_id');
            $product->brand_id = \request()->input('brand_id');
            $product->category_id = \request()->input('category_id') ?? null;
            $product->purchase_price = \request()->input('purchase_price');
            $product->sell_price = \request()->input('sell_price');


            if (\request()->has('image')) {
                $image = \request()->file('image');
                $imageName = time() . '.' . $image->clientExtension();
                $product['image'] = $imageName;
                $image->move(public_path() . '/images', $imageName);
            }

            $product->save();

            session()->flash('message', 'Product Updated');

            return redirect('/products');

        } catch (\Exception $exception) {
            \Log::emergency('Line: ' . $exception->getLine() . 'Message: ' . $exception->getMessage());
            return response(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product) {

            $product->delete();

            return response()->json(['status' => 'success']);
        } else {
            return \response()->json(['status' => 'failed']);
        }


    }

    function searchProduct()
    {

        $q = \request()->input('q');

        $products = Product::where('name', 'like', '%' . $q . '%')
            ->get();

        //dd($products);

        return response()->json($products);
    }

}
