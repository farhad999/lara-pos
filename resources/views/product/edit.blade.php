
@extends('layouts.app')


@section('main')
    <div>
        <div class="fs-5 fw-bold my-2">Update Product</div>
        {!! Form::open(['url' => action([\App\Http\Controllers\ProductController::class, 'update'], [$product->id]),
        'files' => true, 'id' => 'updateProductForm', 'method' => 'PUT']) !!}
        <div class="card">


            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        {!! Form::label('name', 'Name*', ['class' => 'form-label']) !!}
                        {!! Form::text('name', $product->name, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-4 mb-3">
                        {!! Form::label('unit_id', 'Unit*', ['class' => 'form-label']) !!}
                        {!! Form::select('unit_id', $units, $product->unit_id, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-4 mb-3">
                        {!! Form::label('brand_id', 'Brand*', ['class' => 'form-label']) !!}
                        {!! Form::select('brand_id', $brands, $product->brand_id, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-4 mb-3">
                        {!! Form::label('category_id', 'Category*', ['class' => 'form-label']) !!}
                        {!! Form::select('category_id', $categories , $product->category_id, ['class' => 'form-control select-category']) !!}
                    </div>
                    <div class="col-md-4 mb-3">
                        {!! Form::label('image', 'Product Image*', ['class'=>'form-label']) !!}
                        {!! Form::file('image', ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-4 mb-3">
                        {!! Form::label('description', 'Description', ['class' => 'form-label']) !!}
                        {!! Form::textarea('description', $product->description, ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        {!! Form::label('purchase_price', 'Purchase Price*', ['class' => 'form-label']) !!}
                        {!! Form::text('purchase_price', $product->purchase_price, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            {!! Form::label('sell_price', 'Sell Price*', ['class' => 'form-label']) !!}
                            {!! Form::text('sell_price', $product->sell_price, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>

                <div>
                    <button class="btn btn-primary ml-auto" type="submit">Save</button>
                </div>

            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#updateProductForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    unit: {
                        required: true,
                    },
                    purchase_price: {
                        required: true,
                        number: true,
                    },
                    sell_price: {
                        required: true,
                        number: true,
                    },

                }
            });

            //on category selection change

            getSubCat();

            $(document).on('change', '.select-category', function () {
                getSubCat();
            })



        });

        function getSubCat(){

            let value = $('.select-category').val();

            if(value) {

                $.ajax({
                    url: '/categories/' + value + '/sub_categories',
                    method: 'get',
                    success: function (res) {
                        let subCategories = res;
                        console.log("res", res);
                        let html = "<option value=''>Select Sub Category</option>";
                        subCategories.forEach(function (item) {
                            html += `<option value=${item.id}>${item.name}</option>`;
                        });
                        $('.select-sub-cat').html(html);
                        $('.select-sub-cat').val({{$product->sub_category_id}});
                    },
                    error: function (er) {

                    }
                })
            }
        }

    </script>
@endsection
