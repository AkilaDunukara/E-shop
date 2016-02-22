@extends('layouts.home')
@section('title','Item View')
@section('content')

<div id="main">
		<div class="cl">&nbsp;</div>
		<h1 class="item-title">{{$item['item_name']}}</h1>
		<br>
		<!-- Content -->
		<div id="content-item">
			<h4>{{$item['short_description']}}</h4>
			<br><br>

			<h1 class="item-price">Price : {{$item['price']}}</h1>

			<br><br>

			<a class="button xl danger">Add To Cart</a>
		</div>
		<!-- End Content -->
		
		<!-- Sidebar -->
		<div id="sidebar-item">
		<!-- Categories -->
			<div class="box ">
				<div class="box-content">
					<ul>
						<li class="first"><img src="{{URL::to('images/items/'.$item['item_id'].'/'.$item['default_image'])}}"></li>
						@foreach($item['images'] as $image)
					    	<li><img src="{{URL::to('images/items/'.$item['item_id'].'/'.$image['image_name'])}}"></li>
					    @endforeach
					</ul>
				</div>
			</div>
			<!-- End Categories -->
			
		</div>
		<!-- End Sidebar -->
		
		<div class="cl">&nbsp;</div>
		<br><br>
		<h1>Item Description</h1>
		<br><br>
		<div class="item-desc">{{$item['description']}}</div>
		<br><br>
	</div>
	<!-- End Main -->
@endsection