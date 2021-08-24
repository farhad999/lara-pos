<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    function index()
    {

        if (\request()->ajax()) {

            $type = \request()->input('type');

            $contacts = Contact::select('id', 'name', 'phone', 'type', 'address')
            ->where('type', $type);
            return DataTables::of($contacts)
                ->addColumn('actions', function ($row){
                    return "<button class='btn btn-primary btn-sm edit-contact-btn' data-href='/contacts/$row->id/edit' >Edit</button>
                            <button class='btn btn-danger btn-sm delete-contact-btn' data-href='/contacts/$row->id'>Delete</button>";
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('contact.index');
    }

    function store()
    {
        \request()->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);


        $data = \request()->only([
            'name', 'phone', 'type', 'address'
        ]);


        try {

            Contact::create($data);

            return response(['status' => 'success', 'message' => 'Contact Added']);

        } catch (\Exception $exception) {
            \Log::emergency('Line: ' . $exception->getLine() . 'Message: ' . $exception->getMessage());
            return response(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    function edit($id)
    {

        $contact = Contact::find($id);

        return view('contact.edit', compact('contact'));
    }

    function update($id)
    {


        \request()->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'string' => 'string'
        ]);

        try {
            $contact = Contact::find($id);

            $contact->name = \request()->input('name');
            $contact->type = \request()->input('type');
            $contact->phone = \request()->input('phone');
            $contact->address = \request()->input('address');
            $contact->save();
            return response()->json(['status' => 'success', 'message' => 'Contact Updated']);
        } catch (\Exception $exception) {

            \Log::emergency('Line: ' . $exception->getLine() . 'Message: ' . $exception->getMessage());
            return response(['status' => 'failed', 'message' => $exception->getMessage()]);
        }
    }

    function destroy($id)
    {
        $contact = Contact::findOrFail($id);

        if ($contact) {

            $contact->delete();

            return response()->json(['status' => 'success']);
        } else {
            return \response()->json(['status' => 'failed']);
        }


    }
}
