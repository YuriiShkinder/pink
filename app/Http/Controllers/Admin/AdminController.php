<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Gate;

class AdminController extends Controller
{
    protected $p_rep;
    protected $a_rep;
    protected $user;
    protected $template;
    protected $content=false;
    protected $title;
    protected $vars=[];


    public function __construct()
    {
        $this->user=Auth::user();
        if(!$this->user){
           return false;
        }
        return true;
    }


    public function renderOutput()
    {
        $this->vars=array_add($this->vars,'title',$this->title);
        $menu=$this->getMenu();
        $navigation=view(env('THEME').'.admin.navigation')->with('menu',$menu)->render();
        $this->vars=array_add($this->vars,'navigation',$navigation);
        if($this->content){
            $this->vars=array_add($this->vars,'content',$this->content);
        }

        $footer=view(env('THEME').'.admin.footer')->render();
        $this->vars=array_add($this->vars,'footer',$footer);

        return view($this->template)->with($this->vars);
    }

    public function getMenu() {
        return \Menu::make('adminMenu', function($menu) {
            if(Gate::allows('VIEW_ADMIN_ARTICLES')){

                $menu->add('Статьи',array('route'  => 'admin.articles.index'));
            }
            $menu->add('Портфолио',  array('route'  => 'admin.portfolios.index'));
            $menu->add('Меню',  array('route'  => 'admin.menus.index'));
            $menu->add('Пользователи',  array('route'  => 'admin.users.index'));
            $menu->add('Привилегии',  array('route'  => 'admin.permissions.index'));

        });
    }


}
