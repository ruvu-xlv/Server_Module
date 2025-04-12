<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
                'title'=>['required'],
                'description'=>['required'],
                'image'=>['nullable','image','max:3000'],
                'slug'=>['required'],
            ]);

            $imagePath=null;
            if($request->hasFile('image')){
                $file = $request->file('image');
                $imagePath = $file->store('games_img', 'public'); 
            }

            if($games=Game::create([
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
        try{

            $games = Game::find($id);
            if(!$games){
                return new ApiResource(false,'Data Game Tidak Ditemukan!!!',$games);
            }

            return new ApiResource(true,'Data Game ditemukan',$games);

        }catch(\Exception $e){
            return new ApiResource(true,"Caught Exception: {$e->getmessage()}",[]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => ['required'],
                'description' => ['required'],
                'slug'=>['required'],
                'image' => ['nullable', 'image', 'max:3048']
            ]);

            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors()->toArray(), []);
            }

            $games = Game::find($id);
            if (!$games) {
                return new ApiResource(false, 'Data Game tidak ditemukan', []);
            }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fotoPath = $file->store('games_img', 'public');

                if ($games->image && Storage::disk('public')->exists($games->image)) {
                    Storage::disk('public')->delete($games->image);
                }

                $games->image = $fotoPath;
            }

            $games->title = $request->title;
            $games->slug=$request->slug;
            $games->description = $request->description;
            $games->save();

            return new ApiResource(true, 'Data Game berhasil diupdate', $games);

        } catch (\Exception $e) {
            return new ApiResource(false, "Caught Exception: {$e->getMessage()}", []);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $games = Game::find($id);
            if (!$games) {
                return new ApiResource(false, 'Data Game tidak ditemukan', []);
            }
    
            // Hapus gambar jika ada
            if ($games->image && Storage::disk('public')->exists($games->image)) {
                Storage::disk('public')->delete($games->image);
            }
    
            $games->delete();
    
            return new ApiResource(true, 'Data Game berhasil dihapus', []);
        } catch (\Exception $e) {
            return new ApiResource(false, "Caught Exception: {$e->getMessage()}", []);
        }
    }
}
