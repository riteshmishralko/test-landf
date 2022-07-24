@extends('layout')

@section('content')

@php $item_price = 0 ; $item_quantity=0 ; @endphp
@if(session('cart'))

    
    @if(session('cart'))
        @foreach(session('cart') as $id => $details)
        
        @php $item_quantity = $item_quantity + $details['quantity']; @endphp
        @php $item_price = $item_price + ($details["price"] * $details["quantity"]); @endphp


        @endforeach
    @endif
@endif

<style>

.txt-heading {
	margin: 20px 0px;
	text-align: left;
    background: #cccccc;
    padding: 5px 10px;
    overflow: auto;
}

#shopping-cart .txt-heading {
	border-top: #607d8b 2px solid;
    background: #ffffff;
    border-bottom: #607d8b 2px solid;
}

.txt-heading-label {
	display: inline-block;
}

#shopping-cart .txt-heading .txt-heading-label{
	margin-top:5px;
}

.cart-item {
	border-bottom: #79b946 1px dotted;
	padding: 10px;
}

#product-grid {
	margin-bottom: 30px;
    text-align: center;
    padding-bottom: 20px;
}

.product-item {
	display: inline-block;
	margin: 8px;
	border: #CCC 1px solid;
}

.product-title {
	position: absolute;
    bottom: 0px;
    background: rgba(0, 0, 0, 0.3);
    width: 100%;
    padding: 5px 0px;
    color: #f1f1f1;
}
.product-image {
	height: 110px;
	width:160px;
	position:relative;
}

.product-image img {
	width:100%;
    height: 110px;
}

.product-footer {
    padding: 20px 10px 10px;
    overflow: auto;
}
.float-left {
	float:left;
}
.float-right {
	float:right;
}

.input-cart-quantity {
	padding: 6px;
    margin: 0;
    vertical-align: top;
    border: #CCC 1px solid;
    border-right: 0px;
}
.cart-info {
	text-align: right; 
	display:inline-block;
	width:18%;
}
.cart-info.title {
	width:37%;
	text-align: left; 
}
.cart-info.quantity {
    width: 99px;
}
.cart-info.price {
	min-width:20%;
	position:relative;
}
.cart-info.action {
    vertical-align: middle;
    float:right;
}
.cart-item-container {
	padding: 5px 10px;
    border-bottom: #e2e2e2 1px solid;
}
.cart-status {
    float: right;
} 
#btnEmpty img{
	margin-top:6px;
	cursor:pointer;
}

.cart-item-container.header {
	background: #CCC;
    border-bottom: #b9b8b8 1px solid;
}

.btn-increment-decrement {
    display: inline-block;
    padding: 5px 0px;
    background: #e2e2e2;
    width: 30px;
    text-align: center;
    cursor:pointer;
}

.input-quantity {
	border: 0px;
    width: 30px;
    display: inline-block;
    margin: 0;
    box-sizing: border-box;
    text-align: center;
}
</style>
<div id="shopping-cart">
        

    <div class="shopping-cart-table">
            <div class="cart-item-container header">
            
                <div class="cart-info title">Title</div>
                <div class="cart-info">Quantity</div>
                <div class="cart-info price">Price</div>
            </div>

            @if(session('cart'))
            @foreach(session('cart') as $id => $details)
            <div class="cart-item-container row">

                <div class="">
                            <div class="col-sm-3 hidden-xs"><img src="{{ $details['image'] }}" width="100" height="100" class="img-responsive"/></div>
                        </div>
                        
                <div class="cart-info title"> {{ $details['name'] }}</div>

                    <div class="cart-info quantity">
                        <div class="btn-increment-decrement" onClick="decrement_quantity({{ $id }}, {{ $details['price'] }})">-</div>
                        <input class="input-quantity" id="input-quantity-{{ $id }}" value="{{ $details['quantity'] }}">
                        <div class="btn-increment-decrement" onClick="increment_quantity({{ $id }}, {{ $details['price'] }})">+</div>
                    </div>

                    <div class="cart-info price" id="cart-price-{{ $id }}"> ${{  ($details['price'] * $details["quantity"]) }} </div>


                    <div class="cart-info action">
                        <a data-id="{{ $id }}" href="javascript:void(0)" class="remove-from-cart btnRemoveAction">Remove</a>
                    </div>
            </div>
			@endforeach
        @endif	
    

        </div>
        <div class="txt-heading">
            <a href="{{ url('/') }}"class="btn btn-primary">continue shopping</a>
            <div class="txt-heading-label"></div>
            @php $finalitem_price = 0 ; @endphp

            <div class="cart-status">
            <div>Total Quantity: <span class="total-quantity" id="total-quantity">{{ $item_quantity }}</span></div>
                
                @if($item_quantity > 0)
                @php  $finalitem_price  =  '$'.($item_price-(($item_price * 18)/100)); @endphp    
                <div>Tax: 18% of total $<span id="total-price">{{ $item_price }}</span></div>

                @endif	

                <div>Final Price: <span id="final-price">{{ $finalitem_price }}</span></div>
            </div>
        </div>
</div>
  

@endsection
  
@section('scripts')
<script type="text/javascript">
  
    




    
function increment_quantity(cart_id, price) {

    

    var inputQuantityElement = $("#input-quantity-"+cart_id);
    var newQuantity = parseInt($(inputQuantityElement).val())+1;
    var newPrice = newQuantity * price;
    save_to_db(cart_id, newQuantity, newPrice);
}

function decrement_quantity(cart_id, price) {
    var inputQuantityElement = $("#input-quantity-"+cart_id);
    if($(inputQuantityElement).val() > 1) 
    {
    var newQuantity = parseInt($(inputQuantityElement).val()) - 1;
    var newPrice = newQuantity * price;
    save_to_db(cart_id, newQuantity, newPrice);
    }
}

function save_to_db(cart_id, new_quantity, newPrice) {
	var inputQuantityElement = $("#input-quantity-"+cart_id);
	var priceElement = $("#cart-price-"+cart_id);
    $.ajax({
		url: '{{ route('update.cart') }}',
        method: "patch",
            data: {
                _token: '{{ csrf_token() }}', 
                id: cart_id, 
                quantity: new_quantity
            },
		success : function(response) {
			$(inputQuantityElement).val(new_quantity);
            $(priceElement).text("$"+newPrice);
            var totalQuantity = 0;
            $("input[id*='input-quantity-']").each(function() {
                var cart_quantity = $(this).val();
                totalQuantity = parseInt(totalQuantity) + parseInt(cart_quantity);
            });
            $(".total-quantity").text(totalQuantity);
            var totalItemPrice = 0;
            $("div[id*='cart-price-']").each(function() {
                var cart_price = $(this).text().replace("$","");
                totalItemPrice = parseInt(totalItemPrice) + parseInt(cart_price);
            });


            var finalitem_price  =  '$'+(totalItemPrice-((totalItemPrice * 18)/100))

            $("#final-price").text(finalitem_price);

            $("#total-price").text(totalItemPrice);

            toastr.success('cart update successfully');
		}
	});
}




  
    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
  
        var ele = $(this);
  
        if(confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route('remove.from.cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
  
</script>
@endsection