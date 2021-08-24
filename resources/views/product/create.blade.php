@extends('layouts.app')


@section('main')
    <div>

        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error->message}}
                </div>
            @endforeach

        @endif

        <h4 class="fs-5 fw-bold my-2">Create Product</h4>
        {!! Form::open(['url' => action([\App\Http\Controllers\ProductController::class, 'store']), 'files' => true, 'id' => 'createProductForm']) !!}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        {!! Form::label('name', 'Name*', ['class' => 'form-label']) !!}
                        {!! Form::text('name', '', ['class' => 'form-control']) !!}
                    </div>

                    <div class="col-md-6 mb-3">
                        {!! Form::label('sku', 'SKU*', ['class' => 'form-label']) !!}
                        {!! Form::text('sku', '', ['class' => 'form-control']) !!}
                    </div>

                    <div class="col-md-6 mb-3">
                        {!! Form::label('unit_id', 'Unit*', ['class' => 'form-label']) !!}
                        {!! Form::select('unit_id', $units, '', ['class' => 'form-control', 'placeholder' => 'Select Units']) !!}
                    </div>
                    <div class="col-md-6 mb-3">
                        {!! Form::label('brand_id', 'Brand*', ['class' => 'form-label']) !!}
                        {!! Form::select('brand_id', $brands, null, ['class' => 'form-control', 'placeholder' => 'Select Brand']) !!}
                    </div>
                    <div class="col-md-6 mb-3">
                        {!! Form::label('category_id', 'Category*', ['class' => 'form-label']) !!}
                        {!! Form::select('category_id', $categories ,'', ['class' => 'form-control select-category', 'placeholder' => 'Select Category']) !!}
                    </div>
                    <div class="col-md-6 mb-3">
                        {!! Form::label('image', 'Product Image*', ['class'=>'form-label']) !!}
                        {!! Form::file('image', ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-6 mb-3">
                        {!! Form::label('description', 'Description', ['class' => 'form-label']) !!}
                        {!! Form::textarea('description', '', ['class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        {!! Form::label('quantity', 'Stock Quantity', ['class' => 'form-label']) !!}
                        {!! Form::text('quantity', '', ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-6 mb-3">
                        {!! Form::label('purchase_price', 'Purchase Price*', ['class' => 'form-label']) !!}
                        {!! Form::text('purchase_price', '', ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            {!! Form::label('sell_price', 'Sell Price*', ['class' => 'form-label']) !!}
                            {!! Form::text('sell_price', '', ['class' => 'form-control']) !!}
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
            $('#createProductForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    unit: {
                        required: true,
                    },
                    quantity: {
                        required: true,
                        number: true,
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

            $(document).on('change', '.select-category', function () {

                let value = this.value;

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
                    },
                    error: function (er) {

                    }
                })

            })

        })
    </script>
@endsection
