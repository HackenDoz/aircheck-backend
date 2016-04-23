<?php

namespace App\Mapping;

use Framework\Endpoint;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Index extends Endpoint
{
    private $db;

    public function __construct(Request $request, \PDO $db)
    {
        parent::__construct($request);
        $this->db = $db;
    }

    public function GET()
    {
        $status = true;
        $heatmap = null;

        $symptom = $this->request->query->get('symptom');
        if ($symptom != null) {
            $query = $this->db->prepare('SELECT * FROM mapping WHERE `symptom_id` = ?');
            $status = $query->execute([$symptom]);
            $heatmap = $query->fetchAll(\PDO::FETCH_OBJ);
        } else {
            $query = $this->db->query('SELECT * FROM mapping');
            $heatmap = $query->fetchAll(\PDO::FETCH_OBJ);
        }

        if ($status) {
            return new JsonResponse(array(
                'status' => $status,
                'heatmap' => $heatmap
            ));
        } else {
            return new JsonResponse(array(
                'status' => $status,
            ));
        }
    }
}