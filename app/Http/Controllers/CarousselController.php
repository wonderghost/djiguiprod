<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Caroussel;
use Illuminate\Http\Request;

class CarousselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('news/manage-caroussel')
                ->withCat(null);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $caroussel = Caroussel::paginate(3);
        return response()->json($caroussel);   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
                $caroussel->state = false;
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Caroussel  $caroussel
     * @return \Illuminate\Http\Response
     */
    public function show(Caroussel $caroussel)
    {
        //
    }

    // fonction de restauration  des articles   
    public function activeBanner(Request $request) {

        // return response()
        //         ->json($request);
        try{
            $caroussel = Caroussel::find(request()->slug);

            $caroussel->state = true;
            $caroussel->update();
            return response()
                    ->json($caroussel);
        }
        catch(AppException $e){
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }

    public function blockBanner(Request $request) {

        // return response()
        //         ->json($request);
        try{
            $caroussel = Caroussel::find(request()->slug);

            $caroussel->state = false;
            $caroussel->update();
            return response()
                    ->json($caroussel);
        }
        catch(AppException $e){
            header("Erreur",true,422);
            die(json_encode($e->getMessage()));
        }
    }
// fin


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Caroussel  $caroussel
     * @return \Illuminate\Http\Response
     */
    public function edit(Caroussel $caroussel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Caroussel  $caroussel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Caroussel $caroussel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Caroussel  $caroussel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caroussel $caroussel)
    {
        //
    }
}
