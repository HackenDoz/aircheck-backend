<?php

namespace App\Submit;

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

    public function POST()
    {
        $status = true;

        $data = $this->getJSON();
        foreach ($data->symptoms as $id => $severity) {
            $query = $this->db->prepare("INSERT INTO reports (`latitude`, `longitude`, `symptom_id`, `severity`) VALUE (?, ?, ?, ?)");
            $status = $status && $query->execute([$data->latitude, $data->longitude, $id, $severity]);
        }
        return new JsonResponse(array(
            'status' => $status
        ));
    }
}