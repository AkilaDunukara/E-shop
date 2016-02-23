<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\Category;
use App\Http\Model\Item;
use App\Http\Model\Image;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = new Category();
        $categories = $category->getAll();
        //$categories = json_decode(json_encode($categories));
        //echo "<pre>";
        //print_r($categories);
        return view('items.showindex')->with('categories', $categories);
    }

    public function getTopItemsByCategory(){

        $category_id = $_GET['category_id']; 
        $item = new Item();
        $items = $item->getTopItemsByCategory($category_id);

        if(count($items) > 0){
            $_tmp_item_array = array();
            foreach ($items as $_item) {
                $_item['short_description'] = substr($_item['short_description'], 0,50)."...";
                $_item['price'] = Item::displayPrice($_item['price']);
                $_tmp_item_array[] = $_item;
            }
            $items = $_tmp_item_array;
        }

        $output =[];
        if(count($items) <= 0){
            $output =[
                'status'=>400,
                'message'=>'List Empty'
            ];
            return json_encode($output);
        }
        $output =[
            'status'=>200,
            'message'=>'Items found',
            'items'=>$items
        ];
        return json_encode($output);
    }

    public function getByItemName($item_name){
        $item = new Item();
        $item_data = $item->getByItemName($item_name);

        $image = new Image();
        $images = $image->getAllByItemId($item_data[0]['item_id']);

        //get default image
        for($i=0; $i<count($images); $i++){
            if($images[$i]['default_image']==1){
                $item_data[0]['default_image'] = $images[$i]['image_name'];
                unset($images[$i]);//unset default image row
                $images = array_values($images);//reset array values
            }
        }
        $item_data[0]['price']  = Item::displayPrice($item_data[0]['price']);
        $item_data[0]['images'] = $images;

        return view('items.showitem')->with('item',$item_data[0]);

    }
    /**
     * Add item to shopping cart
     */
    public function addToCart(Request $request){

        $item_id = $_GET['item_id'];
        
        $item_cart = $request->cookie('item_cart'); //print_r($item_cart);
        $item = new Item();
        $item_data = $item->getById($item_id);     
 
        $response  = new Response(view('includes.header'));

        $new_item = true;
        for ($i=0; $i<count($item_cart['items']); $i++) {
            $_item = $item_cart['items'][$i];
            if($item_id==$_item['item_id']){//item already in the cart.increase quantity
                $_item['quantity'] += 1;
                $_item['sub_total'] = Item::displayPrice($_item['quantity']*$item_data[0]['price']);
                $new_item = false;
                $item_cart['items'][$i] = $_item;//assign updated item into item cart array
            }
        }
        if($new_item){
           $item_cart['items'][] = array('item_id'=>$item_data[0]['item_id'],'quantity'=>1,'price'=>$item_data[0]['price'],'name'=>$item_data[0]['item_name'],'display_price'=>Item::displayPrice($item_data[0]['price']), 'sub_total'=>Item::displayPrice($item_data[0]['price']));
        }

        $item_cart = Item::addTotalAmount($item_cart);

        $response->withCookie('item_cart', $item_cart, 1800000);
        
        $output =[
            'status'=>200,
            'message'=>'Items found',
            'cart'=>$item_cart
        ];
        return $response;

    }

    public function removeFromCart(Request $request){

        echo $array_index = $_GET['array_index'];
        $item_cart = $request->cookie('item_cart'); //print_r($item_cart);

        unset($item_cart['items'][$array_index]); 
        $item_cart['items'] = array_values($item_cart['items']);
        $item_cart = Item::addTotalAmount($item_cart); //print_r($item_cart);

        
        $response  = new Response(view('includes.header'));
        $response->withCookie('item_cart', $item_cart, 1800000);
        return $response;
    }

    public function showCart(Request $request){
        $item_cart = $request->cookie('item_cart');
        return view('items.cart')->with('item_cart',$item_cart);
    }

    public function showStore(){

        $_item = new Item();
        $items = $_item->getAllItems();

        $result = [];
        foreach($items as $item){

            $_item =[
                'item_id'=>$item->id,
                'category_id'=>$item->category_id,
                'item_name'=>ucwords($item->name),
                'description'=>$item->description,
                'short_description'=>substr($item->short_description,0,40).'...',
                'price'=>Item::displayPrice($item->price),
                'default_image'=>$item->image_name
            ];
            $category = ucwords($item->category_name);
            if (isset($result[$category])) {
               $result[$category][] = $_item;
            } else {
               $result[$category] = array($_item);
            }
 
        }
        // echo "<pre>";
        // print_r($result);
        return view('items.store')->with('items',$result);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
