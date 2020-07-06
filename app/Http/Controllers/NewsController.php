<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\AppException;

use App\Category;
use App\SubCategory;
use App\Article;
use Carbon\Carbon;

class NewsController extends Controller
{

    public function getDetails($slug , Article $a) {
        $article = $a->find($slug);
        return view('news.details')->withItem($article)
            ->withCat('news');
    }

    public function getInfoDetails(Request $request , Article $a) {
        try {
            $article = $a->find($request->input('slug'));
            
            $date = new Carbon($article->created_at);
            $date->setLocale('fr_FR');

            $data = [
                'name'  =>  $article->name,
                'description'   =>  $article->description,
                'image' =>  $article->image,
                'created_at'    =>  $date->toFormattedDateString(),
                'author'    =>  $article->author()->name,
                'cat'   =>  $article->subCategory()->first()->category(),
                'slug'  =>  $article->slug
            ];

            return response()
                ->json($data);
        } catch(AppException $e) {
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }
    //

    public function getList(Category $c , SubCategory $sc ,Article $a) {
        try {
            $art = $a->select()->orderBy('created_at','desc')->limit(100)->get();
            $data = [];

            foreach($art as $key => $value) {
                $data[$key] =[
                    'slug'  =>  $value->slug,
                    'name'  =>  $value->name,
                    'cat'   =>  $value->subCategory()->first()->category(),
                    'sub_cat'   =>  $value->subCategory()->first(),
                    'description'   =>  $value->description,
                    'date'  =>  $value->created_at,
                    'author'    =>  $value->author(),
                    'image' =>  $value->image
                ];
            }            

            return response()
                ->json([
                    'breaking'  =>  $a->select()->orderBy('created_at','desc')->limit(15)->get(),
                    'data'  =>  $data
                ]);
        } catch(AppException $e) {
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }

    public function index() {
        return view('news.news-home')
            ->withCat('news');
    }

    public function articleGetForm() {
        return view('news.add-article')
            ->withCat('null');
    }

    public function postCategory(Request $request) {
        try {
            $validation = $request->validate([
                'name'  =>  'required|string'
            ]);

            $cat = new Category;
            $cat->slug = Str::slug($request->input('name'));
            $cat->name = $request->input('name');
            $cat->save();            
            
            return response()
                ->json('done');

        } catch(AppException $e) {
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }

    public function postSubCategory(Request $request) {
        try {
            $validation = $request->validate([
                'name'  =>  'required|string',
                'cat'   =>  'required|string|exists:category,slug'
            ]);
            $subCat = new SubCategory;
            $subCat->slug = Str::slug($request->input('name'));
            $subCat->name = $request->input('name');
            $subCat->id_category = $request->input('cat');
            $subCat->save();
            return response()->json('done');
        } catch(AppException $e){
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }

    public function getCategoryList(Category $c , SubCategory $sc) {
        try {
            return response()->json([
                'category'  =>  $c->all(),
                'sub_category'  =>  $sc->all()
                ]);
        } catch(AppException $e) {
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }

    public function addArticle(Request $request) {
        try {

            $validation = $request->validate([
                'name'  =>  'required|string',
                'content'   =>  'required',
                'image' =>  'file'
            ]);

            if($request->hasFile('image')) {
                $extension = $request->file('image')->getClientOriginalExtension();
                $article = new Article;
                $article->slug = Str::slug($request->input('name'));
                $article->name = $request->input('name');
                $article->description = $request->input('content');
                $article->id_sub_category = $request->input('tag');
                $article->image = Str::random(10).'_'.time().'.'.$extension;
                $article->author = $request->user()->email;
                
                if($request->file('image')->move(config('image.path'),$article->image)) {
                    $article->save();
                    return response()
                        ->json('done');
                } else {
                    throw new AppException("Erreur de telechargement de l'image!");
                }
            } else {
                throw new AppException("Veuillez selectionnez une image!");
            }
        } catch(AppException $e) {
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }

    public function getNewsCategoryDetails($slug , Category $c) {
        $category = $c->find($slug);
        $subCategory = $category->subCategory();

        return view('news.news-category')->withData([
            'sub_category' => $subCategory,
            'category'  =>  $category,
            ])
            ->withCat('news');
    }

    public function getSubCat(Request $request , Category $c , SubCategory $sc) {
        try {
            $category = $c->find($request->input('category'));
            $subCategory = $category->subCategory();
            
            $data = [];
            $i = 0;
            foreach($subCategory as $key => $value) {
                $articles = $value->articles()->orderBy('created_at','desc')->limit(100)->get();
                foreach($articles as $_key => $_value) {
                    $date = new Carbon($_value->created_at);
                    $date->setLocale('fr_FR');
                    $data[$i++] = [
                        'slug'  =>  $_value->slug,
                        'name'  =>  $_value->name,
                        'created_at'    =>  $date->toFormattedDateString(),
                        'image' =>  $_value->image,
                        'description'   =>  $_value->description,
                        'id_sub_category'   =>  $_value->id_sub_category,
                        'author'    =>  $_value->author()->name
                    ];
                } 
            }

            return response()
                ->json([
                    'sub_category' => $subCategory,
                    'data'  =>  $data
                    ]);
        } catch(AppException $e) {
            header("Erreur!",true,422);
            die(json_encode($e->getMessage()));
        }
    }
}
