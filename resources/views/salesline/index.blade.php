@extends('layouts.main')

@section('header', 'Sales Lines')

@section('css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('asset') }}/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{ asset('asset') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('asset/dist/css/adminlte.min.css?v=3.2.0')}}">
@endsection

@section('content')

<div id="controller">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url('export')}}" class="btn btn-sm btn-primary pull-right">Export to Excel</a>
                    <a href="{{ url('export-chart') }}" class="btn btn-sm btn-warning">Open in Chart</a>
                </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No. Invoice</th>
                                    <th>Date</th>
                                    <th>CodeCustomer</th>
                                    <th>Name Customer</th>
                                    <th>ItemCode</th>
                                    <th>Name Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
<script src="{{ asset('asset/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{ asset('asset/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js"></script>

<script type="text/javascript">
    var actionUrl = '{{ url('saleslines') }}';
    var apiUrl = '{{ url('api/saleslines') }}';
    var columns = [
        {data: 'no_invoice', class: 'text-center', orderable: false},
        {data: 'date', class: 'text-center', orderable: false},
        {data: 'code_customer', class: 'text-center', orderable: false},
        {data: 'name_customer', class: 'text-center', orderable: false},
        {data: 'item_code', class: 'text-center', orderable: false},
        {data: 'name_product', class: 'text-center', orderable: false},
        {data: 'qty', class: 'text-center', orderable: false},
        {data: 'price_product', class: 'text-center', orderable: false},
        {data: 'total_harga', class: 'text-center', orderable: false},
    ];
</script>

<script type="text/javascript">
    $(function () {
     $("#datatable").DataTable();
    });
    
    // importdatatables
    var controller = new Vue({
     el: '#controller',
     data: {
         datas: [],
         data: {},
         actionUrl,
         apiUrl,
     },
     mounted: function () {
         this.datatable();
     },
     methods: {
         datatable() {
             const _this = this;
             _this.table = $('#datatable').DataTable({
                 ajax: {
                     url: _this.apiUrl,
                     type: 'GET',
                 },
                 columns: columns,
             }).on('xhr', function () {
                 _this.datas = _this.table.ajax.json().data;
             });
         },
     }
    });
</script>
@endsection