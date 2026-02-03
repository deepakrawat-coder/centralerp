<?php

require_once "BaseService.php";

class WalletService extends BaseService
{
    public function list($uniId, $filters = [])
    {
        $this->logger->info("Fetching wallet list", [
            "uni_id"  => $uniId,
            "filters" => $filters
        ]);

        $sql = "SELECT * 
                FROM Wallets 
                WHERE University_ID = ?";
        
        $params = [$uniId];

        // OPTIONAL FILTERS
        
        // Filter by user
        if (!empty($filters['user_id'])) {
            $sql .= " AND User_ID = ?";
            $params[] = $filters['user_id'];
        }

        // Filter by minimum balance
        if (!empty($filters['min_balance'])) {
            $sql .= " AND Balance >= ?";
            $params[] = $filters['min_balance'];
        }

        // Filter by maximum balance
        if (!empty($filters['max_balance'])) {
            $sql .= " AND Balance <= ?";
            $params[] = $filters['max_balance'];
        }

        // Date range filter
        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $sql .= " AND DATE(Updated_At) BETWEEN ? AND ?";
            $params[] = $filters['from_date'];
            $params[] = $filters['to_date'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
