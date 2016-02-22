function _init_slider(carousel) {
	$('#slider-nav a').bind('click', function() {
		var index = $(this).parent().find('a').index(this);
		carousel.scroll( index + 1);
		return false;
	});
};

function _active_slide(carousel, item, idx, state) {
	var index = idx-1;
	$('#slider-nav a').removeClass('active');
	$('#slider-nav a').eq(index).addClass('active');
};

function _init_more_products(carousel) {
	$('.more-nav .next').bind('click', function() {
		carousel.next();
		return false;
	});
	
	$('.more-nav .prev').bind('click', function() {
		carousel.prev();
		return false;
	});
};
$(function() {

	var full_path = location.pathname.split("/")[1];

	if(full_path == ""){
		$('#navigation a[href^="/' + full_path + '"]').removeClass('active');
		$('#navigation li:first-child a').addClass('active');
	}else{
		$('#navigation a[href^="/' + full_path + '"]').addClass('active');
	}
});
$(document).ready(function() {
	showProductsByCategory(1);
	$("#slider-holder ul").jcarousel({
		scroll: 1,
		auto: 6,
		wrap: 'both',
		initCallback: _init_slider,
		itemFirstInCallback: _active_slide,
		buttonNextHTML: null,
		buttonPrevHTML: null
	});
	
	$(".more-products-holder ul").jcarousel({
		scroll: 2,
		auto: 5,
		wrap: 'both',
		initCallback: _init_more_products,
		buttonNextHTML: null,
		buttonPrevHTML: null
	});

	

});


//show relevent products of the selected category
function showProductsByCategory(category_id){

	$.ajax({
		method: 'GET',
		url : '/showproducts/{category_id}',
		data: {category_id : category_id},
		type:"JSON",
		success: function(data){
			var data = JSON.parse(data);//PARSE SERVER DATA AS ACTUAL JSON OBJECT
				
			if(parseInt(data.status) === 200){
				itemTmeplate(data.items)
			}else{
				$("#items_list").html("<h1 style='text-align:center;color:red'>No Items Found</h1>");
			}
		}
	});
}

function itemTmeplate(itemList){
	var _html ='';
	for(var i =0;i< itemList.length;i++){
		var item = itemList[i];
		var _class = '';

		if(((i+1)%3) == 0){
			_class = 'last';
		}
	 	_html +='<li class="'+_class+'">';
	 	_html +='<a href="/item/'+item.item_name+'"><img width="300px" height="387px" src="images/items/'+item.item_id+'/'+item.default_image+'" alt="" /></a>';
		_html +='<div class="product-info">';
		_html +='<h3><a style="text-decoration:none;color:white" href="/item/'+item.item_name+'">'+item.item_name+'</a></h3>'
		_html +='<div class="product-desc">';	  
		_html +='<h4>'+item.short_description+'</h4>';		  
		_html +='<strong class="price">'+item.price+'</strong>';	
		_html +='<a class="button-sm">Add To Cart</a>';			
		_html +='</div></div>';		    
		_html +='</li>';	
	};
	
	$("#items_list").html(_html);       										
									
}