@csrf
<div class="card-body">
    <div class="row">
        <div class="col-md-3">
            <x-input.text label="Master Order ID" name="id" :data="$data" readonly="readonly"/>
            <x-input.text label="Number Reference" name="number_reference" :data="$data" readonly="readonly"/>
            <x-input.text label="Status" name="status" :data="$data" readonly="readonly"/>
        </div>
        <div class="col-md-9">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data->masterOrderDetail as $value)
                            @foreach($value->order->order_details as $detail)
                                <tr>
                                    <td>{{$detail->product_name}}</td>
                                    <td>{{$detail->price}}</td>
                                    <td>{{$detail->qty}}</td>
                                    <td>{{$detail->price * $detail->qty}}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card-footer">
    <div class="float-right">
        <a href="{{ route('history.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>


