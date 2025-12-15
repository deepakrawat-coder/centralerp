<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\UniversityErp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ServiceController extends Controller
{
    public function handle(Request $request, $method, $uni_id )
    {
        // dd([
        //     'request' => $request->all(),
        //     'method'  => $method,
        //     'uni_id'  => $uni_id,
        //     'session' => Session::all(),
        // ]);

        // if(Session::has('uni_id')){
        //    dd($request->all());

        // }else{
        // 1️⃣ Validate input
        // $request->validate([
        //     'id' => 'required|integer|exists:university_erps,id'
        // ]);
        // }


        // 2️⃣ Get ERP live URL
        $erp = UniversityErp::select('live_url')
            ->where('id', $request->id)
            ->firstOrFail();

        $baseUrl = rtrim($erp->live_url, '/');

        // 3️⃣ Force HTTPS
        if (!str_starts_with($baseUrl, 'http://') && !str_starts_with($baseUrl, 'https://')) {
            $baseUrl = 'https://' . $baseUrl;
        }

        // 4️⃣ Final ERP endpoint
        // $endpoint = $baseUrl . '/app/process/index?unidata=unidata';
        if (!empty($uni_id)) {
            $baseUrl = Session::get('live_url');
            $endpoint = $baseUrl . '/app/process/index?method=' . $method . '&uni_id=' . $uni_id;
        } else {
            $endpoint = $baseUrl . '/app/process/index';
        }
        // dd($endpoint);
        // 5️⃣ Send request using Laravel Http
        $response = Http::acceptJson()
            ->post($endpoint, [
                'payload' => $request->except('id'),
            ]);
        // dd($endpoint);.
        // 6️⃣ Handle ERP response
        $responseData = $response->json();
        if ($method === "students") {
            dd($response->json());
            return view('services.students.index', ['students' => $response]);
        }
        $responseData['live_url'] = $erp->live_url; // Send back live_url too
        if ($response->failed()) {
            return response()->json([
                'status'  => false,
                'message' => 'ERP server not reachable',
            ], 502);
        }
        // dd($response->json());
        // 7️⃣ Return ERP response back to frontend
        $data = $responseData;
        return response()->json($data);
    }


    public function dashboard(Request $request, $uni_id)
    {
        $uni_id = $uni_id; // AJAX se aaya
        //  dd($request->all());
        if (!$uni_id) {
            return response()->json(['status' => false, 'message' => 'University ID missing']);
        }

        Session::forget('uni_id');
        Session::put('uni_id', $uni_id);
        // dd(Session::all());
        // (Optional) store live_url if coming from request
        $uni_id = Session::get('uni_id');
        $liveurl = $request->live_url;
        $url =  $liveurl . '/app/process/index?method=dashboard&uni_id=' . $uni_id;
        $response = Http::timeout(10)
            ->acceptJson()
            ->post($url, []);
        // $erpData = $response->json();
        // dd($erpData);
        if ($request->has('live_url')) {
            Session::forget('live_url');
            Session::put('live_url', $request->live_url);
        }

        return response()->json(['status' => true]);
    }
    public function students(Request $request, $uni_id)
    {
        dd('hello');
        return view('services.students.index',);
    }
}
