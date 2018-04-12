<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Category;
use App\Http\Requests\ArticleRequest;
use App\Repositories\ArticlesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Gate;

class ArticlesController extends AdminController
{
    public function __construct(ArticlesRepository $a_rep)
    {

        $auth=parent::__construct();

        if(!$auth){
            return redirect()->route('login');
        }
        $this->template=env('THEME').".admin.articles";
        $this->a_rep=$a_rep;

        if(Gate::denies('VIEW_ADMIN_ARTICLES')){
            abort(403);
        }

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->title="Менеджер статтей";
        $articles=$this->getArticles();
        $this->content=view(env('THEME').'.admin.articles_content')->with('articles',$articles)->render();

        return $this->renderOutput();
    }

    public function getArticles(){
        return $this->a_rep->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('save',new \App\Article)){
            abort(403);
        }

        $this->title='Добавить...';
        $categorys=Category::select(['title','alias','parent_id','id'])->get();
        $list=[];
        foreach ($categorys as $category){
            if($category->parent_id==0){
                $list[$category->title]=[];
            }else{
                $list[$categorys->where('id',$category->parent_id)->first()->title][$category->id]=$category->title;
            }
        }
        $this->content=view(env('THEME').'.admin.articles_create_content')->with('categories',$list)->render();
        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
       $result=$this->a_rep ->addArticle($request);
       if(is_array($result)&& !empty($result['error'])){
           return back()->with($result);
       }

       return redirect('/admin')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        if(Gate::denies('edit', new Article())){
            abort(403);
        }

        $article->img=json_decode($article->img);
        $categorys=Category::select(['title','alias','parent_id','id'])->get();
        $list=[];
        foreach ($categorys as $category){
            if($category->parent_id==0){
                $list[$category->title]=[];
            }else{
                $list[$categorys->where('id',$category->parent_id)->first()->title][$category->id]=$category->title;
            }
        }

        $this->title='Edit';

        $this->content=view(env('THEME').'.admin.articles_create_content')->with(['categories'=>$list,'article'=>$article])->render();
        return $this->renderOutput();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {

        $result=$this->a_rep ->updateArticle($request,$article);
        if(is_array($result)&& !empty($result['error'])){
            return back()->with($result);
        }

        return redirect('/admin')->with($result);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {

        $result=$this->a_rep ->deleteArticle($article);
        if(is_array($result)&& !empty($result['error'])){
            return back()->with($result);
        }

        return redirect('/admin')->with($result);

    }
}
