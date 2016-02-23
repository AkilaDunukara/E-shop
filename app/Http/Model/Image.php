<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Image extends Model
{
    protected $table = "images";

    public function getAllByItemId($item_id){
    	$images = DB::table($this->table)
                    ->where('item_id',$item_id)
                    ->get();
        return Image::formatData($images);
    }

    public function getDefaultImageByItem($item_id){
    	$image = DB::table($this->table)
    				->where('item_id',$item_id)
    				->where('default_image','1')
    				->get();

    	return Image::formatData($image);
    }

    private static function formatData($imageDataSet){
    	$_temp_image_data_set= [];
    	foreach($imageDataSet as $image){
    		$_image =[
    			'image_id'=>$image->id,
    			'item_id'=>$image->item_id,
    			'image_name'=>$image->name,
    			'default_image'=>$image->default_image
    		];
    		$_temp_image_data_set[] = $_image;
    	}
    	return $_temp_image_data_set;
    }
}
