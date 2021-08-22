@extends('layouts.app')

@section('main')
    <div>
        <div class="my-2 d-flex align-items-center justify-content-between">
            <h4>Brands</h4>
            <button class="btn btn-primary create-brand-btn">Create</button>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="brandsTable" class="w-100">
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

    <div class="modal" id="createBrandModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">

            {!! Form::open(['url' => action([\App\Http\Controllers\BrandController::class, 'store']), 'id' => 'createBrandForm', 'files' => true]) !!}

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="my-2">
                        {!! Form::label('name', 'Brand Name*') !!}
                        {!! Form::text('name', '', ['class'=>'form-control']) !!}
                    </div>

                    <div class="my-2">
                        {!! Form::label('image', 'Brand Image*') !!}
                        {!! Form::file('image', ['class'=>'form-control', 'accept' => 'image/*',
                    'id' => 'upload-image', 'multiple' => true]) !!}
                    </div>

                    <div class="my-2">
                        {!! Form::label('description', 'Description*') !!}
                        {!! Form::textarea('description', '', ['class'=>'form-control']) !!}
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal" id="updateBrandModal" tabindex="-1" role="dialog">
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {


            $(document).on('click', '.create-brand-btn', function () {
                $("#createBrandModal").modal('show');
            });

            $(document).on('submit', 'form#createBrandForm', function (e) {
                e.preventDefault();


                $(this)
                    .find('button[type="submit"]')
                    .attr('disabled', true);
                //use form data instead of serialize in file upload
                const data = new FormData(this);
                //returns array

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

                            //reset form

                            table.ajax.reload();

                        } else {
                            toastr.warn(message);
                        }

                        $('#createBrandModal').modal('hide');


                    },
                });
            });

            $(document).on('submit', 'form#updateBrandForm', function (e) {
                e.preventDefault();

                $(this)
                    .find('button[type="submit"]')
                    .attr('disabled', true);
                //use form data instead of serialize in file upload
                const data = new FormData(this);
                //returns array

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

                        $('#updateBrandModal').modal('hide');
                    },
                });
            });

            let table = $('#brandsTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "/brands",
                    dataSrc: 'data',
                    cache: false,
                },
                columnDefs: [
                    {
                        orderable: false,
                        searchable: false,
                    },
                ],
                columns: [
                    {data: 'image',},
                    {data: 'name'},
                    {data: 'description'},
                    {data: 'actions'}
                ],
            });

            $('#createBrandModal').on('show.bs.modal', function () {
                $("#createBrandForm").validate({
                    rules: {
                        name: {
                            required: true,
                        },
                    },
                    messages: {}
                });
            });

            $('#updateBrandModal').on('show.bs.modal', function () {
                $("#updateBrandForm").validate({
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

            $(document).on('click', '.edit-brand-btn', function () {
                console.log("button");
                $('#updateBrandModal').load($(this).data('href'), function (result) {
                    console.log("result", result);
                    $(this).modal('show');
                })
            });

            $(document).on('click', '.delete-brand-btn', function () {
                console.log("unit delete");

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
                                /*Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                );*/
                                table.ajax.reload();
                            },
                            error: function (er) {
                                console.log(er)
                            }
                        });

                    }
                })

            })

        })
    </script>
@endsection
