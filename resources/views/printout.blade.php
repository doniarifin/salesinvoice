<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- font awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
      p {
         display: flex;
         justify-content: space-between;
         }
    </style>

    @yield('css')

</head>
<body>
   <div class="container mt-3">
      <div class="row justify-content-center">
         <div class="col-md-8">
            <div class="card">
               <div class="card-header" style="text-align: center"><b>Sales Invoice</b></div>

               <div class="card-body">
                     <p>Date &emsp; &emsp; &emsp; &emsp; &emsp;: {{ $date }} </p> 
                     <p>Customer Code&emsp;&ensp;: {{ $cus_code }}</p>
                     <p style="display: flex; justify-content: space-between;">
                        <span>Name Customer &emsp;: {{ $cust_name }}</span>
                        <span>No. Invoice &emsp;: {{ $no }}</span>
                     </p>
                  <br>
                  <div class="col-md-12">
                     <table class="table table-bordered">
                        <thead>
                           <tr>
                              <th scope="col">No</th>
                              <th scope="col-sm-3">Item Code</th>
                              <th scope="col">Description</th>
                              <th scope="col">Qty</th>
                              <th scope="col">Price</th>
                              <th scope="col">Total</th>
                           </tr>
                        </thead>
                        <tbody class="addMoreProduct">
                           @foreach($sl1 as $i => $sl)
                           <tr>
                              <th scope="row"> {{ $i+1 }} </th>
                              <td>
                                 {{ $sl->product->item_code }}
                              </td>
                              <td>
                                 {{ $sl->product->name_product }}
                              </td>
                              <td>
                                 {{ $sl->qty }}
                              </td>
                              <td>
                                 {{ $sl->product->price_product }}
                              </td>
                              <td>
                                 {{ $sl->total_harga }}
                              </td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                  <br>
                  <div class="form-group col-sm-3" style="float: right">
                     <label for="grand_total" scope="col"> <b>Grand Total :</b></label>
                     <input type="number" name="grand_total" class="form-control-plaintext grand_total" value="{{ $gtotal }}" readonly>
                     <br>
                     <div class="form-group" style="margin-right: 50%">
                        <p>Customer</p> <br>
                        <p>{{ $cust_name }}</p>
                     </div>
                  </div>
                  <div class="form-group" style="float: left">
                     <label for=""></label>
                     <input type="number" name="grand_total" class="form-control-plaintext grand_total" disabled>
                     <br>
                     <div class="form-group" style="margin-left: 70%">
                        <p>Sales</p>
                        <br>
                        <p>Sela</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>


<script src="https://unpkg.com/vue@next"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('asset/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<script type="text/javascript">
   window.print();
</script>


</body>
</html>