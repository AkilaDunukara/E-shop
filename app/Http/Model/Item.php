<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Item extends Model
{
    protected $table = "items";

    /*
	 * Get all items from the table
     */
    public function getAll(){
    	$items = DB::table($this->table)
    				->get();
    	return Item::formatIteData($items);  
    }

      /**
     * Get Selected Item by ID
     * @param $id integere
     */

     public function getById($item_id){
    	$item = DB::table($this->table)
    				->where('id','=',$item_id)
    				->get();

    	//simple join query
    	return Item::formatData($item);  
    }

    public function getByItemName($item_name){
    	$item = DB::table($this->table)
    				->where('name','=',$item_name)
    				->get();

    	//simple join query
    	return Item::formatData($item);  
    }
    
    public function getTopItemsByCategory($category_id){

        $items = DB::table($this->table)
                    ->where('category_id',$category_id)
                    ->join('images',$this->table.'.id','=','images.item_id')
	   				->where('images.default_image','=','1')
                    ->skip(0)
                    ->take(3)
        			->select('images.name AS default_image',$this->table.'.*')
                   ->get();
        return Item::formatData($items);  
    }

    public function getAllItems(){
    	$items = DB::table($this->table)
	   				->join('categories',$this->table.'.category_id','=','categories.id')
	   				->join('images',$this->table.'.id','=','images.item_id')
	   				->where('images.default_image','=','1')
	   				->orderBy('category_id', 'asc')
       				->select('categories.name AS category_name','images.name AS image_name',$this->table.'.*')
  					->get();
    	return $items;
    }
    /**
     * Format Item data set 
     */
    private static function formatData($itemDataSet){
    	$_temp_item_data_set= [];
    	foreach($itemDataSet as $item){
    		$_item =[
    			'item_id'=>$item->id,
    			'category_id'=>$item->category_id,
    			'item_name'=>$item->name,
    			'description'=>$item->description,
                'short_description'=>$item->short_description,
    			'price'=>(double)$item->price
    		];
    		if(isset($item->default_image)){
    			$_item['default_image'] = $item->default_image;
    		}
    		$_temp_item_data_set[] = $_item;
    	}
    	return $_temp_item_data_set;
    }

    public static function displayPrice($price){
    	return "$ ".$price;
    }

    public static function addTotalAmount($item_cart){

        $_total = 0;
        $_quantity = 0;
    	foreach ($item_cart['items'] as $_item) {
            $_total += $_item['price']*$_item['quantity'];
            $_quantity += $_item['quantity'];
        }
        $item_cart['total'] = Item::displayPrice($_total);
        $item_cart['quantity'] = $_quantity;

        return $item_cart;
    }
}
