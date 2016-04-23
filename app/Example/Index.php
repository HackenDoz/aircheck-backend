<?php

namespace App\Example;

use Framework\Endpoint;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Index extends Endpoint
{
    public function GET()
    {
        $schema = array(
            'ayy' => 'lmao'
        );
        
        return new JsonResponse($schema);
    }
}
