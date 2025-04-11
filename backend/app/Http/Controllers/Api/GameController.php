<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            $games=Game::latest()->paginate(10);
            return new ApiResource(true,'List data Game',$games);

        }catch(\Exception $e){
            return new ApiResource(false,"Caught Exception{$e->getMessage()}",[]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $validator=Validator::make($request->all(),[
                'siput'=>['required'],
                'title'=>['required'],
                'description'=>['required'],
                'image'=>['nullable','image','max:3000'],
            ]);

            $validator['slug'] = Str::slug($request->title. '-' . Str::random());


            $imagePath=null;
            if($request->hasFile('image')){
                $file = $request->file('image');
                $imagePath = $file->store('games_img', 'public'); 
            }

            if($games=Game::create([
                'siput'=>$request->siput,
                'title'=>$request->title,
                'description'=>$request->description,
                'image'=>$imagePath,
                'slug'=>$request->slug,
            ])){
                return new ApiResource(true,'Data Game berhasil ditambahkan',$games);
            }

            return new ApiResource(false,'Terjadi Kesalahan',$games);

        }catch(\Exception $e){
            return new ApiResource(false,"Caught Exception:{$e->getMessage()}",[]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
