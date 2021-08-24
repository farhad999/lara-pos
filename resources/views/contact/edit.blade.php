<div class="modal-dialog">
    {!! Form::open(['url' => action([\App\Http\Controllers\ContactController::class, 'update'], $contact->id),
    'method' => 'PUT', 'id' => 'updateContactForm', 'files' => true]) !!}
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5">Update Contact</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <div class="my-2">
                {!! Form::label('name', 'Contact Name*') !!}
                {!! Form::text('name', $contact->name, ['class'=>'form-control']) !!}
            </div>

            <div class="my-2">
                {!! Form::label('phone', 'Phone*') !!}
                {!! Form::text('phone', $contact->phone, ['class'=>'form-control']) !!}
            </div>

            <div class="my-2">
                {!! Form::label('type', 'Type*') !!}
                {!! Form::select('type', ['customer' => 'Customer', 'supplier' => 'Supplier'], $contact->type, ['class'=>'form-control']) !!}
            </div>

            <div class="my-2">
                {!! Form::label('Address', 'Address*') !!}
                {!! Form::textarea('address', $contact->address, ['class'=>'form-control', 'rows' => 2]) !!}
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary">Save</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
