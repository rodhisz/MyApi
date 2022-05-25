<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProdukApiController extends Controller
{
    public function getProduk()
    {
        //get all data from database
        $produk = Produk::orderby('id', 'desc')->get();

        //return json response
        return response()->json([
            'status' => 1,
            'message' => 'Get data produk berhasil',
            'produk' => $produk
        ],Response::HTTP_OK);
    }
}
