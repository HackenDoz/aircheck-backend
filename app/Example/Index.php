<?php

namespace App\Example;

use Framework\Endpoint;
use Symfony\Component\HttpFoundation\JsonResponse;

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
