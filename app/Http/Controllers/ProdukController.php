<?php

namespace App\Http\Controllers;

use App\Models\produk;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreprodukRequest;
use App\Http\Requests\UpdateprodukRequest;
use Illuminate\Http\Request;
use Mockery\Undefined;

class ProdukController extends Controller
{
    public function ViewProduk()
    {
        $produk = Produk::all();
        return view('produk', ['produk' => $produk]);
    }

    public function CreateProduk(Request $request)
    {
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = time() . '_' . $imageFile->getClientOriginalName();
            $imageFile->storeAs('public/images', $imageName);
        }
        Produk::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'jumlah_produk' => $request->jumlah_produk,
            'image' => $imageName
        ]);
        return redirect()->back()->with("berhasil", "produk berhasil di tambahkan!");
    }
    public function DeleteProduk($kode_produk)
    {
        produk::where('kode_produk', $kode_produk)->delete();

        return redirect('/produk')->with('berhasil', 'Data Berhasil Dihapus');
    }
    public function EditProduk(Request $request)
    {
        $data = [
            "produkupd" => produk::where("kode_produk", $request->kode_produk)->get(),
        ];
        return view("update", $data);
    }

    public function updateProduct(Request $request)
    {
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = time() . '_' . $imageFile->getClientOriginalName();
            $imageFile->storeAs('public/images', $imageName);
        }

        $updateprd = produk::find($request->kode_produk);
        $updateprd->nama_produk = $request->nama_produk;
        $updateprd->deskripsi = $request->deskripsi;
        $updateprd->harga = $request->harga;
        $updateprd->jumlah_produk = $request->jumlah_produk;
        if ($imageName != null) {
            $updateprd->image = $imageName;
        }
        $updateprd->save();
        return redirect('/produk')->with('berhasil', 'Data Berhasil Diupdate');
    }
}
