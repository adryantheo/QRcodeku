<?php

namespace App\Http\Controllers;

use App\Brands;
use App\Credit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandsController extends Controller
{
   
    public function index()
    {
        return response()->json(Brands::with(['credits'])->get(),200);
    }

    public function uploadImage(Request $request, $name = null)
    {
        if($request->hasFile('image')){
            $image = $request->file('image');

            if(is_null($name)){
                $name = time() . "_" . rand(1000, 1000000) . "." . $image->getClientOriginalExtension();
            }

            $image->move(public_path('images'), $name);

            return '/images/' .$name;
        }
        return '';
    }

   
    public function store(Request $request)
    {
       DB::transaction(function () use ($request, &$brands){
        $brands = Brands::create([
            'name' => $request->input('name'),
            'image' => $this->uploadImage($request),
        ]);

       

       },3);
        


        return response()->json([
            'status' => (bool) $brands,
            'data'   => $brands,
            'message' => $brands ? 'Brand Baru Berhasil Ditambahkan!' : 'Error Menambahkan Brand Baru'
        ]);
    }

    
    public function show(Brands $brands)
    {
        return response()->json(Brands::with('credits')->where('id', '=', $brands->id)->first(),200);        
    }

    public function update(Request $request, Brands $brands)
    {
        $status = $brands->update(
            $request->only([
                'name',
            ])
            );
        
        return response()->json([
            'status' => (bool) $status,
            'data' => $status,
            'message' => $status ? 'Brand Baru Berhasil Diupdate!' : 'Error Mengupdate Brand Baru'
        ]);
    }

   
    public function destroy(Brands $brands)
    {
        $status = $brands->delete();
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Brand Berhasil di Hapus!' : 'Error Menghapus Brand'
        ]);
    }
}
