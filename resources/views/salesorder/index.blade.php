@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="text-align: center"><b>Sales Order</b></div>
                <form action="{{ url('printout') }}" method="post" id="myForm">
                  @csrf
                <div class="card-body customerData">
                      <div class="row mb-2">
                        <label for="date" class="col-sm-2 col-form-label">Date</label>
                        <div class="col-sm-3">
                           <input type="text" class="form-control-plaintext datePicker" name="date_picker" id="date_picker" value="{{ $cr }}" readonly>
                        </div>
                      </div>
                      <div class="row mb-2">
                        <label for="code_customer" class="col-sm-2 col-form-label">Code Customer</label>
                        <div class="col-sm-3">
                           <select name="customer_id" id="code_customer" class="form-select code_customer">
                             <option value="">Select Code Customer</option>
                             @foreach ($customers as $customer)
                             <option data-name="{{ $customer->name_customer }}" 
                              value="{{ $customer->id }}">{{ $customer->code_customer }}</option>
                             @endforeach 
                           </select>
                        </div>
                      </div>
                      <div class="input-group">
                        <label for="name_customer"class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-3">
                          <input class="form-control-plaintext name_customer" id="name_customer" name="name_customer" type="text" readonly>
                         </div>
                         <div class="row">
                            <label for="no_invoice" class="col-sm-4 col-form-label">No. Invoice:</label>
                            <div class="col-sm-8">
                               <input value="{{ $no_inv }}" class="form-control-plaintext no_invoice" id="no_invoice" name="no_invoice" type="text" readonly>
                            </div>
                         </div>
                      </div>
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
                             <th scope="col"><a href="#" class="btn btn-sm btn-success add_more"> <i class="fa fa-plus"></i></a></th>
                           </tr>
                         </thead>
                         <tbody class="addMoreProduct">
                           <tr>
                             <th scope="row">1</th>
                             <td>
                               <select name="product_id[]" id="item_code" class="form-select item_code">
                                 <option value="">Select Item Code</option>
                                 @foreach ($products as $product)
                                 <option data-name="{{ $product->name_product }}" 
                                  data-price="{{ $product->price_product }}" 
                                  value="{{ $product->id }}">{{ $product->item_code }}</option>
                                 @endforeach
                               </select>
                             </td>
                             <td>
                               <input type="text" name="name_product[]" id="name_product" class="form-control-plaintext name_product"  readonly>
                             </td>
                             <td>
                               <input type="number" name="qty[]" id="qty" class="form-control qty" value="1">
                             </td>
                             <td>
                               <input type="number" name="price_product[]" id="price_product" class="form-control-plaintext price_product" readonly>
                             </td>
                             <td>
                               <input type="number" name="total_price[]" id="total_price" class="form-control-plaintext total_price" readonly>
                             </td>
                             <td><a href="#" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a></td>
                           </tr>
                         </tbody>
                       </table>
                   </div>
                   <br>
                   <div class="form-group col-sm-3" style="float: right">
                    <label for="grand_total" scope="col"> <b>Grand Total :</b></label>
                    <input type="number" name="grand_total" id="grand_total" class="form-control grand_total" readonly>
                    <br>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Print Out</button>
                      <button type="submit" class="btn btn-warning" id="submitBtn" formaction="{{ url('saleslines') }}">Posting</a>
                    </div>
                  </form>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">

$(document).ready(function(){
    $('.add_more').on('click', function(){
    var product = $('.item_code').html();
    var row = ($('.addMoreProduct tr').length - 0) + 1;
    var tr = '<tr><td class="no">' + row + '</td>' +
              '<td> <select class="form-control item_code" id="item_code" name="product_id[]">'+ product +'</select> </td>' +
              '<td> <input type="text" class="form-control-plaintext name_product" id="name_product" name="name_product[]" readonly> </td>' +
              '<td> <input type="number" class="form-control qty" name="qty[]" value="1"> </td>' +
              '<td> <input type="number" class="form-control-plaintext price_product" id="price_product" name="price_product[]" readonly> </td>' +
              '<td> <input type="number" class="form-control-plaintext total_price" id="total_price" name="total_price[]" readonly> </td>' +
              '<td> <a href="#" class="btn btn-sm btn-danger delete"><i class="fa fa-times"></i></a> </td>';
              $('.addMoreProduct').append(tr);
  });

  //Delete Row
  $('.addMoreProduct').delegate('.delete', 'click', function(){
    $(this).parent().parent().remove();
  });

  function TotalPrice(){
    var total = 0;
    $('.total_price').each(function(){
      var t_price = $(this).val() - 0;
      total += t_price;
    });
    $('.grand_total').val(total);
  };

  $('.addMoreProduct').delegate('.item_code', 'change', function(){
    var tr = $(this).parent().parent();
    var name = tr.find('.item_code option:selected').attr('data-name');
    tr.find('.name_product').val(name);
    var price = tr.find('.item_code option:selected').attr('data-price');
    tr.find('.price_product').val(price);
    var qty = tr.find('.qty').val() - 0;
    var price = tr.find('.price_product').val() - 0;
    var totalprice = (qty * price);
    tr.find('.total_price').val(totalprice);
    TotalPrice();
  });

  $('.addMoreProduct').delegate('.qty', 'change', function(){
    var tr = $(this).parent().parent();
    var qty = tr.find('.qty').val() - 0;
    var price = tr.find('.price_product').val() - 0;
    var totalprice = (qty * price);
    tr.find('.total_price').val(totalprice);
    TotalPrice();
  });

  $('.customerData').delegate('.code_customer', 'change', function(){
    var yes = $(this).parent().parent().parent();
    var name = yes.find('.code_customer option:selected').attr('data-name');
    yes.find('.name_customer').val(name);

  });
})
</script>

@endsection