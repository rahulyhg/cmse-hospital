<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\Node;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;
    //protected $table = "categories";
    protected $fillable = ['name'];

    public function stringPath($spaceStyle)
    {
        $parent = $this->parent;
        $num = $this->getAncestors()->count();
        $space = '';
        for($num;$num>0;$num--){
            $space .= $spaceStyle;
        }
        return $space . $this->name;
        //return $parent ? $parent->stringPath() . '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->name : $this->name;

    }

    public function items(){
        return $this->hasMany('App\Models\Item','category_id','id');
    }
}
