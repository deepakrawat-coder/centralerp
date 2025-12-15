<?php

namespace App\Http\Controllers;

use App\Models\UniversityErp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UniversityErpController extends Controller
{
    /**
     * Display a listing of university ERPs.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $erps = UniversityErp::all();
            $serial = 1;

            return response()->json([
                'data' => $erps->map(function ($erp) use (&$serial) {
                    $editUrl = route('university-erp.edit', $erp->id);
                    $deleteUrl = route('university-erp.destroy', $erp->id);

                    $action = '
                        <a onclick="edit(\'' . $editUrl . '\', \'modal-md\')" 
                           class="text-warning"
                           data-bs-toggle="tooltip"
                           data-bs-placement="top"
                           title="Edit ERP">
                            <i class="ri-edit-circle-line fs-5"></i>
                        </a>

                        <a onclick="destroy(\'' . $deleteUrl . '\', \'erp-table\')" 
                           class="text-danger deleteBtn"
                           data-bs-toggle="tooltip"
                           data-bs-placement="top"
                           title="Delete ERP">
                            <i class="ri-delete-bin-line fs-5"></i>
                        </a>
                    ';

                    return [
                        'serial'   => $serial++,
                        'name'     => $erp->name,
                        'live_url' => $erp->live_url,
                        'logo' => $erp->logo ? $erp->logo : 'N/A',
                        'action'   => $action,
                    ];
                })
            ]);
        }

        return view('university-erp.index');
    }
    public function create()
    {
        // dd('dddsds');
        return view('university-erp.create');
    }
    /**
     * Store a newly created ERP.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'live_url' => 'nullable|url',
            'logo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $data = $request->only(['name', 'live_url']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->logo->store('university_logos', 'public');
        }

        $erp = UniversityErp::create($data);

        // return response()->json([
        //     'status'  => 'success',
        //     'message' => 'University ERP created successfully!',
        //     'data'    => $erp
        // ]);
        return response()->json([
            'status'  => 'success',
            'message' => 'University ERP created successfully!'
        ]);
    }

    /**
     * Show the form for editing ERP.
     */
    public function edit($id)
    {

        $erp = UniversityErp::findOrFail($id);

        return view('university-erp.edit', compact('erp'));
    }

    /**
     * Update the specified ERP.
     */
    // public function update(Request $request, $id)
    // {
    //     // dd($request->all());
    //     $erp = UniversityErp::findOrFail($id);

    //     $request->validate([
    //         'name'     => 'required|string|max:255',
    //         'live_url' => 'nullable|url',
    //         'logo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
    //     ]);

    //     $erp->name = $request->name;
    //     $erp->live_url = $request->live_url;

    //     if ($request->hasFile('logo')) {
    //         if ($erp->logo && Storage::disk('public')->exists($erp->logo)) {
    //             Storage::disk('public')->delete($erp->logo);
    //         }
    //         $erp->logo = $request->logo->store('university_logos', 'public');
    //     }

    //     $erp->save();

    //     return response()->json([
    //         'status'  => 'success',
    //         'message' => 'University ERP updated successfully!',
    //         'data'    => $erp
    //     ]);
    // }
    public function update(Request $request, $id)
    {
        $erp = UniversityErp::findOrFail($id);

        // Validate only the fields that are present
        $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'live_url' => 'sometimes|nullable|url',
            'logo'     => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $data = [];

        if ($request->has('name')) {
            $data['name'] = $request->name;
        }

        if ($request->has('live_url')) {
            $data['live_url'] = $request->live_url;
        }

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($erp->logo && Storage::disk('public')->exists($erp->logo)) {
                Storage::disk('public')->delete($erp->logo);
            }

            // Store new logo
            $data['logo'] = $request->logo->store('university_logos', 'public');
        }

        // Update only the provided fields
        $erp->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'University ERP updated successfully!',
            'data'    => $erp
        ]);
    }

    /**
     * Remove the specified ERP.
     */
    public function destroy($id)
    {
        $erp = UniversityErp::findOrFail($id);

        if ($erp->logo && Storage::disk('public')->exists($erp->logo)) {
            Storage::disk('public')->delete($erp->logo);
        }

        $erp->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'University ERP deleted successfully!'
        ]);
    }
    // public function search(Request $request)
    // {
    //     $query = $request->input('q');

    //     if (strlen($query) < 3) {
    //         return response()->json([]);
    //     }

    //     $erps = UniversityErp::where('name', 'like', $query . '%') // first 3+ chars
    //         ->limit(10)
    //         ->get(['id', 'name', 'logo']);

    //     return response()->json($erps);
    // }
    public function search(Request $request)
    {
        $query = $request->input('q');

        // Only search if 3 or more characters typed
        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $erps = UniversityErp::where('name', 'like', '%' . $query . '%') // search anywhere in the name
            ->limit(10)
            ->get(['id', 'name', 'logo']);

        return response()->json($erps);
    }

    public function fetchData($service, $method)
    {
        // Example: You can use the $service and $method parameters to determine what data to fetch
        // For demonstration, let's assume we are fetching ERP data based on service and method

        // You can implement your logic here based on $service and $method
        // For now, let's just return all ERPs as an example

        

        return response()->json([
            'status' => 'success',
            'data'   => $erps
        ]);
    }
}
