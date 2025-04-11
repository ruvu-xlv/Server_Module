<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){
        try{

            $dataUser=User::latest()->paginate(6);
            return new ApiResource(true,'List data user',$dataUser);

        }catch(\Exception $e){
            return new ApiResource(false,"Caught Exception:{$e->getMessage()}",[]);
        }
    }
}
