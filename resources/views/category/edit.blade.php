<div class="modal-dialog">
    {!! Form::open(['url' => action([\App\Http\Controllers\CategoryController::class, 'update'], $category->id),
    'method' => 'PUT', 'id' => 'updateCategoryForm', 'files' => true]) !!}
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title fs-5">Update</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="my-2">
                {!! Form::label('name', 'Category Name*') !!}
                {!! Form::text('name', $category->name, ['class'=>'form-control']) !!}
            </div>

            <div>
                <div class="my-2">
                    {!! Form::label('image', 'Category Image*') !!}
                    {!! Form::file('image', ['class'=>'form-control', 'accept' => 'image/*',]) !!}
                </div>
            </div>

            <div class="my-2">
                {!! Form::label('description', 'Description') !!}
                {!! Form::textarea('description', $category->description, ['class'=>'form-control', 'rows' => 2]) !!}
            </div>

        </div>
        <div class="modal-footer">
            <button class="btn btn-primary">Save</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
