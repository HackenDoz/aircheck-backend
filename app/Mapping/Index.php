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

        $query = $this->db->query('SELECT * FROM mapping');
        $heatmap = $query->fetchAll(\PDO::FETCH_OBJ);

        return new JsonResponse(array(
            'status' => $status,
            'heatmap' => $heatmap
        ));
    }
}