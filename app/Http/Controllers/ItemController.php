<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $category_id = $_GET['category_id']; error_reporting(E_ALL);
        $item = new Item();
        $items = $item->getTopItemsByCategory($category_id);

        if(count($items) > 0){
            $image = new Image();
            $_tmp_item_array = array();
            foreach ($items as $_item) {
                $default_image = $image->getDefaultImageByItem($_item['item_id']);
                $_item['default_image'] = $default_image[0]['image_name'];
                $_item['short_description'] = substr($_item['short_description'], 0,50)."...";
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
        $item_data[0]['images'] = $images;

        return view('items.showitem')->with('item',$item_data[0]);

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
