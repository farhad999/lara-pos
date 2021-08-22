<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    function index(){

        if(\request()->ajax()){
            $units = Unit::select('id', 'name', 'short');

            return DataTables::of($units)
                ->addColumn('actions', function($row){
                    return "<button class='btn btn-primary btn-sm edit-unit-btn' data-href='/units/$row->id/edit' >Edit</button>
                            <button class='btn btn-danger btn-sm delete-unit-btn' data-href='/units/$row->id'>Delete</button>";
                })
                ->rawColumns(['actions'])
                ->removeColumn('id')
                ->make(true);

        }

        return view('unit.index');
    }

    function store(){
        \request()->validate([
            'name' => 'required|string',
            'short' => 'required|string',
        ]);

        try{
            $unit = new Unit();
            $unit->name = \request()->input('name');
            $unit->short = \request()->input('short');
            $unit->save();
            return redirect()->back();
        }catch (\Exception $exception){
            Log::emergency('Line: '. $exception->getLine(). 'Message: '. $exception->getMessage());
        }
    }

    function edit($id){

        $unit = Unit::find($id);

        return view('unit.edit', compact('unit'));
    }

    function update($id){

        \request()->validate([
            'name' => 'required|string',
            'short' => 'required|string',
        ]);

        $unit = Unit::find($id);

        $unit->name = \request()->input('name');
        $unit->short = \request()->input('short');

        $unit->save();
        return redirect()->back();
    }

    function destroy($id){
        $unit = Unit::findOrFail($id);

        if($unit){

            $unit->delete();

            return response()->json(['status' => 'success']);
        }else{
            return \response()->json(['status' => 'failed']);
        }


    }
}
