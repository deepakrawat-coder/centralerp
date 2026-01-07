<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\UniversityErp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ServiceController extends Controller
{
    public function handle(Request $request, $method, $uni_id)
    {

        if (Session::get('uni_id')) {
            $live_url = Session::get('live_url');
            $baseUrl = rtrim($live_url, '/');
        } else {
            $request->validate([
                'id' => 'required|integer|exists:university_erps,id'
            ]);
            $erp = UniversityErp::select('live_url')
                ->where('id', $request->id)
                ->firstOrFail();

            $baseUrl = rtrim($erp->live_url, '/');
        }
        if (!str_starts_with($baseUrl, 'http://') && !str_starts_with($baseUrl, 'https://')) {
            $baseUrl = 'https://' . $baseUrl;
        }
        if (!empty($uni_id)) {
            $baseUrl = Session::get('live_url');
            if ($method === "students") {
                $endpoint = $baseUrl . '/app/process/index?method=' . $method . '&uni_id=' . $uni_id;
            } else  if ($method === "wallet") {
                $endpoint = $baseUrl . '/app/process/index?method=' . $method . '&uni_id=' . $uni_id;
            }else  if ($method === "ledger") {
                $endpoint = $baseUrl . '/app/process/index?method=' . $method . '&uni_id=' . $uni_id;
            } else {
                $endpoint = $baseUrl . '/app/process/index?method=' . $method;
            }
        } else {
            $endpoint = $baseUrl . '/app/process/index';
        }
// dd($endpoint);
        $response = Http::acceptJson()
            ->post($endpoint, [
                'payload' => $request->except('id'),
            ]);
        $responseData = $response->json();
        // dd($responseData);
        if ($method === "students") {
            // dd($responseData['data']);
            return view('services.students.index', [
                'students' => $responseData['data'] // ONLY DATA
            ]);
        } else if ($method === "users") {
            //    dd($responseData['data']);
            return view('services.users.index', [
                'users' => $responseData['data'] // ONLY DATA
            ]);
        } else if ($method === "wallet") {
            // dd($method);
            
            return view('services.wallet.index', [
                'wallets' => $responseData['data'] // ONLY DATA
            ]);
        }else if ($method === "ledger") {
            // dd($method);
            //  dd($responseData['data']);
            return view('services.ledger.index', [
                'studentLedgers' => $responseData['data'] // ONLY DATA
            ]);
        }


        $responseData['live_url'] = $baseUrl;
        if ($response->failed()) {
            return response()->json([
                'status'  => false,
                'message' => 'ERP server not reachable',
            ], 502);
        }
        $data = $responseData;
        return response()->json($data);
    }


    public function dashboard(Request $request, $uni_id)
    {
        $uni_id = $uni_id;
        if (!$uni_id) {
            return response()->json(['status' => false, 'message' => 'University ID missing']);
        }
        Session::forget('uni_id');
        Session::put('uni_id', $uni_id);
        $uni_id = Session::get('uni_id');
        $liveurl = $request->live_url;
        $url =  $liveurl . '/app/process/index?method=dashboard&uni_id=' . $uni_id;
        $response = Http::timeout(10)
            ->acceptJson()
            ->post($url, []);
        if ($request->has('live_url')) {
            Session::forget('live_url');
            Session::put('live_url', $request->live_url);
        }

        return response()->json(['status' => true]);
    }
    // public function students(Request $request, $uni_id)
    // {
    //     dd('hello');
    //     return view('services.students.index',);
    // }
}
