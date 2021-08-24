@extends('layouts.app')

<?php
    $contactType =  request()->query('type');
?>

@section('main')
    <div>
        <div class="my-2 d-flex align-items-center justify-content-between">
            <h4>Contacts</h4>
            <button class="btn btn-primary" id="create-contact-button">Add Contacts</button>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="contactsTable" class="w-100">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Type</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>

            </div>
        </div>

    </div>

    <div class="modal fade" id="createContactModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            {!! Form::open(['url' => action([\App\Http\Controllers\ContactController::class, 'store'], ['type' => $contactType]), 'id' => 'createContactForm', 'files' => true]) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5">Add Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="my-2">
                        {!! Form::label('name', 'Name*') !!}
                        {!! Form::text('name', '', ['class'=>'form-control']) !!}
                    </div>

                    <div class="my-2">
                        {!! Form::label('business_name', 'Business Name*') !!}
                        {!! Form::text('business_name', '', ['class'=>'form-control']) !!}
                    </div>

                    <div class="my-2">
                        {!! Form::label('phone', 'Phone*') !!}
                        {!! Form::text('phone', '', ['class'=>'form-control']) !!}
                    </div>

                    <div class="my-2">
                        {!! Form::label('Address', 'Address*') !!}
                        {!! Form::textarea('address', '', ['class'=>'form-control', 'rows' => 2]) !!}
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="updateContactModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            //open create modal

            $(document).on('click', '#create-contact-button', function(){
               $('#createContactModal').modal('show')
            });


            $(document).on('submit', 'form#createContactForm', function(e) {
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
                    success: function(response) {

                        let {status, message} = response;

                        if(status === 'success'){
                            toastr.success(message);
                            table.ajax.reload();

                            //reset form

                            $('form#createContactForm').trigger('reset');
                            $('#createContactModal').modal('hide');

                        }else{
                            toastr.error(message);
                        }

                    },
                });
            });

            $(document).on('submit', 'form#updateContactForm', function(e) {
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
                    success: function(response) {
                        let {status, message} = response;

                        if(status === 'success'){
                            toastr.success(message);
                            table.ajax.reload();

                        }else{
                            toastr.warn(message);
                        }

                        $('#updateContactModal').modal('hide');
                    },
                });
            });

            //$('.units-table').DataTable();

            let table = $('#contactsTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "/contacts?type={{$contactType}}",
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
                    {data: 'name'},
                    {data: 'phone'},
                    {data: 'type'},
                    {data: 'address'},
                    {data: 'actions'}
                ],
            });

            $('#createContactModal').on('show.bs.modal', function () {
                $("#createContactForm").validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        phone: {
                            required: true,
                            phoneBD: true,

                        }
                    },
                    messages: {}
                });
            });

            $('#updateBrandModal').on('show.bs.modal', function () {
                $("#updateContactForm").validate({
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
                console.log("ddd");
            });

            //on click edit unit button

            $(document).on('click', '.edit-contact-btn', function () {
                console.log("button");
                $('#updateContactModal').load($(this).data('href'), function (result) {
                    console.log("result", result);
                    $(this).modal('show');
                })
            });

            $(document).on('click', '.delete-contact-btn', function () {
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
                           success: function (res)  {
                               console.log("deleted", res);
                               toastr.success("Item deleted");
                               /*Swal.fire(
                                   'Deleted!',
                                   'Your file has been deleted.',
                                   'success'
                               );*/
                               table.ajax.reload();
                           },
                            error: function(er)  {
                               console.log(er)
                            }
                        });

                    }
                })

            })

        });

        //number check



    </script>
@endsection
