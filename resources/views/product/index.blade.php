@extends('layouts.app')

@section('styles')
    <style>
        th, td{
            padding: 0 10px;
        }
    </style>
@endsection

@section('main')
    <div>
        <div class="my-2 d-flex align-items-center justify-content-between">
            <h4>Products List</h4>
            <a class="btn btn-primary" href="{{route('products.create')}}">Create</a>
        </div>

        @if(session()->has('message'))
            <div class="alert alert-success"> {{session()->get('message')}} </div>
        @endif
        <div class="card">
            <div class="card-body">
                <table id="productTable" class="w-100">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Sku</th>
                        <th>Purchase Price</th>
                        <th>Sell Price</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>

            </div>
        </div>

    </div>


    <!-- View Modal -->
    <div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            let table = $('#productTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: "/products",
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
                    {data: 'image'},
                    {data: 'name'},
                    {data: 'sku'},
                    {data: 'purchase_price'},
                    {data: 'sell_price'},
                    {data: 'actions'}
                ],
            });

            $('#viewProductModal').on('show.bs.modal', function () {
                $("#updateProductForm").validate({
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

            $(document).on('click', '.view-product-btn', function () {
                console.log("button");
                $('#viewProductModal').load($(this).data('href'), function (result) {
                    console.log("result", result);
                    $(this).modal('show');
                })
            });

            $(document).on('click', '.delete-product-btn', function () {
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

        });

    </script>
@endsection
