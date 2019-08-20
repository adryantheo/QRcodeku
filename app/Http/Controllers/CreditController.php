<?php

namespace App\Http\Controllers;
use App\Brands;
use App\Credit;
use Illuminate\Http\Request;

class CreditController extends Controller
{
  
    public function index()
    {
        return response()->json(Credit::with(['brands'])->get(),200);
    }

  
    public function store(Request $request)
    {
        
        $credit = Credit::create([
            'amount' => $request->input('amount'),
            'qr_strings' => $request->input('qr_strings') . "-" . $request->input('updated_at'),
            'brands_id' => $brands->id 
        ]);

        return response()->json([
            'status' => (bool) $credit,
            'data'   => $credit,
            'message' => $credit ? 'Credits Baru Berhasil Ditambahkan!' : 'Error Menambahkan Credits Baru'
        ]);
       
    }

  
    public function show(Credit $credit)
    {
        return response()->json($credit,200); 
    }

  
    public function update(Request $request, Credit $credit)
    {
        $status = $credit->update(
            $request->only([
                'amount',
                'qr_strings'
            ])
            );
        
        return response()->json([
            'status' => (bool) $status,
            'data' => $status,
            'message' => $status ? 'Credits Baru Berhasil Diupdate!' : 'Error Mengupdate Credits Baru'
        ]);
    }

  
    public function destroy(Credit $credit)
    {
        $status = $credit->delete();
        return response()->json([
            'status' => $status,
            'message' => $status ? 'Credits Berhasil di Hapus!' : 'Error Menghapus Credits'
        ]);
    }
}
