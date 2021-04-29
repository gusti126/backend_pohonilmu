<?php

namespace App\Http\Controllers;

use App\Berlangganan;
use App\Kememberan;

use App\OrderTripay;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ApiTripayController extends Controller
{
    public function creata(Request $request)
    {
        $rules = [
            'kememberan_id' => 'integer|required',
            'method_payment' => 'required|string|in:ALFAMART,ALFAMIDI,BNIVA,BRIVA,BCAVA,MANDIRIVA',
        ];
        $data = $request->all();
        $messages = [
            'in' => ':attribute harus di isi kode antara berikut (ALFAMART, ALFAMIDI, BNIVA, BRIVA, BCAVA, MANDIRIVA)',
        ];
        $validator = Validator::make($data, $rules, $messages);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $kememberanId = $request->input('kememberan_id');
        $kememberan = Kememberan::find($kememberanId);
        if(!$kememberan)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'data kememberan tidak ada'
            ], 404);
        }
        $userId = Auth::user()->id;
        $user = User::with('profile')->find($userId);
        // dd($user);

        $order = OrderTripay::create([
            'user_id' => Auth::user()->id,
            'kememberan_id' => $kememberan->id,
            'referal' => $request->input('referal')
        ]);



        $apiKey = env('API_KEY_TRIPAY');
        $privateKey = env('PRIVAT_KEY_TRIPAY');
        $merchantCode = 'T3385';
        $merchantRef = $order->id;
        $amount = $kememberan->harga;
        // untuk opsi pemilihan pembayaran
        $method_payment = $request->input('method_payment');

        $data = [
        'method'            => $method_payment,
        'merchant_ref'      => $merchantRef,
        'amount'            => $amount,
        'customer_name'     => Auth::user()->name,
        'customer_email'    => 'cs@pohonpengetahuantambahilmu.co.id',
        'customer_phone'    => $user->profile->no_tlp,
        'order_items'       => [
            [
            'sku'       => 'Kememberan',
            'name'      => $kememberan->nama,
            'price'     => $amount,
            'quantity'  => 1
            ]
        ],
        'callback_url'      => 'https://admin.pohonpengetahuantambahilmu.co.id/callback',
        'return_url'        => 'https://admin.pohonpengetahuantambahilmu.co.id/',
        'expired_time'      => (time()+(24*60*60)), // 24 jam
        'signature'         => hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey)
        ];

        // $response = Http::withToken('Bearer'.$apiKey)->post('https://payment.tripay.co.id/api-sandbox/transaction/create', $data);
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$apiKey])->post('https://payment.tripay.co.id/api/transaction/create', $data);
        dd($response);
        // return $response;
        $kode_pempayaran = $response['data']['pay_code'];
        $no_refernsi = $response['data']['reference'];
        $jumlah_tagihan = $response['data']['amount'];
        $snap_url = $response['data']['checkout_url'];
        $method = $response['data']['payment_method'];
        $metadata = $response['data']['instructions'][0]['steps'];

        $order->method = $method;
        $order->no_referensi = $no_refernsi;
        $order->kode_pembayaran = $kode_pempayaran;
        $order->jumlah_tagihan = $jumlah_tagihan;
        $order->snap_url = $snap_url;
        $order->metadata = json_encode($metadata);

        $order->save();



        return response()->json([
            'status' => 'success',
            'data' => $order
        ], 200);

    }

    // protected $privateKey = 'DEV-Swgwgwta61Jgf9ExXwBBDkHEHcNH1nJJx4ZIjuq2';

	public function handle(Request $request)
	{
        $privateKey = env('PRIVAT_KEY_TRIPAY_PRO');
		// ambil callback signature
		$callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE') ?? '';

		// ambil data JSON
		$json = $request->getContent();
        // dd($json);

		// generate signature untuk dicocokkan dengan X-Callback-Signature
		$signature = hash_hmac('sha256', $json, $privateKey);

		// validasi signature
		if( $callbackSignature !== $signature ) {
		    return "salah Signature"; // signature tidak valid, hentikan proses
		}

		$data = json_decode($json);
		$event = $request->server('HTTP_X_CALLBACK_EVENT');

		if( $event == 'payment_status' )
		{
		    if( $data->status == 'PAID' )
		    {
		        $merchantRef = $data->merchant_ref;

		        // pembayaran sukses, lanjutkan proses sesuai sistem Anda, contoh:
		        $order = OrderTripay::where('id', $merchantRef)->first();

		        if( !$order ) {
		        	return "Order not found";
		    	}

		    	$order->update([
		    		'status'	=> 'PAID'
		    	]);

                $berlangganan = Berlangganan::create([
                    'user_id' => $order->user_id,
                    'kememberan_id' => $order->kememberan_id
                ]);
                if($order->metadata != null)
                {
                    $profile = Profile::where('referal', $order->metadata)->first();
                    $kememberanId = $order->kememberan_id;
                    $kememberan = Kememberan::find($kememberanId);

                    $point = $profile->point+$kememberan->get_point;
                    $profile->update([
                        'point' => $point
                    ]);
                }

		    	return response()->json([
		    		'success' => true
		    		]);
		    }
		}

		return "No action was taken";
	}
}
