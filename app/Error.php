<?php

namespace App;

use Framework\Endpoint;
use Symfony\Component\HttpFoundation\JsonResponse;

class Error extends Endpoint
{
    public function GET()
    {
        return new JsonResponse(array(
            'error' => 'An unspecified error occurred'
        ));
    }
}