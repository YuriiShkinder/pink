<?php

namespace App\Http\Controllers;

use App\Repositories\MenusRepository;
use Illuminate\Http\Request;
use App\Menu;
use App\Repositories\PortfoliosRepository;
class PortfolioController extends SiteController
{
    public function __construct(PortfoliosRepository $p_rep)
    {
        $this->p_rep=$p_rep;
        parent::__construct(new MenusRepository(new Menu()));
        $this->template=env('THEME').'.portfolios';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($cat_alias=false)
    {
        $this->title='Портфолио';
        $this->keywords='Портфолио';
        $this->meta_desc='Портфолио';
        $portfolios=$this->getPortfolios();
        $content=view(env('THEME').'.portfolios_content')->with('portfolios',$portfolios)->render();

        $this->vars=array_add($this->vars,'content',$content);

        return $this->renderOutput();
    }
    public function getPortfolios($take=false,$paginate=true){
        $portfolios=$this->p_rep->get('*',$take,$paginate);
        if($portfolios){
            $portfolios->load('filter');
        }
       return $portfolios;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($alias){
        $portfolio=$this->p_rep->one($alias);
        $portfolios=$this->getPortfolios(config('settings.other_portfolios'),false);

        $this->title=$portfolio->title;
        $this->keywords=$portfolio->keywords;
        $this->meta_desc=$portfolio->meta_desc;

        $content=view(env('THEME').'.portfolio_content')->with(['portfolio'=>$portfolio,'portfolios'=>$portfolios])->render();

        $this->vars=array_add($this->vars,'content',$content);
        return $this->renderOutput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
