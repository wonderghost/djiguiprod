<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\AppException;
use App\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    //

    public function __construct() {
        // $this->middleware('auth');
    }

    public function aboutUs() {
        return view('pages.about-us')
            ->withCat('main');
    }

    public function index() {
        return view('pages.home-pages')
            ->withCat('null');
    }

    public function prestationIndex() {
        return view('pages.prestations-index')
            ->withCat('home');
    }

    public function prestationDetails($slug) {
        return view('pages.prestations-details')
            ->withSlug($slug)
            ->withCat('home');
    }

    public function getPrestationDetails(Request $request , Page $p) {
        try {
            $details = $p->find($request->input('slug'));
            
            return response()
                ->json($details);

        } catch(AppException $e) {
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }

    public function addPage(Request $request , Page $p) {
        try {
            $validation = $request->validate([
                'title' =>  'required|string',
                'content'   =>  'required|string',
                'tag'   =>  'required|string'
            ],[
                'required'  =>  '`:attribute` est obligatoire !'
            ]);

            $p->title = $request->input('title');
            $p->tag = $request->input('tag');
            $p->content = $request->input('content');
            $p->slug = Str::slug($request->input('title'));
            $p->save();
            return response() 
                ->json('done');
        } catch(AppException $e) {
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }

    public function getListPage(Page $p) {
        try {
            return response()
                ->json($p->all());
        } catch(AppException $e) {
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }

// fonction de traitement des pages 
    public function EditPage($slug) {

         $page = Page::find($slug);

        return response()->json($page);
    }

    public function deletePage (Request $request){

        $page = Page::find(request()->slug);

        $page->delete();

        return response()
                ->json('deleted with success');

    }

    public function pageUpdate(Request $request) {

         try{
            $page = Page::find(request()->slug);

            $page->title = $request->input('title');
            $page->content = $request->input('content');
            $page->tag = $request->input('tag');
            $page->update();
            return response()
                    ->json('Updated with success');
        }
        catch(AppException $e){
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }
// fin
}
