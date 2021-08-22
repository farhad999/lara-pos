<div class="modal-dialog">
    {!! Form::open(['url' => action([\App\Http\Controllers\UnitController::class, 'update'], $unit->id), 'method' => 'PUT', 'id' => 'updateUnitForm']) !!}
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title fs-5">Update Unit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="my-2">
                {!! Form::label('name', 'Unit Name*') !!}
                {!! Form::text('name', $unit->name, ['class'=>'form-control']) !!}
            </div>

            <div class="my-2">
                {!! Form::label('short', 'Short Name*') !!}
                {!! Form::text('short', $unit->short, ['class'=>'form-control']) !!}
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary">Save</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
