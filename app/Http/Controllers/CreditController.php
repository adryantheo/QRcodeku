<?php

namespace App\Http\Controllers;
use App\Brands;
use App\Credit;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CreditController extends Controller
{
  
    public function index()
    {
        return response()->json(Credit::all(),200);
    }

  
    public function store(Request $request)
    {
        $status = DB::transaction(function () use ($request, &$credit){
            $credit = Credit::create([
                'amount' => $request->input('amount'),
                'qr_strings' =>  $request->input('qr_strings')."_".$request->input('brands_id'),
                'image' => $this->generateQR($request),
                'brands_id' => $request->input('brands_id'),
            ]);

            Mail::to("test@mail.com")
            ->send(new Email($credit));

        },3);
                

        return response()->json([
            'status' => (bool) $credit,
            'data'   => $credit,
            'message' => $credit ? 'Credits Baru Berhasil Ditambahkan!' : 'Error Menambahkan Credits Baru'
        ]);
       
    }

    public function generateQR(Request $request, $name = null)
    {
        if($request->has('qr_strings')){
            $image = QrCode::format('png')
                    ->size(500)->errorCorrection('H')
                    ->generate($request->input('qr_strings')."_".$request->input('brands_id'));
            
            $name = '/public/qr-code/' . time() . "_" . rand(1000, 1000000) . "." . "png";
            \Storage::disk('local')->put($name, $image);

            

            return $name;
        }
        return '';
        
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
