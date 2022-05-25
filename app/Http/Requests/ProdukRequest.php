<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kategori_produk' => 'required',
            'nama_produk' => 'required',
            'harga_produk'  => 'required|numeric',
            'deskripsi_produk' => 'required',
            'gambar_produk' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kategori_produk.required' => 'Kategori Produk tidak boleh kosong',
            'nama_produk.required' => 'Nama Produk tidak boleh kosong',
            'harga_produk.required' => 'Harga Produk tidak boleh kosong',
            'deskripsi_produk.required' => 'Deskripsi Produk tidak boleh kosong',
            'gambar_produk.required' => 'Gambar Produk tidak boleh kosong',
        ];
    }
}
