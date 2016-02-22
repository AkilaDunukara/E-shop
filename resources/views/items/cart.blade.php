@extends('layouts.home')
@section('title','Shopping Cart')
@section('content')

<div id="main">
		<div class="cl">&nbsp;</div>
		<h1 class="item-title">My Shopping Cart</h1>
		<br>

		@if(count($item_cart['items']) > 0)
		<table class="table" width="950" align="center">
		<colgroup>
			<col width="300">
			<col width="150">
			<col width="200">
			<col width="200">
			<col width="100">
		</colgroup>
		<thead>
			<tr class="first-row">
				<th>Item</th>
				<th class="text-right">Quantity</th>
				<th class="text-right">Price</th>
				<th class="text-right">Sub Total</th>
				<th class="text-center"></th>
			</tr>
		</thead>
		<tbody>

		@for($i = 0; $i < count($item_cart['items']); $i++ )
			<tr>
			<td><span>{{$item_cart['items'][$i]['name']}}</span></td>
			<td class="text-right"><span>{{$item_cart['items'][$i]['quantity']}}</span></td>
			<td class="text-right"><span>{{$item_cart['items'][$i]['display_price']}}</span></td>
			<td class="text-right"><span>{{$item_cart['items'][$i]['sub_total']}}</span></td>
			<td class="text-center"><span class="remove"><a href="javascript:;" onclick="removeFromCart({{$i}});">X</a></span></td>
			</tr>
		@endfor
		
		<tr class="last-row">
			<td colspan="3" class="text-right"><h1>Total</h1></td>
			<td class="text-right"><h1>{{$item_cart['total']}}</h1></td>
		</tr>
			
		</tbody>
		</table>
		@endif
		
		<div class="cl">&nbsp;</div>
		<br><br>
		<br><br>
	</div>
	<!-- End Main -->
@endsection