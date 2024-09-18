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

        //$userCount = UserModel::where('level_id', 2)->count();
        //return view('user', ['data' => $userCount]);

        /*$user = UserModel::firstOrCreate(
            [
                'username'=>'manager',
                'nama'=>'manager'
            ]
        );
        return view('user',['data'=>$user]);*/

        /*$user = UserModel::firstOrCreate(
            [
                'username'=>'manager22',
                'nama'=>'manager Dua Dua',
                'password'=> Hash::make('12345'),
                'level_id'=> 2
            ],
        );
        return view ('user',['data'=>$user]);*/

        /*$user = UserModel::firstOrNew(
            [
                'username'=>'manager',
                'nama'=>'manager'
            ]
        );
        return view('user',['data'=>$user]);*/

            /*$user = UserModel::firstOrNew(
            [
                'username'=>'manager33',
                'nama'=>'manager Tiga Tiga',
                'password'=> Hash::make('12345'),
                'level_id'=> 2
            ],
        );
        $user-> save();
        return view ('user',['data'=>$user]);*/

        /*$user = UserModel::create([
            'username'=>'manager55',
            'nama'=>'manager55',
            'password'=> Hash::make('12345'),
            'level_id'=> 2,
        ]);

        $user->username='manager55';

        $user->isDirty();
        $user->isDirty('username');
        $user->isDirty('nama');
        $user->isDirty(['nama','username']);
        
        $user->isClean();
        $user->isClean('username');
        $user->isClean('nama');
        $user->isClean(['nama','username']);

        $user->save();

        $user->isDirty();
        $user->isClean();
        dd($user->isDirty());*/

        /*$user =UserModel::create([
            'username'=>'manager11',
            'nama'=>'manager 11',
            'password'=> Hash::make('12345'),
            'level_id'=>2,
        ]);
        $user->username ='manager12';
        $user->save();

        $user->wasChanged();
        $user->wasChanged('username');
        $user->wasChanged(['username','level_id']);
        $user->wasChanged('nama');
        $user->wasChanged(['nama','username']);*/


        $user =UserModel::create([
            'username'=>'manager11',
            'nama'=>'manager 11',
            'password'=> Hash::make('12345'),
            'level_id'=>2,
        ]);
        $user->username ='manager12';
        $user->save();

        $user->wasChanged();
        $user->wasChanged('username');
        $user->wasChanged(['username','level_id']);
        $user->wasChanged('nama');
        dd($user->wasChanged(['nama','username']));
    }
}
