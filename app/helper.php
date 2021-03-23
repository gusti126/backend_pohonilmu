<?php

use App\Order;
use Illuminate\Support\Facades\Http;

// get berlangganan sesuai user id
function getUser($id){
    $url = 'http://localhost:8002/api/berlangganan/get-user-id/'.$id;
    try {
        $response = Http::get($url);
        $data = $response->json();
        $data['http_code'] = $response->getStatusCode();
        return $data;
    } catch (\Throwable $th) {
        return [
            'status' => 'error',
            'http_code' => 500,
            'message' => 'service member page availeble'
        ];
    }
}

// hapus berlangganan sesuai id
function deletBerlangganan($id)
{
    $url = 'http://localhost:8002/api/berlangganan/hapus/'.$id;
    try {
        $response = Http::get($url);
        $data = $response->json();
        $data['http_code'] = $response->getStatusCode();
        return $data;
    } catch (\Throwable $th) {
        return [
            'status' => 'error',
            'http_code' => 500,
            'message' => 'service member page availeble'
        ];
    }
}

// hadiah
function getHadiah()
{
    $url = env('COURSE_HADIAH');
    try {
        $response = Http::get($url);
        $data = $response->json();
        $data['http_code'] = $response->getStatusCode();
        return $data;
    } catch (\Throwable $th) {
        return [
            'status' => 'error',
            'http_code' => 500,
            'message' => 'service member page availeble'
        ];
    }
}

function createHadiah($data)
{
    $url = env('COURSE_HADIAH').'create';
    try {
        $response = Http::post($url, $data);
        $data = $response->json();
        $data['http_code'] = $response->getStatusCode();
        return $data;
    } catch (\Throwable $th) {
        return [
            'status' => 'error',
            'http_code' => 500,
            'message' => 'service member page availeble'
        ];
    }
}

function deleteHadiah($id)
{
    $url = env('COURSE_HADIAH').$id;
    try {
        $response = Http::delete($url);
        $data = $response->json();
        $data['http_code'] = $response->getStatusCode();
        return $data;
    } catch (\Throwable $th) {
        return [
            'status' => 'error',
            'http_code' => 500,
            'message' => 'service member page availeble'
        ];
    }
}

function getPenukarHadiah()
{
    $url = env('COURSE_HADIAH').'penukar';
    try {
        $response = Http::get($url);
        $data = $response->json();
        $data['http_code'] = $response->getStatusCode();
        return $data;
    } catch (\Throwable $th) {
        return [
            'status' => 'error',
            'http_code' => 500,
            'message' => 'service member page availeble'
        ];
    }
}

function TransaksiSukses()
{
    $data_count_harga = Order::with('kememberan')->where('status', 'success')->get();
    // dd($data_count_harga);
    $total = 0;
    foreach($data_count_harga as $h)
    {
        $t = $h->kememberan->harga;
        $total += $t;
    }

    return $total;
}
