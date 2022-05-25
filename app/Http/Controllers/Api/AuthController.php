<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\isEmpty;

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

        if ($validasi->fails()) {
            $val = $validasi->errors()->all();
            return $this->responError($val[0]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telp' => $request->telp,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'status' => '1',
            'message' => 'Successfully created user!',
		    'data' => $user
        ], Response::HTTP_OK);
    }

    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (password_verify($request->password, $user->password)) {
                return response()->json([
                    'status' => '1',
                    'message'    => "Halo $user->name, Selamat Datang!",
			        'data' => $user
                ], Response::HTTP_OK);
            }
            return $this->responError("Kesalahan Input");
        } elseif ($request->email == null) {
            return $this->responError("Email Tidak Boleh Kosong`");
        } elseif (isEmpty($user)) {
            return $this->responError("Email Tidak Terdaftar");}
    }

    public function responError($pesan)
    {
        return response()->json([
            'status' => '0',
            'message'   => $pesan
        ], Response::HTTP_OK);
    }
}
