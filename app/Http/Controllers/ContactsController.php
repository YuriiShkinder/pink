<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\Repositories\MenusRepository;
class ContactsController extends SiteController
{
    public function __construct()
    {
        parent::__construct(new MenusRepository(new Menu()));
        $this->template=env('THEME').'.contacts';
        $this->bar='left';
    }
    public function index(Request $request)
    {
        $this->title='Contact';
    $content=view(env('THEME').'.contact_content')->render();
    $this->vars=array_add($this->vars,'content',$content);
    $this->contentLeftBar=view(env('THEME').'.contact_bar')->render();

    return $this->renderOutput();
    }
}
