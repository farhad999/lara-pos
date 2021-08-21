@extends('layouts.app')

@section('main')
    <div>
        <div class="my-2 d-flex align-items-center justify-content-between">
            <h4>Categories</h4>
            <button class="btn btn-primary create-modal-open-btn">Create</button>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="w-100 table" id="categoryTable">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>

            </div>
        </div>

    </div>

    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            {!! Form::open(['url' => action([\App\Http\Controllers\CategoryController::class, 'store']), 'id' => 'createCategoryForm', 'files' => true]) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="my-2">
                        {!! Form::label('name', 'Category Name*') !!}
                        {!! Form::text('name', '', ['class'=>'form-control']) !!}
                    </div>

                    <div class="my-2">
                        {!! Form::label('image', 'Category Image*') !!}
                        {!! Form::file('image', ['class'=>'form-control', 'accept' => 'image/*',]) !!}
                    </div>

                    <div class="my-2">
                        {!! Form::label('description', 'Description*') !!}
                        {!! Form::textarea('description', '', ['class'=>'form-control', 'rows' => 2]) !!}
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-hidden="true">
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function ()
        {

            //create modal open modal

            $(document).on('click', '.create-modal-open-btn', function () {
                $('#createCategoryModal').modal('show');
            });

            //add unit

            $(document).on('submit', 'form#createCategoryForm', function (e) {
                e.preventDefault();

                $(this)
                    .find('button[type="submit"]')
                    .attr('disabled', true);
                //use form data instead of serialize in file upload
                const data = new FormData(this);
                //returns array
                //data.append('image', $('#upload-image')[0].files);

                //console.log('data', $('#upload-image')[0].files);

                $.ajax({
                    method: 'POST',
                    url: $(this).attr('action'),
                    dataType: 'json',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (response) {

                        let {status, message} = response;

                        if (status === 'success') {
                            toastr.success(message);
                            table.ajax.reload();
                            getParentCategories();

                        } else {
                            toastr.warn(message);
                        }

                        $('#createCategoryModal').modal('hide');


                    },
                });
            });

            $(document).on('submit', 'form#updateCategoryForm', function (e) {
                e.preventDefault();

                $(this)
                    .find('button[type="submit"]')
                    .attr('disabled', true);
                //use form data instead of serialize in file upload
                const data = new FormData(this);
                //returns array
                //data.append('image', $('#upload-image')[0].files);

                //console.log('data', $('#upload-image')[0].files);

                $.ajax({
                    method: 'POST',
                    url: $(this).attr('action'),
                    dataType: 'json',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        let {status, message} = response;

                        if (status === 'success') {
                            toastr.success(message);
                            table.ajax.reload();

                        } else {
                            toastr.warn(message);
                        }

                        $('#updateCategoryModal').modal('hide');
                    },
                });
            });

            let table = $('#categoryTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax:'/categories',
                columnDefs: [
                    {
                        orderable: false,
                        searchable: false,
                    },
                ],
                columns: [
                    {data: 'image'},
                    {data: 'name'},
                    {data: 'description'},
                    {data: 'actions'}
                ],
            });

            $('#createCategoryModal').on('show.bs.modal', function () {
                $("#createCategoryForm").validate({
                    rules: {
                        name: {
                            required: true,
                        },
                    },
                    messages: {}
                });
            });

            $('#updateCategoryModal').on('show.bs.modal', function () {
                $("#updateCategoryForm").validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        short: {
                            required: true,
                        }
                    },
                    messages: {}
                });
            });

            //on click edit unit button

            $(document).on('click', '.edit-category-btn', function () {
                $('#updateCategoryModal').load($(this).data('href'), function (result) {
                    $(this).modal('show');
                })
            });

            $(document).on('click', '.delete-category-btn', function () {

                let url = $(this).data('href');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: url,
                            method: 'delete',
                            dataType: 'json',
                            success: function (res) {
                                console.log("deleted", res);
                                toastr.success("Item deleted");
                                table.ajax.reload();
                            },
                            error: function (er) {
                                console.log(er)
                            }
                        });

                    }
                })

            })

        });

    </script>
@endsection
