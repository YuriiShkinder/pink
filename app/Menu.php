<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded=[];


    public function delete($options=[])
    {
        $child=self::where('parent',$this->id);
        $child->delete();
        return parent::delete($options);
    }
}
