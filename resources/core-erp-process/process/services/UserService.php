<?php
require_once "BaseService.php";

class UserService extends BaseService
{
    public function list($uniId = null, $filters = [])
    {
        $this->logger->info("Fetching user list", [
            "uni_id"  => $uniId,
            "filters" => $filters
        ]);

        // BASE QUERY
        $sql = "SELECT * FROM Users WHERE 1=1";
        $params = [];

        // If university filter exists
        if (!empty($uniId)) {
            $sql .= " AND University_ID = ?";
            $params[] = $uniId;
        }

        // Optional filter: Role
        if (!empty($filters['role'])) {
            $sql .= " AND Role = ?";
            $params[] = $filters['role'];
        }

        // Optional filter: Status
        if (isset($filters['status'])) {
            $sql .= " AND Status = ?";
            $params[] = $filters['status'];
        }

        // Optional filter: Name
        if (!empty($filters['name'])) {
            $sql .= " AND Name LIKE ?";
            $params[] = "%" . $filters['name'] . "%";
        }

        // Optional filter: Date range
        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $sql .= " AND Created_At BETWEEN ? AND ?";
            $params[] = $filters['from_date'];
            $params[] = $filters['to_date'];
        }

        // SORT
        $sql .= " ORDER BY ID DESC";

        // PREPARE & EXECUTE
        $stmt = $this->db->prepare($sql);

        if (!$stmt->execute($params)) {
            $error = implode(" | ", $stmt->errorInfo());
            throw new Exception("SQL Failed: " . $error);
        }

        // RETURN DATA ARRAY
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
