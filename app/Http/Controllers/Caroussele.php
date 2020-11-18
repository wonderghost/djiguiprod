<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Caroussel;
use Illuminate\Http\Request;

class Caroussele extends Controller
{
    public function index()
    {
        return view('news/manage-caroussel')
                ->withCat(null);
    }

    public function store(Request $request)
    {
   
        try {

            $validation = $request->validate([
                'name'  =>  'required|string',
                'image' =>  'file'
            ]);

            if($request->hasFile('image')) {
                $extension = $request->file('image')->getClientOriginalExtension();
                $caroussel = new Caroussel;
                $caroussel->slug = Str::slug($request->input('name'));
                $caroussel->name = $request->input('name');
                $caroussel->image = Str::random(10).'_'.time().'.'.$extension;
                
                if($request->file('image')->move(config('image.path'),$caroussel->image)) {
                    $caroussel->save();
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

}
