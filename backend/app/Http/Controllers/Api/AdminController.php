<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request){
        $dataUser = User::latest()->paginate(5);
        return response()->json([
            'status'=>true,
            
        ]);
    }
}
