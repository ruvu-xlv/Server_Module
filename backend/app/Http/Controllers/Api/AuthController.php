<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password;

class AuthController extends Controller
{
    public function register(Request $request){
        $dataUser=new User();
        $rules = [
            'name'=>'required|unique:users.name|max:60|min:4',
            'password'=>'required',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Validasi Gagal',
                'data'=>$validator->errors()
            ]);
        }

        $dataUser->name=$request->name;
        $dataUser->password=$request->password;
        $dataUser->save();

        return response()->json([
            'status'=>true,
            'message'=>'Berhasil Register'
        ],201);

    }

    public function login(Request $request){
        $rules = [
            'name'=>'required',
            'password'=>'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Validasi Gagal',
                'data'=>$validator->errors()
            ]);
        }

        if(!Auth::attempt($request->only(['name','password']))){
            return response()->json([
                'status'=>false,
                'message'=>'Nama Pengguna atau Password salah.'
            ]);
        }

        $dataUser=User::where('name',$request->name)->first();
        return response()->json([
            'status'=>true,
            'message'=>'Berhasil Login',
            'token'=>$dataUser->createToken('login')->plainTextToken
        ]);
    }
}
