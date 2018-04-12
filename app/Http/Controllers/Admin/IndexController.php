<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;
class IndexController extends AdminController
{
    public function __construct()
    {
        $auth=parent::__construct();

        if(!$auth){
            return redirect()->route('login');
        }
        $this->template=env('THEME').".admin.index";

        if(Gate::denies('VIEW_ADMIN')){
            abort(403);
        }
    }

    public function index(){

        $this->title='Панель администратора';


        return $this->renderOutput();
    }

}
