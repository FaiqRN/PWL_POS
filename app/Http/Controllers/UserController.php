<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Level;
use App\Models\UserModel;
use Illuminate\Support\Facades\Log;

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
        dd($user->wasChanged(['nama','username']));*/

        $user = UserModel::all();
        return view('user',['data'=>$user]);

        //$user = UserModel::with('level')->get();
        //dd($user);

        $user=UserModel::with('level')->get();
        log::info('User data:',$user->toArray());
        return view('user',['data'=>$user]);
    }

    public function tambah(){
        return view('user_tambah');
    }

    public function tambah_simpan(Request $request){
        UserModel::create([
            'username'=>$request->username,
            'nama'=>$request->nama,
            'password'=>Hash::make('$request->password'),
            'level_id'=>$request->level_id
        ]);
        return redirect('/user');
    }

    public function ubah($id){
        $user = UserModel::where('user_id', $id)->firstOrFail();
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan($id, Request $request){
        $user = UserModel::where('user_id', $id)->firstOrFail();
        $user->username = $request->username;
        $user->nama = $request->nama;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->level_id = $request->level_id;
        $user->save();
        return redirect('/user');
    }

    public function hapus($id){
        $user=UserModel::find($id);
        $user->delete();
        return redirect('/user');
    }

}
