@extends('layouts.app')

@section('main')
    <div>
        <div class="my-2 d-flex align-items-center justify-content-between">
            <h4>Units</h4>
            <button class="btn btn-primary" id="create-unit-btn">Create</button>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="unitsTable" class="w-100">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Short Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>

            </div>
        </div>

    </div>

    <div class="modal fade" id="createUnitModal">
        <div class="modal-dialog">
            {!! Form::open(['url' => action([\App\Http\Controllers\UnitController::class, 'store']), 'id' => 'createUnitForm']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5">Create Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="my-2">
                        {!! Form::label('name', 'Unit Name*') !!}
                        {!! Form::text('name', '', ['class'=>'form-control']) !!}
                    </div>

                    <div class="my-2">
                        {!! Form::label('short', 'Short Name*') !!}
                        {!! Form::text('short', '', ['class'=>'form-control']) !!}
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
    <div class="modal fade" id="updateUnitModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            //add unit

            $(document).on('click', '#create-unit-btn', function(){
                $('#createUnitModal').modal('show');
            });

            $(document).on('submit', 'form#createUnitForm', function(e) {
                e.preventDefault();

                $(this)
                    .find('button[type="submit"]')
                    .attr('disabled', true);

                const data = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: $(this).attr('action'),
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        $('#createUnitModal').modal('hide');
                        table.ajax.reload();
                        toastr.success("Unit added");
                    },
                });
            });


            //$('.units-table').DataTable();

            let table = $('#unitsTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "/units",
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
                    {data: 'short'},
                    {data: 'actions'}
                ],
            });

            $('#createUnitModal').on('show.bs.modal', function () {
                $("#createUnitForm").validate({
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

            $('#updateUnitModal').on('show.bs.modal', function () {
                $("#updateUnitForm").validate({
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

            $(document).on('click', '.edit-unit-btn', function () {
                console.log("button");
                $('#updateUnitModal').load($(this).data('href'), function (result) {
                    console.log("result", result);
                    $(this).modal('show');
                })
            });

            $(document).on('click', '.delete-unit-btn', function () {
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

        })
    </script>
@endsection
