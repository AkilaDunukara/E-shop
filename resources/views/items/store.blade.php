@extends('layouts.home')
@section('title','Online Shopping for snow jackets - the store')
@section('content')

<div id="main">
		<div class="cl">&nbsp;</div>
		<br/><br/>

		@foreach($items as $category=>$_item)
			<h1 class="item-title">{{$category}}</h1>
			<br/>
			<!-- Products -->
            
			<div class="products store">
				<div class="cl">&nbsp;</div>
				<ul>
				@foreach($_item as $item)
				    <li style="margin-bottom:10px">
				    	<a href="#"><img width="300px" height="387px" src="{{URL::to('images/items/'.$item['item_id'].'/'.$item['default_image'])}}" alt="" /></a>
				    	<div class="product-info">
				    		<h3>{{$item['item_name']}}</h3>
				    		<div class="product-desc">
								<h4>{{$item['short_description']}}</h4>
				    			
				    			<strong class="price">{{$item['price']}}</strong>
                                <br>

								<a class="button-sm danger" href="javascript:;" onclick="addToCart({{$item['item_id']}})">Add To Cart</a>
				    		</div>
				    	</div>
			    	</li>
			    @endforeach
			    	
				</ul>
				<div class="cl">&nbsp;</div>
			</div><br>
			<!-- End Products -->
		@endforeach	
		
        
        
        
</div>
<!-- End Side Full -->		
		
@endsection