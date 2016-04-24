<?php

namespace App\WeatherMapping;

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

        $weather = $this->request->query->get('weather');
        
        if ($weather != null) {
            $query = $this->db->prepare('SELECT * FROM weather_mapping WHERE `weather_id` = ?');
            $status = $query->execute([$weather]);
            $heatmap = $query->fetchAll(\PDO::FETCH_OBJ);
        } else {
            $query = $this->db->query('SELECT * FROM weather_mapping');
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
