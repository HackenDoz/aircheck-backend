<?php

namespace App\Database;

use Framework\Endpoint;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Index extends Endpoint
{
    private $database;

    public function __construct(Request $request, \PDO $database)
    {
        parent::__construct($request);
        $this->database = $database;
    }

    public function GET()
    {
        $id = $this->request->query->get('id');
        if ($id == null) {
            $query = $this->database->query('SELECT * from test', \PDO::FETCH_OBJ);
            return JsonResponse::create($query->fetchAll());
        } else {
            $query = $this->database->prepare('SELECT * from test WHERE id = ?');
            $query->execute(array($id));
            return JsonResponse::create($query->fetch(\PDO::FETCH_OBJ));
        }
    }

}