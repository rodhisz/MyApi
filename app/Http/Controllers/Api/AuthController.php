<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function register(Request $request)
    {

        $pesan = [
            'name.required'         => "Nama Tidak Boleh Kosong",

            'email.required'        => "Email Tidak Boleh Kosong",
            'email.unique'          => "Email Telah Terdaftar",
            'email.email'           => "Email Tidak Valid",

            'password.required'     => "Password Tidak Boleh Kosong",
            'password.min'          => "Password Tidak Boleh Kurang Dari 6"
        ];

        $validasi = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telp' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
        ], $pesan);

        if($validasi->fails()){
            $val = $validasi->errors()->all();
            return $this -> responError($val[0]);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telp' => $request->telp,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'status' => 'Success',
            'message' => 'Successfully created user!'
        ], Response::HTTP_OK);
    }

    public function login(Request $request){

        $user = User::where('email', $request->email)->first();

        if($user){
            if(password_verify($request->password, $user->password)){
                return response()->json([
                    'pesan'    => "Halo $user->name, Selamat Datang!",
                ],Response::HTTP_OK);
            }
                return $this -> responError("Password Salah");
        } elseif($request->email == null){
            return $this -> responError("Email Tidak Boleh Kosong`");
        }
    }

    public function responError($pesan)
    {
        return response()->json([
            'message'   => $pesan
        ], Response::HTTP_UNAUTHORIZED);
    }
}
