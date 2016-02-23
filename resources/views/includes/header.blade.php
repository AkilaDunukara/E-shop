<!-- Header -->	
<?php
$item_cart = Request::cookie('item_cart');
if(!empty($item_cart)){
	$quantity = $item_cart['quantity'];
	$total = $item_cart['total'];
}else{
	$quantity = 0;
	$total = "$ 0.00";
}
?>
	<div id="header">
		<h1 id="logo"><a href="#"><img src="{{URL::to('css/images/logo.gif')}}"></a></h1>	
		
		<!-- Cart -->
		<div id="cart">
			<a href="/cart" class="cart-link">Your Shopping Cart</a>
			<div class="cl">&nbsp;</div>
			<span id="cart-quantity">Articles: <strong><?php echo $quantity; ?></strong></span>
			&nbsp;&nbsp;
			<span id="cart-total">Cost: <strong><?php echo $total; ?></strong></span>
		</div>
		<!-- End Cart -->
		
		<!-- Navigation -->
		<div id="navigation">
			<ul>
			    <li><a href="/">Home</a></li>
			    <li><a href="/support">Support</a></li>
			    <li><a href="/myaccount">My Account</a></li>
			    <li><a href="/store">The Store</a></li>
			    <li><a href="/contact">Contact</a></li>
			</ul>
		</div>
		<!-- End Navigation -->
	</div>
	<!-- End Header -->