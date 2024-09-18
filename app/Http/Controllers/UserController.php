<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\UserModel;

class UserController extends Controller
{
    public function index(){
        //$user = UserModel::all();
        //return view('user',['data'=>$user]);

        /*$data = [
            'username' => 'customer-1',
            'Level_id' => 4,
            'nama' => 'pelanggan',
            'password' => Hash::make('12345'), 
        ];*/

        /*UserModel::insert($data);
        $user = UserModel::all();
        return view('user', ['data' => $user]);*/

        /*$data =[
            'nama'=> 'Pelanggan Pertama',
        ];
        UserModel::where('username','customer-1')->update($data);
        $user = UserModel::all();
        return view('user',['data'=>$user]);*/

        /*$data=[
            'level_id'=>2,
            'username'=>'manager_tiga',
            'nama'=>'manager 3',
            'password'=> Hash::make('12345')
        ];
        UserModel::create($data);
        $user = UserModel::all();
        return view('user',['data'=>$user]);*/

        //$user = UserModel::find(1);
        //return view('user',['data'=>$user]);

        //$user =UserModel::where('level_id',1)->first();
        //return view('user', ['data'=>$user]);

        //$user =UserModel::firstwhere('level_id',1);
        //return view('user', ['data'=>$user]);

        /*$user =UserModel::findOr(20,['username','nama'],function(){
            abort(404);
        });
        return view('user',['data'=>$user]);*/

        //$user= UserModel::findOrFail(1);
        //return view ('user',['data'=>$user]);

        //$user =UserModel::where('level_id', 2)->count();
        //dd($user);
        //return view ('user',['data'=>$userCount]);

        $userCount = UserModel::where('level_id', 2)->count();
        return view('user', ['data' => $userCount]);
    }
}
