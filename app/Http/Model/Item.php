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
                    ->skip(0)
                    ->take(3)
                    ->get();
        return Item::formatData($items);  
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
    			'price'=>$item->price
    		];
    		$_temp_item_data_set[] = $_item;
    	}
    	return $_temp_item_data_set;
    }

}
