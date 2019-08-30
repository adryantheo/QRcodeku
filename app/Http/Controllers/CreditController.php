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
        // $status = DB::transaction(function () use($qrcode){
        //     $cek = Credit::where('qr_strings', "LIKE", $qrcode)->first();
        // if($cek){
        //         $status = Credit::find($cek);
        //         $status->is_redeem = true;
        //         $status->save();   
        //     }
            
        // },3);
        $cek = Credit::where('qr_strings', "LIKE", $qrcode)->first('id');
        // return response()->json($status,200);
       
        if($cek){            
            $status = $this->changeStatus($cek);
        }else{
            return response()->json(['Invalid Code']);
        }

        return response()->json([
             $status
        ]);

        
    }

    public function changeStatus(Credit $credit)
    {
        
            $credit->is_redeem = true;
            $status = $credit -> save();
            return response()->json([
                'message' => $status ? 'Redeem Success!' : 'Error Redeeming Code'
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
