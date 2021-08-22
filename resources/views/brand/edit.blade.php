<div class="modal-dialog modal-md">
    {!! Form::open(['url' => action([\App\Http\Controllers\BrandController::class, 'update'], $brand->id),
    'method' => 'PUT', 'id' => 'updateBrandForm', 'files' => true]) !!}
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title fs-5">Update</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="my-2">
                {!! Form::label('name', 'Unit Name*') !!}
                {!! Form::text('name', $brand->name, ['class'=>'form-control']) !!}
            </div>

            <div>
                <div class="my-2">
                    {!! Form::label('image', 'Brand Image*') !!}
                    {!! Form::file('image', ['class'=>'form-control', 'accept' => 'image/*',]) !!}
                </div>
            </div>

            <div class="my-2">
                {!! Form::label('description', 'Description') !!}
                {!! Form::textarea('description', $brand->description, ['class'=>'form-control', 'rows' => '3']) !!}
            </div>

        </div>
        <div class="modal-footer">
            <button class="btn btn-primary">Update</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
