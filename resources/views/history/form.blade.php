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
                            <th>Photo</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach($data->masterOrderDetail as $value)
                            @foreach($value->order->order_details as $detail)
                                <tr>
                                    <td>{{$detail->product_name}}</td>
                                    <td><a href="#" id="img-attchment"><img src="{{asset('storage/upload/product/'.$detail->image)}}" class="rounded" style="width: 60px;"/> </a></td>
                                    <td>{{number_format($detail->price, 0, ',', '.')}}</td>
                                    <td>{{$detail->qty}}</td>
                                    <td class="text-right">{{number_format($detail->price * $detail->qty, 0, ',', '.')}}</td>
                                </tr>
                                @php
                                    $total += $detail->price * $detail->qty;
                                @endphp
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th class="text-right">{{number_format($total, 0, ',', '.')}}</th>
                        </tr>
                    </tfoot>
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

@section('footer_scripts')
<script type="text/javascript">
    $(function () {
        $(document).on('click', '#img-attchment', function(e) {
            Swal.fire({
              imageUrl: e.target.src,
              imageAlt: 'Custom image',
            });
        });  
    });
</script>
@endsection


