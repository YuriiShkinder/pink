<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 01.04.18
 * Time: 10:46
 */

namespace App\Repositories;

use Gate;
use App\Article;
use Image;
use Config;

class ArticlesRepository extends Repository
{
    public function __construct(Article $articles)
    {
        $this->model = $articles;
    }

    public function one($alias, $attr = [])
    {
        $articles = parent::one($alias, $attr);
        if ($articles && !empty($attr)) {

            $articles->load('comments');
            $articles->comments->load('user');
        }
        return $articles;
    }

    public function addArticle($request)
    {
        if (Gate::denies('save', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token', 'image');


        if (empty($data)) {
            return ['error' => 'нет данных'];
        }

        if (empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }
        if ($this->one($data['alias'])) {
            $request->merge(['alias' => $data['alias']]);
            $request->flash();
            return ['error' => 'Занято'];
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $str = str_random(8);
                $obj = new \stdClass();
                $obj->mini = $str . '_mini.jpg';
                $obj->max = $str . '_max.jpg';
                $obj->path = $str . '.jpg';

                $img = Image::make($image);


                $img->fit(Config::get('settings.image')['width'], Config::get('settings.image')['heigth'])
                    ->save(public_path() . '/' . env('THEME') . '/images/articles/' . $obj->path);
                $img->fit(Config::get('settings.articles_img')['max']['width'], Config::get('settings.articles_img')['max']['heigth'])
                    ->save(public_path() . '/' . env('THEME') . '/images/articles/' . $obj->max);
                $img->fit(Config::get('settings.articles_img')['mini']['width'], Config::get('settings.articles_img')['mini']['heigth'])
                    ->save(public_path() . '/' . env('THEME') . '/images/articles/' . $obj->mini);

                $data['img'] = json_encode($obj);
                $this->model->fill($data);

                if ($request->user()->articles()->save($this->model)) {
                    return ['status' => 'Материал добавлен'];
                }
            }
        }
    }

    public function updateArticle($request, $article)
    {
        if (Gate::denies('edit', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token', 'image','_method','old_image');



        if (empty($data)) {
            return ['error' => 'нет данных'];
        }

        if (empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }
        $result=$this->one($data['alias']);

        if (isset($result) && ($result->id !== $article->id)) {
            $request->merge(['alias' => $data['alias']]);
            $request->flash();
            return ['error' => 'Занято'];
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $str = str_random(8);
                $obj = new \stdClass();
                $obj->mini = $str . '_mini.jpg';
                $obj->max = $str . '_max.jpg';
                $obj->path = $str . '.jpg';

                $img = Image::make($image);


                $img->fit(Config::get('settings.image')['width'], Config::get('settings.image')['heigth'])
                    ->save(public_path() . '/' . env('THEME') . '/images/articles/' . $obj->path);
                $img->fit(Config::get('settings.articles_img')['max']['width'], Config::get('settings.articles_img')['max']['heigth'])
                    ->save(public_path() . '/' . env('THEME') . '/images/articles/' . $obj->max);
                $img->fit(Config::get('settings.articles_img')['mini']['width'], Config::get('settings.articles_img')['mini']['heigth'])
                    ->save(public_path() . '/' . env('THEME') . '/images/articles/' . $obj->mini);

                $data['img'] = json_encode($obj);

            }

        }
        $article->fill($data);

        if ($article->update()) {
            return ['status' => 'Материал обновлен'];
        }
    }

    public function  deleteArticle($article){
        if(Gate::denies('destroy',$article)){
            abort(403);
        }

        $article->comments()->delete();

        if($article->delete()){
            return ['status'=>'Материал удален'];
        }
    }
}


