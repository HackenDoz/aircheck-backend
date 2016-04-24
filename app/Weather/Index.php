<?php

namespace App\Weather;

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
        
        $query = $this->db->query('SELECT * FROM weather');
        $weather = $query->fetchAll(\PDO::FETCH_OBJ);

        return new JsonResponse(array(
            'status' => $status,
            'weather' => $weather
        ));
    }

    public function POST()
    {
        return new JsonResponse(array(
            'status' => false,
            'message' => "This feature is waiting on completion."
        ));
    }
}
