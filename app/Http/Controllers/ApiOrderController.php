<?php

namespace App\Http\Controllers;

use App\Berlangganan;
use App\Kememberan;
use App\Order;
use App\PaymentLog;
use App\Profile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ApiOrderController extends Controller
{
    public function index()
    {
        $data = Order::get();

        return response()->json([
            'status' => 'success',
            'message' => 'list data order',
            'data' => $data
        ], 200);
    }

    public function create(Request $request)
    {
        $user = $request->input('user');
        $kememberan = $request->input('kememberan');
        $referal = $request->input('referal');

        $order = Order::create([
            'user_id' => $user['id'],
            'kememberan_id' => $kememberan['id']
        ]);

        $transaction_detail = [
            'order_id' => $order->id.'-'.Str::random(5),
            'gross_amount' => $kememberan['harga']
        ];
        $item_detail = [
                [
                    'id' => $kememberan['id'],
                    'price' => $kememberan['harga'],
                    'quantity' => 1,
                    'name' => $kememberan['nama'],
                    'brand' => 'Pohon Ilmu',
                    'category' => 'Online member Page'
                ]
            ];
            $customer_detail = [
            'first_name' => $user['name'],
            'email' => $user['email'],
        ];

        $midtransParams = [
            'transaction_details' => $transaction_detail,
            'item_details' => $item_detail,
            'customer_details' => $customer_detail,
            // untuk custom pembayaran
            // "enabled_payments" => ["gopay",
            //     "danamon_online", "akulaku", "shopeepay"],

            ];

        $midtransParamsSnapUrl = $this->getMidtrnasSnapUrl($midtransParams);

        $order->snap_url = $midtransParamsSnapUrl;
        $order->metadata = [
            'member_page_id' => $kememberan['id'],
            'member_page_nama' => $kememberan['nama'],
            'member_page_price' => $kememberan['harga'],
            'akses_kelas' => $kememberan['akses_kelas'],
            'referal' => $referal
        ];

        $order->save();

        return response()->json([
            'status' => 'success',
            'data' => $order
        ]);


    }

    private function getMidtrnasSnapUrl($params)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_PRODACTION');
        \Midtrans\Config::$is3ds = env('MIDTRANS_3DS');

        $snapUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
        return $snapUrl;
    }

    public function midtransHandler(Request $request)
    {
        $data = $request->all();

        $signatureKey = $data['signature_key'];

        $orderId = $data['order_id'];
        $statusCode = $data['status_code'];
        $grossAmount = $data['gross_amount'];
        $serverKey = env('MIDTRANS_SERVER_KEY');

        $mySignatureKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        $transactionStatus = $data['transaction_status'];
        $type = $data['payment_type'];
        $fraudStatus = $data['fraud_status'];

        $mySignatureKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        if($signatureKey !== $mySignatureKey)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'invalid signature'
            ], 400);
        }

        $realorderId = explode('-', $orderId);
        $order = Order::find($realorderId[0]);
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'order id not found'
            ], 404);
        }

        if ($order->status === 'success') {
            return response()->json([
                'status' => 'error',
                'message' => 'operation not permitted'
            ], 405);
        }

        if ($transactionStatus == 'capture'){
            if ($fraudStatus == 'challenge'){
                $order->status = 'challenge';
            } else if ($fraudStatus == 'accept'){
                $order->status = 'success';
            }
        } else if ($transactionStatus == 'settlement'){
            $order->status = 'success';
        } else if ($transactionStatus == 'cancel' ||
          $transactionStatus == 'deny' ||
          $transactionStatus == 'expire'){
            $order->status = 'failure';
        } else if ($transactionStatus == 'pending'){
            $order->status = 'pending';
        }

        $logData = [
            'status' => $transactionStatus,
            'raw_response' => json_encode($data),
            'order_id' => $realorderId[0],
            'payment_type' => $type
        ];
        $metadata = json_decode($order->metadata, true);
        $paymentLogs = PaymentLog::create($logData);
        $order->save();

        if($order->status === 'success')
        {
            if($metadata['referal'] != 'null'){
                $kememberan = Kememberan::where('id', $order->kememberan_id)->first();
                // dd($kememberan);
                $profile = Profile::where('referal', $metadata['referal'])->first();
                if(!$profile){
                    return response()->json([
                        'status' => 'success',
                        'message' => 'referal tidak ada'
                    ], 200);
                }

                $point = $profile->point+$kememberan->get_point;
                $profile->update([
                    'point' => $point
                ]);

            }

            $berlangganan = Berlangganan::create([
                'user_id' => $order->user_id,
                'kememberan_id' => $order->kememberan_id
            ]);

        }

        return response()->json([
            'status' => 'success',
            'message' => 'pembayaran berhasil',
            'payment_logs' => $paymentLogs
        ], 200);


    }
}
