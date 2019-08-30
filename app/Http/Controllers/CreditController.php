<?php

namespace App\Http\Controllers;
use App\Brands;
use App\Credit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreditController extends Controller
{
  
    public function index()
    {
        return response()->json(Credit::all(),200);
    }

  
    public function store(Request $request)
    {
        
        $credit = Credit::create([
            'amount' => $request->input('amount'),
            'qr_strings' =>  $request->input('qr_strings')."_".$request->input('brands_id'),
            'brands_id' => $request->input('brands_id'),
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

    public function redeem(Request $request, $qrcode)
    {
        
        $status = Credit::where('qr_strings', "LIKE", $qrcode)->first();
        if(!$status){
                return response()->json(['Invalid Code']);
            }
        else if($status->is_redeem != true){
                $data = Credit::where('qr_strings', "LIKE", $qrcode)
                        ->update(['is_redeem' => true ]);
                return response()->json([
                        'message' => $data ? 'Redeem Success!' : 'Error Redeeming Code'
                    ]);
                }
        else{
                return response()->json(['Code Already Redeemed']);
            }
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
