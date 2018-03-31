<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Repositories\MenusRepository;
use Illuminate\Http\Request;

class SiteController extends Controller
{
   protected $p_rep;
    protected $s_rep;
    protected $a_rep;
    protected $m_rep;

    protected $template;
    protected $vars=[];

    protected $contentRightBar=false;
    protected $contentLeftBar=false;

    protected $bar=false;

    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep=$m_rep;

    }

    protected function renderOutput()
    {

        $menu=$this->getMenu();
        $navigation = view(env('THEME') . '.navigation')->with('menu',$menu)->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        return view($this->template)->with($this->vars);

    }

    protected function getMenu(){
        $menu=$this->m_rep->get();

        $mBuilder=\Menu::make('MyNav',function ($m) use ($menu){
            foreach ($menu as $item){
                if($item->parent==0){
                    $m->add($item->title,$item->path)->id($item->id);
                }else{
                    if($m->find($item->parent)){
                        $m->find($item->parent)->add($item->title,$item->path)->id($item->id);
                    }

                }
            }
        });


        return $mBuilder;

    }
}
