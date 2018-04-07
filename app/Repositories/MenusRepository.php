<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 30.03.18
 * Time: 17:06
 */
namespace App\Repositories;

use App\Menu;
use Gate;
class MenusRepository extends Repository {

    public function __construct(Menu $menu)
    {
        $this->model=$menu;
    }

    public function addMenu($request){
        if(Gate::denies('save',$this->model)){
        abort(403);
        }
        $data=$request->only('type','title','parent');

        if(empty($data)){
            return ['error'=>'Нет данных'];
        }

        switch ($data['type']){
           case 'customLink' :
        $data['path']=$request->input('custom_link');

           break;

            case 'blogLink':
                if($request->input('category_alias')){
                    if($request->input('category_alias') == 'parent'){
                        $data['path']=route('articles.index');
                    }else{
                        $data['path']=route('articlesCat',['cat_alias'=>$request->category_alias]);
                    }
                }elseif ($request->input('article_alias')){
                    $data['path']=route('articles.show',['alias'=>$request->article_alias]);
                }

                break;

            case 'portfolioLink':
                if($request->input('filter_alias')){
                    if($request->input('filter_alias') == 'parent'){
                        $data['path']=route('portfolios.index');
                    }

                }elseif ($request->input('portfolio_alias')){
                    $data['path']=route('portfolios.show',['alias'=>$request->portfolio_alias]);
                }
                break;
        }
        unset($data['type']);

       if( $this->model->fill($data)->save()){
           return ['status'=>'Добавлено'];
       }
        dd($data);
    }
}