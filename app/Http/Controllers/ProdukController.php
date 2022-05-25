<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdukRequest;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function addProduk(ProdukRequest $request) {
        $fileName = '';
        if ($request->gambar_produk->getClientOriginalName()) {
            $file = str_replace(' ', '', $request->gambar_produk->getClientOriginalName());
            $fileName = date('mYdHs') . rand(1, 999) . '_' . $file;
            $request->gambar_produk->storeAs('public/produk', $fileName); //direktori ada pada folder STORAGE/APP/PUBLIC/PRODUK
            // php artisan storage:link -> untuk bisa akses gambarnya
        }

        Produk::create(array_merge($request->all(), [
            'gambar_produk' => $fileName
        ]));
        return redirect('home');
    }
}
