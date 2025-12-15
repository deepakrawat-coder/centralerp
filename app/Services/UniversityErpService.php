<?php

namespace App\Services;

use App\Models\UniversityErp;

class UniversityErpService
{
    /**
     * Get ERP live URL by ERP ID
     * URL: /services/university_erp/get-live-url?id=1
     */
    public function getLiveUrl($params)
    {
        if (!isset($params['id'])) {
            abort(400, 'ERP ID is required');
        }

        $erp = UniversityErp::select('live_url')
            ->where('id', $params['id'])
            ->firstOrFail();

        // redirect to ERP
        return redirect()->away($erp->live_url);
    }

    /**
     * Search ERP by name (min 3 chars)
     * URL: /services/university_erp/search?q=maya
     */
    public function search($params)
    {
        $q = $params['q'] ?? '';

        if (strlen($q) < 3) {
            return [];
        }

        return UniversityErp::where('name', 'LIKE', "%{$q}%")
            ->select('id', 'name')
            ->limit(10)
            ->get();
    }
}
