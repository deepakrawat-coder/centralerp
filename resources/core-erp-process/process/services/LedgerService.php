<?php

require_once "BaseService.php";

class LedgerService extends BaseService
{
    public function list($uniId, $filters = [])
    {
        $this->logger->info("Fetching ledger list", [
            "uni_id"  => $uniId,
            "filters" => $filters
        ]);

        $sql = "SELECT * 
                FROM Student_Ledgers 
                WHERE University_ID = ?";
        
        $params = [$uniId];

        // Filter by Student ID
        if (!empty($filters['student_id'])) {
            $sql .= " AND Student_ID = ?";
            $params[] = $filters['student_id'];
        }

        // Filter by Type
        if (!empty($filters['type'])) {
            $sql .= " AND Type = ?";
            $params[] = $filters['type'];
        }

        // Min Amount — Fee or Settlement_Amount?
        if (!empty($filters['min_amount'])) {
            $sql .= " AND Settlement_Amount >= ?";
            $params[] = $filters['min_amount'];
        }

        // Max Amount
        if (!empty($filters['max_amount'])) {
            $sql .= " AND Settlement_Amount <= ?";
            $params[] = $filters['max_amount'];
        }

        // Date Range (Using correct column: Date)
        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $sql .= " AND Date BETWEEN ? AND ?";
            $params[] = $filters['from_date'];
            $params[] = $filters['to_date'];
        }

        // Order latest
        $sql .= " ORDER BY Date DESC";

        $stmt = $this->db->prepare($sql);

        if (!$stmt->execute($params)) {
            throw new Exception("SQL Failure: " . implode(" | ", $stmt->errorInfo()));
        }
// print_r($stmt->fetchAll(PDO::FETCH_ASSOC));die;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
