<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title fs-5">View Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-md-8">
                    <table>
                        <tr>
                            <th>Name</th>
                            <td class="ms-2">{{$product->name}}</td>
                        </tr>
                        <tr>
                            <th>Brand</th>
                            <td>{{$product->brand ? $product->brand->name : 'No Brand'}}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{$product->category ? $product->category->name : 'No Category'}}</td>
                        </tr>
                        <tr>
                            <th>Purchase Price</th>
                            <td>{{$product->purchase_price}}</td>
                        </tr>
                        <tr>
                            <th>Selling Price</th>
                            <td>{{$product->sell_price}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <div style="width: 100%; border: 1px solid gray">
                        <img style="width: 100%" src="{{$product->image_url}}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
