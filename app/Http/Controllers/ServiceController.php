<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\UniversityErp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Json;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ServiceController extends Controller
{
    public function handle(Request $request, $method, $uni_id, $tokeuniversity = null)
    {
        // dd([
        //     $request->input('start'),
        //     $request->input('length'),
        // ]);
        // dd($request->filters);
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

            // =============================
            // DATATABLE LIMIT (start,length)
            // =============================
            $start  = $request->input('start');
            $length = $request->input('length');

            if ($start !== null && $length !== null) {

                // DataTables "All" case
                if ((int)$length === -1) {
                    $datalimit = ""; // no LIMIT
                } else {
                    $start  = (int) $start;
                    $length = (int) $length;
                    $datalimit = "{$start},{$length}";
                }
            } else {
                // default fallback
                $datalimit = "0,10";
            }

            // =============================
            // BASE URL
            // =============================
            $baseUrl = Session::get('live_url');
            $endpoint = $baseUrl . '/app/process/index';

            // =============================
            // METHODS THAT NEED UNI ID
            // =============================
            $uniMethods = ['students', 'wallet', 'ledger', 'users'];

            // =============================
            // QUERY PARAMS
            // =============================
            $query = [
                'method' => $method
            ];

            // add limit only if exists
            if ($datalimit !== "") {
                $query['limit'] = $datalimit;
            }

            if (in_array($method, $uniMethods)) {
                $query['uni_id'] = $uni_id;
            }
            // =============================
            // FILTERS (SAFE & CLEAN)
            // =============================
            $filters = $request->input('filters', []);

            $allowedFilters = [
                'student_id',
                'processed_by_center_start',
                'processed_by_center_end',
                'payment_received_start',
                'payment_received_end',
                'document_received_start',
                'document_received_end',
                'course',
                'user',
                'transaction_start',
                'transaction_end',
                'transaction_type',
                'transaction_id',
                'processed_by_create_start',
                'processed_by_create_end',
                'user_vertical',
                'user_role',
                'users_id'
            ];

            // remove empty filters
            $filters = array_filter(
                $filters,
                fn($value) => $value !== null && $value !== ''
            );

            // add filters only if any valid filter exists
            if (!empty(array_intersect(array_keys($filters), $allowedFilters))) {
                $query['filter'] =  base64_encode(json_encode($filters));
            }
            // =============================
            // FINAL URL
            // =============================
            $endpoint .= '?' . http_build_query($query);
            // dd($endpoint);
        } else {
            $endpoint = $baseUrl . '/app/process/index';
        }

        // dd($endpoint);
        $response = Http::acceptJson()
            ->post($endpoint, [
                'payload' => $request->except('id'),
            ]);
        $responseData = $response->json();
        // dd($responseData['data']);

        if ($method === "students") {
            // dd($responseData);
            if ($request->ajax()) {
                $students = collect($responseData['data']['data']);
                $studentTotalCount = $responseData['data']['total_count'];


                // Apply sorting
                $orderColumn = $request->input('order.0.column', 2);
                $orderDir = $request->input('order.0.dir', 'desc');

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
                $students = $orderDir === 'desc'
                    ? $students->sortByDesc($orderColumnName, SORT_NATURAL)
                    : $students->sortBy($orderColumnName, SORT_NATURAL);


                $paginatedData = $students;
                // Prepare data for DataTables
                $data = [];
                $counter = $start + 1;

                foreach ($paginatedData as $row) {
                    $data[] = [
                        'DT_RowIndex' => $counter++,
                        'Unique_ID' => $row['Unique_ID'] ?? '',
                        'Enrollment_No' => $row['Enrollment_No'] ?? '',
                        'Student_Name' => trim(
                            ($row['First_Name'] ?? '') . ' ' .
                                ($row['Middle_Name'] ?? '') . ' ' .
                                ($row['Last_Name'] ?? '')
                        ),
                        'Father_Name' => $row['Father_Name'] ?? '',
                        'Email' => $row['Email'] ?? '',
                        'Contact' => $row['Contact'] ?? '',
                        'Process_By_Center' => $row['Process_By_Center'] ?? '',
                        'Payment_Received' => $row['Payment_Received'] ?? '',
                        'Document_Verified' => $row['Document_Verified'] ?? '',
                        'user_name_code' => $row['user_name_code'] ?? '',
                        'CourseName' => $row['CourseName'] ?? '',
                        'SubCourseName' => $row['SubCourseName'] ?? '',
                        'Address' => $this->formatAddress($row['Address'] ?? null),
                        'Status' => ($row['Status'] ?? 0) == 1
                            ? '<span class="badge bg-success">Active</span>'
                            : '<span class="badge bg-danger">Inactive</span>',
                        'Created_At' => !empty($row['Created_At'])
                            ? date('d-m-Y', strtotime($row['Created_At']))
                            : '',
                    ];
                }

                return response()->json([
                    'draw' => (int) $request->input('draw'),
                    'recordsTotal' => $studentTotalCount,      // ERP total
                    'recordsFiltered' => $studentTotalCount,   // ERP total
                    'data' => $data
                ]);
            }

            return view('services.students.index');
        } else if ($method === "users") {
            // =========================
            // AJAX request (DataTable)
            // =========================
            if ($request->ajax()) {
                $users = collect($responseData['data']['data'] ?? []);
                // dd($users);
                $userTotalCount = $responseData['data']['total_count'];
                $filters = $request->filters ?? [];

                $orderColumn = $request->input('order.0.column', 0);
                $orderDir = $request->input('order.0.dir', 'asc');

                // Map frontend columns to backend field names
                $columnMap = [
                    0 => 'DT_RowIndex',      // DT_RowIndex
                    1 => 'Photo',            // Photo
                    2 => 'Name',             // Name
                    3 => 'Vertical_type',    // Vertical_type
                    4 => 'Short_Name',       // Short_Name (if exists, else Name)
                    5 => 'Email',            // Email
                    6 => 'Mobile',           // Mobile (check if exists, else Contact)
                    7 => 'Designation',      // Designation
                    8 => 'Admissions',       // Admissions
                    9 => 'Address',          // Address (full concatenated)
                    10 => 'Status',          // Status
                    11 => 'Created_At'       // Created_At
                ];

                $orderColumnName = $columnMap[$orderColumn] ?? 'Created_At';

                // Sort the collection
                $users = $orderDir === 'asc'
                    ? $users->sortByDesc($orderColumnName, SORT_NATURAL)
                    : $users->sortBy($orderColumnName, SORT_NATURAL);


                $paginatedData = $users;
                // dd($paginatedData);
                // ========================
                // Prepare DataTables response - MATCH FRONTEND COLUMNS
                // ========================
                $data = [];
                $counter = $start + 1;

                foreach ($paginatedData as $row) {
                    $data[] = [
                        // Column 0: DT_RowIndex
                        'DT_RowIndex' => $counter++,

                        // Column 1: Photo (with live_url)
                        'Photo' => $row['Photo'] ?
                            '<img src="' . $baseUrl . $row['Photo'] . '" alt="User Photo" width="45" height="45" style="object-fit:cover;border-radius:6px;">' :
                            '<span class="text-muted">N/A</span>',

                        // Column 2: Name
                        'Name' => $row['Name'] ?? '',

                        // Column 3: Vertical_type (raw value for sorting)
                        'Vertical_type' => $row['Vertical_type'] ?? 0,

                        // Column 4: Short_Name (use Short_Name if exists, else Name)
                        'Short_Name' => $row['Short_Name'] ?? $row['Name'] ?? '',

                        // Column 5: Email
                        'Email' => $row['Email'] ?? '',

                        // Column 6: Mobile (use Mobile if exists, else Contact)
                        'Mobile' => $row['Mobile'] ?? $row['Contact'] ?? '',

                        // Column 7: Designation
                        'Designation' => $row['Designation'] ?? '',

                        // Column 8: Admissions
                        'Admissions' => $row['Admissions'] ?? '',

                        // Column 9: Address (full concatenated)
                        'Address' => $row['Address'] ?? '',
                        'District' => $row['District'] ?? '',
                        'State' => $row['State'] ?? '',
                        'Pincode' => $row['Pincode'] ?? '',

                        // Column 10: Status (HTML badge)
                        'Status' => ($row['Status'] ?? 0) == 1
                            ? '<span class="badge bg-success">Active</span>'
                            : '<span class="badge bg-danger">Inactive</span>',

                        // Column 11: Created_At
                        'Created_At' => !empty($row['Created_At'])
                            ? date('d-m-Y', strtotime($row['Created_At']))
                            : '',
                    ];
                }

                return response()->json([
                    'draw' => $request->input('draw'),
                    'recordsTotal' => $userTotalCount,
                    'recordsFiltered' => $userTotalCount,
                    'data' => $data
                ]);
            }

            // =========================
            // Normal page load
            // =========================
            return view('services.users.index');
        } else if ($method === "wallet") {
            // dd($responseData['data']['1']);
            if ($request->ajax()) {
                // =========================
                // Collect API data
                // =========================
                $wallets = collect($responseData['data']['data'] ?? []);
                $walletsTotalCount = $responseData['data']['total_count'];
                $filters = $request->filters ?? [];


                // =========================
                // Apply sorting - MATCH FRONTEND COLUMN ORDER
                // =========================
                $orderColumn = $request->input('order.0.column', 0);
                $orderDir = $request->input('order.0.dir', 'asc');

                // Map frontend columns (14 columns) to backend field names
                $columnMap = [
                    0 => 'DT_RowIndex',           // Column 0: DT_RowIndex
                    1 => 'Type',                  // Column 1: Type
                    2 => 'Transaction_Date',      // Column 2: Transaction_Date
                    3 => 'Transaction_ID',        // Column 3: Transaction_ID
                    4 => 'Gateway_ID',            // Column 4: Gateway_ID
                    5 => 'Bank',                  // Column 5: Bank
                    6 => 'Payment_Mode',          // Column 6: Payment_Mode
                    7 => 'Amount',                // Column 7: Amount
                    8 => 'Added_for_User',        // Column 8: Added_for_User
                    9 => 'Approved_By_User',      // Column 9: Approved_By_User
                    10 => 'Approved_On',          // Column 10: Approved_On
                    11 => 'File',                 // Column 11: File
                    12 => 'University_Name',      // Column 12: University_Name
                    13 => 'Created_At'            // Column 13: Created_At
                ];

                $orderColumnName = $columnMap[$orderColumn] ?? 'Transaction_Date';

                // Sort the collection
                $wallets = $orderDir === 'desc'
                    ? $wallets->sortByDesc($orderColumnName, SORT_NATURAL)
                    : $wallets->sortBy($orderColumnName, SORT_NATURAL);


                $paginatedData = $wallets;
                // =========================
                // Prepare DataTables response - MATCH ALL 14 FRONTEND COLUMNS
                // =========================
                $data = [];
                $counter = $start + 1;

                foreach ($paginatedData as $row) {

                    $type = $row['Type'] ?? 1; // default = Offline

                    $labels = [
                        1 => '<span class="badge bg-secondary">Offline</span>',
                        2 => '<span class="badge bg-success">Online</span>',
                    ];

                    $data[] = [
                        'DT_RowIndex' => $counter++,

                        // ✅ Type: 1 = Offline, 2 = Online
                        'Type' => $labels[$type] ?? '<span class="badge bg-dark">Unknown</span>',

                        'Transaction_Date' => !empty($row['Transaction_Date'])
                            ? date('Y-m-d', strtotime($row['Transaction_Date']))
                            : '',

                        'Transaction_ID' => $row['Transaction_ID'] ?? '',

                        'Gateway_ID' => $row['Gateway_ID'] ?? '',

                        'Bank' => $row['Bank'] ?? '',

                        'Payment_Mode' => $row['Payment_Mode'] ?? '',

                        'Amount' => $row['Amount'] ?? 0,

                        'Added_for_User' => $row['Added_for_User'] ?? '',

                        'Approved_By_User' => $row['Approved_By_User'] ?? '',

                        'Approved_On' => !empty($row['Approved_On'])
                            ? date('Y-m-d H:i:s', strtotime($row['Approved_On']))
                            : '',

                        // ✅ FIX: null-safe concatenation
                        'File' => !empty($row['File']) ? $baseUrl . $row['File'] : '',

                        'University_Name' => $row['University_Name'] ?? '',

                        'Created_At' => !empty($row['Created_At'])
                            ? date('Y-m-d H:i:s', strtotime($row['Created_At']))
                            : '',
                    ];
                }


                return response()->json([
                    'draw' => $request->input('draw'),
                    'recordsTotal' => $walletsTotalCount,
                    'recordsFiltered' => $walletsTotalCount,
                    'data' => $data
                ]);
            }

            // =========================
            // Normal Page Load
            // =========================
            return view('services.wallet.index');
        } else if ($method === "ledger") {
            // dd($responseData);
            if ($request->ajax()) {
                $studentLedgers = collect($responseData['data']['data']);

                $ledgersTotalCount = $responseData['data']['total_count'];
                $filters = $request->filters ?? [];

                // =============================
                // Get total count
                // =============================
                // $totalCount = $studentLedgers->count();

                // =============================
                // Apply sorting - MATCH FRONTEND COLUMN ORDER
                // =============================
                $orderColumn = $request->input('order.0.column', 0);
                $orderDir = $request->input('order.0.dir', 'asc');

                // Map frontend columns (16 columns) to backend field names
                $columnMap = [
                    0 => 'DT_RowIndex',           // Column 0: DT_RowIndex
                    1 => 'Unique_ID',             // Column 1: Unique_ID
                    2 => 'StudentName',           // Column 2: StudentName
                    3 => 'Email',                 // Column 3: Email
                    4 => 'Contact',               // Column 4: Contact
                    5 => 'Duration',              // Column 5: Duration
                    6 => 'Date',                  // Column 6: Date
                    7 => 'Transaction_ID',        // Column 7: Transaction_ID
                    8 => 'PaymentType',           // Column 8: PaymentType
                    9 => 'Fee',                   // Column 9: Fee
                    10 => 'Settlement_Amount',    // Column 10: Settlement_Amount
                    11 => 'Amount',               // Column 11: Amount
                    12 => 'CenterName',           // Column 12: CenterName
                    13 => 'Created_At',           // Column 13: Created_At
                ];

                $orderColumnName = $columnMap[$orderColumn] ?? 'Date';

                // Sort the collection
                $studentLedgers = $orderDir === 'desc'
                    ? $studentLedgers->sortByDesc($orderColumnName, SORT_NATURAL)
                    : $studentLedgers->sortBy($orderColumnName, SORT_NATURAL);

                // =============================
                // Apply pagination
                // =============================
                // $start = $request->input('start', 0);
                // $length = $request->input('length', 25);
                // $paginatedData = $studentLedgers->slice($start, $length)->values();
                $paginatedData = $studentLedgers;
                // =============================
                // Prepare DataTables response - MATCH ALL 14 FRONTEND COLUMNS
                // =============================
                $data = [];
                $counter = $start + 1;

                // foreach ($paginatedData as $row) {
                //     // Handle Fee field (could be JSON for Wallet Payment)
                //     $feeDisplay = '—';
                //     $feeRaw = $row['Fee'] ?? null;

                //     if ($row['PaymentType'] === 'Wallet Payment' && !empty($feeRaw) && is_string($feeRaw)) {
                //         try {
                //             $parsedFee = json_decode($feeRaw, true);
                //             if (isset($parsedFee['Paid']) && !is_nan($parsedFee['Paid'])) {
                //                 $feeDisplay = '₹' . number_format(abs($parsedFee['Paid']), 2);
                //             }
                //         } catch (\Exception $e) {
                //             $feeDisplay = '—';
                //         }
                //     } elseif (!empty($feeRaw) && is_numeric($feeRaw)) {
                //         $feeDisplay = '₹' . number_format($feeRaw, 2);
                //     }

                //     $data[] = [
                //         // Column 0: DT_RowIndex (index)
                //         'DT_RowIndex' => $counter++,

                //         // Column 1: Unique_ID
                //         'Unique_ID' => $row['Unique_ID'] ?? $row['Student_ID'] ?? '',

                //         // Column 2: StudentName
                //         'StudentName' => $row['StudentName'] ?? $row['Student_Name'] ?? '',

                //         // Column 3: Email
                //         'Email' => $row['Email'] ?? '',

                //         // Column 4: Contact
                //         'Contact' => $row['Contact'] ?? $row['Phone'] ?? '',

                //         // Column 5: Duration
                //         'Duration' => $row['Duration'] ?? '',

                //         // Column 6: Date
                //         'Date' => !empty($row['Date'])
                //             ? date('Y-m-d H:i:s', strtotime($row['Date']))
                //             : '',

                //         // Column 7: Transaction_ID
                //         'Transaction_ID' => $row['Transaction_ID'] ?? '',

                //         // Column 8: PaymentType (HTML badges as per frontend)
                //         'PaymentType' => $row['PaymentType'] ?? $row['Payment_Type'] ?? '',

                //         // Column 9: Fee (raw value for frontend processing)
                //         'Fee' => $feeRaw,

                //         // Column 10: Settlement_Amount
                //         'Settlement_Amount' => $row['Settlement_Amount'] ?? $row['Settlement'] ?? 0,

                //         // Column 11: Amount
                //         'Amount' => $row['Amount'] ?? 0,

                //         // Column 12: CenterName
                //         'CenterName' => $row['CenterName'] ?? $row['Center'] ?? '',

                //         // Column 13: Created_At
                //         'Created_At' => !empty($row['Created_At'])
                //             ? date('Y-m-d H:i:s', strtotime($row['Created_At']))
                //             : '',
                //     ];
                // }
                foreach ($paginatedData as $row) {

                    // ✅ Handle Fee field (final formatted value)
                    // ✅ FINAL Fee Handling (Wallet + Offline + Course)
                    $feeDisplay = '—';
                    $feeRaw = $row['Fee'] ?? null;
                    $paymentType = $row['PaymentType'] ?? '';

                    // Decode HTML entities if JSON
                    if (is_string($feeRaw)) {
                        $feeRaw = html_entity_decode($feeRaw, ENT_QUOTES);
                    }

                    /* 1️⃣ Wallet / Offline JSON Fee */
                    if (
                        in_array($paymentType, ['Wallet Payment', 'Offline Student Fee'], true)
                        && !empty($feeRaw)
                    ) {
                        $parsed = json_decode($feeRaw, true);

                        if (
                            json_last_error() === JSON_ERROR_NONE &&
                            isset($parsed['Paid']) &&
                            is_numeric($parsed['Paid'])
                        ) {
                            $feeDisplay = '₹' . number_format(abs((float)$parsed['Paid']), 2);
                        }
                    }
                    /* 2️⃣ Offline fallback → Settlement_Amount */ elseif (
                        $paymentType === 'Offline Student Fee' &&
                        !empty($row['Settlement_Amount']) &&
                        is_numeric($row['Settlement_Amount'])
                    ) {
                        $feeDisplay = '₹' . number_format((float)$row['Settlement_Amount'], 2);
                    }
                    /* 3️⃣ Normal Course Fee */ elseif (!empty($feeRaw) && is_numeric($feeRaw)) {
                        $feeDisplay = '₹' . number_format((float)$feeRaw, 2);
                    }


                    $data[] = [
                        'DT_RowIndex'     => $counter++,
                        'Unique_ID'       => $row['Unique_ID'] ?? $row['Student_ID'] ?? '',
                        'StudentName'     => $row['StudentName'] ?? $row['Student_Name'] ?? '',
                        'Email'           => $row['Email'] ?? '',
                        'Contact'         => $row['Contact'] ?? $row['Phone'] ?? '',
                        'Duration'        => $row['Duration'] ?? '',
                        'Date'            => !empty($row['Date'])
                            ? date('Y-m-d H:i:s', strtotime($row['Date']))
                            : '',
                        'Transaction_ID'  => $row['Transaction_ID'] ?? '',
                        'PaymentType'     => $row['PaymentType'] ?? $row['Payment_Type'] ?? '',

                        // ✅ FIXED: send formatted Fee directly
                        'Fee'             => $feeDisplay,

                        'Settlement_Amount' => $row['Settlement_Amount'] ?? $row['Settlement'] ?? 0,
                        'Amount'            => $row['Amount'] ?? 0,
                        'CenterName'        => $row['CenterName'] ?? $row['Center'] ?? '',
                        'Created_At'        => !empty($row['Created_At'])
                            ? date('Y-m-d H:i:s', strtotime($row['Created_At']))
                            : '',
                    ];
                }

                // dd($row['Settlement_Amount']);
                return response()->json([
                    'draw' => $request->input('draw'),
                    'recordsTotal' => $ledgersTotalCount,
                    'recordsFiltered' => $ledgersTotalCount,
                    'data' => $data
                ]);
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
    // private function applyDateRangeFilter(
    //     Collection $collection,
    //     string $field,
    //     ?string $startDate,
    //     ?string $endDate
    // ): Collection {
    //     if (empty($startDate) || empty($endDate)) {
    //         return $collection;
    //     }

    //     $start = Carbon::createFromFormat('m/d/Y', $startDate)->startOfDay();
    //     $end   = Carbon::createFromFormat('m/d/Y', $endDate)->endOfDay();

    //     return $collection->filter(function ($item) use ($field, $start, $end) {
    //         if (empty($item[$field])) {
    //             return false;
    //         }

    //         return Carbon::parse($item[$field])->between($start, $end);
    //     });
    // }
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
        // dd($response['data']['ledgers']);
        // ✅ FIX: RETURN RESPONSE
        return response()->json($response);
    }
    private function formatAddress($address)
    {
        if (empty($address)) return '—';

        try {
            $addr = is_array($address) ? $address : json_decode($address, true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($addr)) {
                return '—';
            }

            return trim(
                ($addr['present_address'] ?? '') . ', ' .
                    ($addr['present_city'] ?? '') . ', ' .
                    ($addr['present_state'] ?? '') . ' - ' .
                    ($addr['present_pincode'] ?? '')
            );
        } catch (\Exception $e) {
            return '—';
        }
    }
    public function logout()
    {
        Auth::logout(); // if using Laravel auth

        Session::flush(); // destroy all session data
        Session::regenerateToken();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }



    // public function exportExcel(Request $request)
    // {
    //     $module = $request->input('method', 'students');
    //     // $data   = $request->input('data', []);  
    //     // $excelData   = $data['data'];  
    //     $data = $request->input('data', []);
    //     if (is_string($data)) {
    //         $data = json_decode($data, true);
    //     }
    //     if (!is_array($data) || !isset($data['data'])) {
    //         return response()->json([
    //             'message' => 'Invalid excel data format'
    //         ], 400);
    //     }

    //     $data = $data['data'];

    //     if (is_string($data)) {
    //         $data = json_decode($data, true);
    //     }

    //     if (!is_array($data) || empty($data)) {
    //         return response()->json(['message' => 'No data found'], 400);
    //     }

    //     /* ===============================
    //             ✅ HEADER → DB COLUMN MAP
    //               =============================== */
    //     if ($module === 'students') {
    //         $headerMap = [
    //             'Student ID'     => 'Unique_ID',
    //             'Enrollment'     => 'Enrollment_No',
    //             'Name'           => 'FULL_NAME',
    //             'Father'         => 'Father_Name',
    //             'Email'          => 'Email',
    //             'Contact'        => 'Contact',
    //             'Process Date'   => 'Process_By_Center',
    //             'Payment Date'   => 'Payment_Received',
    //             'Document Date'  => 'Document_Verified',
    //             'User'           => 'user_name_code',
    //             'Course'         => 'CourseName',
    //             'Specialization' => 'SubCourseName',
    //             'Address'        => 'Address',
    //             'Status'         => 'Status',
    //             'Created'        => 'Created_At',
    //         ];
    //     } else {
    //         return response()->json(['message' => 'Invalid module'], 400);
    //     }

    //     /* =============================== ✅ BUILD EXCEL ROWS  =============================== */
    //     $rows = [];

    //     foreach ($data as $row) {

    //         $excelRow = [];

    //         foreach ($headerMap as $dbKey) {

    //             if ($dbKey === 'FULL_NAME') {
    //                 $value = trim(
    //                     ($row['First_Name'] ?? '') . ' ' .
    //                         ($row['Middle_Name'] ?? '') . ' ' .
    //                         ($row['Last_Name'] ?? '')
    //                 );
    //             } else if ($dbKey === 'Address') {
    //                 $addr = $row[$dbKey];

    //                 // ✅ If Address is JSON string → decode
    //                 if (is_string($addr)) {
    //                     $addr = json_decode($addr, true);
    //                 }

    //                 // ✅ If decoded properly
    //                 if (is_array($addr)) {
    //                     $value = trim(implode(', ', array_filter([
    //                         $addr['present_address'] ?? '',
    //                         $addr['present_city'] ?? '',
    //                         $addr['present_district'] ?? '',
    //                         $addr['present_state'] ?? '',
    //                         $addr['present_pincode'] ?? '',
    //                     ])));
    //                 } else {
    //                     $value = '';
    //                 }
    //                 // dd($value);
    //             } else if ($dbKey === 'Status') {
    //                 $value = ($row['First_Name'] == 1) ? 'Active' : "Inactive";
    //             } else {
    //                 $value = $row[$dbKey] ?? '';
    //             }

    //             if (is_array($value) || is_object($value)) {
    //                 $value = json_encode($value, JSON_UNESCAPED_UNICODE);
    //             }

    //             $excelRow[] = $value;
    //         }

    //         $rows[] = $excelRow;
    //     }

    //     /* =============================== ✅ CREATE EXCEL =============================== */
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // HEADER
    //     $sheet->fromArray(array_keys($headerMap), null, 'A1');
    //     $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')
    //         ->getFont()->setBold(true);

    //     // DATA
    //     $sheet->fromArray($rows, null, 'A2');

    //     // AUTO SIZE
    //     foreach (range('A', $sheet->getHighestColumn()) as $col) {
    //         $sheet->getColumnDimension($col)->setAutoSize(true);
    //     }

    //     $fileName = 'students_export_' . date('Ymd_His') . '.xlsx';
    //     $writer = new Xlsx($spreadsheet);

    //     return response()->streamDownload(
    //         function () use ($writer) {
    //             if (ob_get_length()) ob_end_clean();
    //             $writer->save('php://output');
    //         },
    //         $fileName,
    //         ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
    //     );
    // }
    private function getModuleConfig(string $module): array
    {
        return [

            'students' => [
                'headers' => [
                    'Student ID'     => 'Unique_ID',
                    'Enrollment'     => 'Enrollment_No',
                    'Name'           => 'FULL_NAME',
                    'Father'         => 'Father_Name',
                    'Email'          => 'Email',
                    'Contact'        => 'Contact',
                    'Process Date'   => 'Process_By_Center',
                    'Payment Date'   => 'Payment_Received',
                    'Document Date'  => 'Document_Verified',
                    'User'           => 'user_name_code',
                    'Course'         => 'CourseName',
                    'Specialization' => 'SubCourseName',
                    'Address'        => 'Address',
                    'Status'         => 'Status',
                    'Created'        => 'Created_At',
                ],

                'transformers' => [
                    'FULL_NAME' => fn($row) =>
                    trim(($row['First_Name'] ?? '') . ' ' . ($row['Middle_Name'] ?? '') . ' ' . ($row['Last_Name'] ?? '')),

                    'Address' => function ($row) {
                        $addr = $row['Address'] ?? '';

                        if (is_string($addr)) {
                            $addr = json_decode($addr, true);
                        }

                        return is_array($addr)
                            ? implode(', ', array_filter([
                                $addr['present_address'] ?? '',
                                $addr['present_city'] ?? '',
                                $addr['present_district'] ?? '',
                                $addr['present_state'] ?? '',
                                $addr['present_pincode'] ?? '',
                            ]))
                            : '';
                    },

                    'Status' => fn($row) => ($row['Status'] ?? 0) == 1 ? 'Active' : 'Inactive',
                ],
            ],

            'wallet' => [
                'headers' => [
                    'User ID'   => 'user_id',
                    'Amount'    => 'amount',
                    'Type'      => 'type',
                    'Balance'   => 'balance',
                    'Created'   => 'created_at',
                ],
                'transformers' => [],
            ],

            'ledger' => [
                'headers' => [
                    'Txn ID'    => 'transaction_id',
                    'User'      => 'user_id',
                    'Credit'    => 'credit',
                    'Debit'     => 'debit',
                    'Remarks'   => 'remarks',
                    'Date'      => 'created_at',
                ],
                'transformers' => [],
            ],

            'users' => [
                'headers' => [
                    'User ID'   => 'id',
                    'Name'      => 'name',
                    'Email'     => 'email',
                    'Mobile'    => 'mobile',
                    'Role'      => 'role',
                    'Status'    => 'status',
                ],
                'transformers' => [
                    'status' => fn($row) => ($row['status'] ?? 0) ? 'Active' : 'Inactive',
                ],
            ],

        ][$module] ?? [];
    }
    public function exportExcel(Request $request)
    {
        $module = $request->input('method', 'students');

        $config = $this->getModuleConfig($module);
        if (empty($config)) {
            return response()->json(['message' => 'Invalid module'], 400);
        }

        $payload = $request->input('data', []);
        $payload = is_string($payload) ? json_decode($payload, true) : $payload;

        $data = $payload['data'] ?? [];
        if (!is_array($data) || empty($data)) {
            return response()->json(['message' => 'No data found'], 400);
        }

        $headers      = $config['headers'];
        $transformers = $config['transformers'] ?? [];

        /* ================= BUILD ROWS ================= */
        $rows = [];

        foreach ($data as $row) {
            $excelRow = [];

            foreach ($headers as $dbKey) {

                if (isset($transformers[$dbKey])) {
                    $value = $transformers[$dbKey]($row);
                } else {
                    $value = $row[$dbKey] ?? '';
                }

                if (is_array($value) || is_object($value)) {
                    $value = json_encode($value, JSON_UNESCAPED_UNICODE);
                }

                $excelRow[] = $value;
            }

            $rows[] = $excelRow;
        }

        /* ================= EXCEL ================= */
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray(array_keys($headers), null, 'A1');
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')
            ->getFont()->setBold(true);

        $sheet->fromArray($rows, null, 'A2');

        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $fileName = "{$module}_export_" . now()->format('Ymd_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(
            fn() => $writer->save('php://output'),
            $fileName,
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }
}
