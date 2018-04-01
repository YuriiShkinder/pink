<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 30.03.18
 * Time: 17:09
 */

namespace App\Repositories;
use Config;

abstract class Repository{
protected $model;

public function get($select='*',$take=false,$pagination=false,$where=false){
    $builder=$this->model->select($select);

    if($take){
        $builder->take($take);
    }
    if($where){
        $builder->where($where[0],$where[1]);
    }

    if($pagination){
      return $this->check($builder->paginate(Config::get('settings.paginate')));
    }

    return  $this->check( $builder->get());
}

public function one($alias,$attr=[]){
   return $this->model->where('alias',$alias)->first();
}

protected function check($result){
    if($result->isEmpty()){
        return false;
    }
    $result->transform(function ($item,$key){
        if(is_string($item->img)&& is_object(json_decode($item->img))&& (json_last_error()==JSON_ERROR_NONE)){
            $item->img=json_decode($item->img);
        }

        return $item;
    });

    return $result;
}

}