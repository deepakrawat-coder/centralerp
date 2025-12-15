

<?php

require_once "BaseService.php";

class StudentService extends BaseService
{
    public function list($uniId, $filters = [])
    {
        $this->logger->info("Fetching student list", [
            "uni_id" => $uniId,
            "filters" => $filters
        ]);

        $sql = "SELECT * FROM Students WHERE University_ID = ?";
        $params = [$uniId];

        // OPTIONAL FILTER (example)
        if (!empty($filters['course_id'])) {
            $sql .= " AND Course_ID = ?";
            $params[] = $filters['course_id'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

