<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\UniversityErp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ServiceController extends Controller
{
    public function handle(Request $request, $method, $uni_id, $tokeuniversity = null)
    {

        if ($request->indexPage == 'erpAccess') {
            Session::forget('live_url');
            $request->validate([
                'id' => 'required|integer|exists:university_erps,id'
            ]);
            Session::put('University_table_id', $request->id);
            $erp = UniversityErp::select('live_url')
                ->where('id', $request->id)
                ->firstOrFail();
            Session::put('live_url', $erp->live_url);
            $baseUrl = rtrim($erp->live_url, '/');
            // dd($baseUrl);
        } else if (Session::get('uni_id')) {
            //    dd($request->all());
            $live_url = Session::get('live_url');
            $baseUrl = rtrim($live_url, '/');
        } else {
            // dd($request->all());
            Session::forget('University_table_id');

            $request->validate([
                'id' => 'required|integer|exists:university_erps,id'
            ]);
            Session::put('University_table_id', $request->id);
            $erp = UniversityErp::select('live_url')
                ->where('id', $request->id)
                ->firstOrFail();

            $baseUrl = rtrim($erp->live_url, '/');
            // dd($baseUrl);
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
            } else  if ($method === "ledger") {
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
        // if ($method === "students") {
        //     // dd($responseData['data']);
        //     return view('services.students.index', [
        //         'students' => $responseData['data'] // ONLY DATA
        //     ]);
        // }
        if ($method === "students") {

            // 👉 AJAX request (DataTable)
            if ($request->ajax()) {
                $students = collect($responseData['data']);
                // dd($responseData['data']);
                // Get filters from request
                $filters = $request->input('filters', []);

                // Apply Student ID filter
                if (!empty($filters['student_id'])) {
                    $students = $students->filter(function ($item) use ($filters) {
                        return stripos($item['Unique_ID'] ?? '', $filters['student_id']) !== false;
                    });
                }

                // Apply Course filter
                if (!empty($filters['course'])) {
                    // dd($filters['course']);
                    $students = $students->filter(function ($item) use ($filters) {
                        return ($item['Sub_Course_ID'] ?? '') == $filters['course'];
                    });
                }

                // Apply User filter
                if (!empty($filters['user'])) {
                    //  dd($filters['user']);
                    // dd($students);
                    $students = $students->filter(function ($item) use ($filters) {
                        return ($item['Added_For'] ?? '') == $filters['user'];
                    });
                }
                $students = $this->applyDateRangeFilter($students, 'Process_By_Center', $filters['processed_by_center_start'] ?? null, $filters['processed_by_center_end'] ?? null);
                $students = $this->applyDateRangeFilter($students, 'Payment_Received', $filters['payment_received_start'] ?? null, $filters['payment_received_end'] ?? null);
                $students = $this->applyDateRangeFilter($students, 'Document_Verified', $filters['document_received_start'] ?? null, $filters['document_received_end'] ?? null);
                // Get total count before pagination
                $totalCount = $students->count();
                // Apply sorting
                $orderColumn = $request->input('order.0.column', 2);
                $orderDir = $request->input('order.0.dir', 'desc');
                // Map column index to actual field name
                $columnMap = [
                    0 => 'DT_RowIndex',
                    1 => 'Unique_ID',
                    2 => 'Enrollment_No',
                    3 => 'Student_Name',
                    4 => 'Father_Name',
                    5 => 'Email',
                    6 => 'Contact',
                    7 => 'Process_By_Center',
                    8 => 'Payment_Received',
                    9 => 'Document_Verified',
                    10 => 'user_name_code',
                    11 => 'CourseName',
                    12 => 'SubCourseName',
                    13 => 'Address',
                    14 => 'Status',
                    15 => 'Created_At'
                ];

                $orderColumnName = $columnMap[$orderColumn] ?? 'Enrollment_No';

                // Sort the collection
                $students = $students->sortBy($orderColumnName, SORT_REGULAR, $orderDir === 'desc');

                // Apply pagination
                $start = $request->input('start', 0);
                $length = $request->input('length', 25);
                $paginatedData = $students->slice($start, $length)->values();

                return DataTables::of($paginatedData)
                    ->addIndexColumn()
                    ->addColumn('Student_Name', function ($row) {
                        return trim(
                            ($row['First_Name'] ?? '') . ' ' .
                                ($row['Middle_Name'] ?? '') . ' ' .
                                ($row['Last_Name'] ?? '')
                        );
                    })
                    ->addColumn('Status', function ($row) {
                        return ($row['Status'] ?? 0) == 1
                            ? '<span class="badge bg-success">Active</span>'
                            : '<span class="badge bg-danger">Inactive</span>';
                    })
                    ->addColumn('Created_At', function ($row) {
                        return !empty($row['Created_At'])
                            ? date('d-m-Y', strtotime($row['Created_At']))
                            : '';
                    })
                    ->addColumn('Address', function ($row) {
                        if (empty($row['Address'])) return '—';

                        $addr = is_array($row['Address'])
                            ? $row['Address']
                            : json_decode($row['Address'], true);

                        return trim(
                            ($addr['present_address'] ?? '') . ', ' .
                                ($addr['present_city'] ?? '') . ', ' .
                                ($addr['present_state'] ?? '') . ' - ' .
                                ($addr['present_pincode'] ?? '')
                        );
                    })
                    ->with([
                        'recordsTotal' => $totalCount,
                        'recordsFiltered' => $totalCount,
                    ])
                    ->rawColumns(['Status'])
                    ->make(true);
            }
            return view('services.students.index');
            // 👉 NORMAL PAGE LOAD (unchanged)
            // return view('services.students.index', [
            //     'students' => [] // empty, DataTable will load via AJAX
            // ]);
        } else if ($method === "users") {

            if ($request->ajax()) {

                // ✅ IMPORTANT: unwrap "data" inside data
                $user = collect($responseData['data']);
                // dd($users);
                return DataTables::of($user)
                    ->addIndexColumn() // S.No

                    ->addColumn('Photo', function ($row) {
                        return $row['Photo'] ?? null;
                    })

                    ->addColumn('Address', function ($row) {
                        // dd();

                        return (trim($row['Address'] . $row['District'] . ' ' . $row['City'] . ' ' . $row['State'] . ' ' . $row['Pincode']));
                    })

                    ->editColumn('Status', function ($row) {
                        return $row['Status'];
                    })

                    ->rawColumns(['Photo'])
                    ->make(true);
            }

            // Page load
            return view('services.users.index');
        } else if ($method === "wallet") {

            if ($request->ajax()) {

                // unwrap data if needed
                $wallets = collect($responseData['data']);

                return DataTables::of($wallets)
                    ->addIndexColumn() // #

                    ->editColumn('Type', function ($row) {
                        return $row['Type'];
                    })

                    ->editColumn('Transaction_Date', function ($row) {
                        return $row['Transaction_Date'];
                    })

                    ->editColumn('Amount', function ($row) {
                        return $row['Amount'];
                    })

                    ->editColumn('Approved_On', function ($row) {
                        return $row['Approved_On'];
                    })

                    ->editColumn('Created_At', function ($row) {
                        return $row['Created_At'];
                    })

                    ->make(true);
            }

            // Page load
            return view('services.wallet.index');
        } else if ($method === "ledger") {

    if ($request->ajax()) {

        // unwrap ledger data
        $studentLedgers = collect($responseData['data']);

        return DataTables::of($studentLedgers)
            ->addIndexColumn() // #

            ->editColumn('Date', function ($row) {
                return $row['Date'] ?? null;
            })

            ->editColumn('Fee', function ($row) {
                return $row['Fee'] ?? null;
            })

            ->editColumn('Settlement_Amount', function ($row) {
                return $row['Settlement_Amount'] ?? null;
            })

            ->editColumn('Amount', function ($row) {
                return $row['Amount'] ?? null;
            })

            ->editColumn('Created_At', function ($row) {
                return $row['Created_At'] ?? null;
            })

            ->make(true);
    }

    // page load
    return view('services.ledger.index');
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
    private function applyDateRangeFilter(
        Collection $collection,
        string $field,
        ?string $startDate,
        ?string $endDate
    ): Collection {
        if (empty($startDate) || empty($endDate)) {
            return $collection;
        }

        $start = Carbon::createFromFormat('m/d/Y', $startDate)->startOfDay();
        $end   = Carbon::createFromFormat('m/d/Y', $endDate)->endOfDay();

        return $collection->filter(function ($item) use ($field, $start, $end) {
            if (empty($item[$field])) {
                return false;
            }

            return Carbon::parse($item[$field])->between($start, $end);
        });
    }

    public function dashboard(Request $request, $uni_id = null)
    {

        $uni_id = $uni_id;
        // if (!$uni_id) {
        //     return response()->json(['status' => false, 'message' => 'University ID missing']);
        // }
        if (!($uni_id)) {

            return view('services.dashboard.index');
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
        //  dd(session::all());
        return response()->json(['status' => true]);
    }
    // public function students(Request $request, $uni_id)
    // {
    //     dd('hello');
    //     return view('services.students.index',);
    // }
    public function filters(Request $request)
    {
        $live_url = $request->liveUrl;
        $uni_id   = $request->uniId;
        $method = $request->method;
        $url = $live_url . '/app/process/index?method=filter&uni_id=' . $uni_id;

        $response = Http::acceptJson()
            ->post($url, [
                'payload' => $request->except('id'),
            ]);

        $response = $response->json();
    // dd($response['data']);
        // ✅ FIX: RETURN RESPONSE
        return response()->json($response);
    }
}
