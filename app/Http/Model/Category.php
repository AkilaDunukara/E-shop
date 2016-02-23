<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model
{
    protected $table = "categories";

    public function getAll(){
    	$categories = DB::table($this->table)
    				->get();
    	return Category::formatData($categories);  
    }

     /**
     * Format Item data set 
     */
    private static function formatData($categoryDataSet){
    	$_temp_category_data_set= [];
    	foreach($categoryDataSet as $category){
    		$_category =[
    			'category_id'=>$category->id,
    			'category_name'=>$category->name,
    			'description'=>$category->description
    		];
    		$_temp_category_data_set[] = $_category;
    	}
    	return $_temp_category_data_set;
    }
}
