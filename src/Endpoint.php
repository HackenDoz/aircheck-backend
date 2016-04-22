<?php

namespace Framework;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Endpoint
{
    /**
     * The request for the endpoint
     *
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Create a JsonResponse for an error
     *
     * @param $message string Message to be displayed
     * @return Response
     */
    protected function createError($message)
    {
        return new JsonResponse(array(
            'error' => $message,
            'endpoint' => $this->request->getPathInfo()
        ));
    }

    public function GET()
    {
        return $this->createError('Invalid request method for this endpoint');
    }

    public function POST()
    {
        return $this->createError('Invalid request method for this endpoint');
    }

    public function PUT()
    {
        return $this->createError('Invalid request method for this endpoint');
    }

    public function DELETE()
    {
        return $this->createError('Invalid request method for this endpoint');
    }

    public function HEAD()
    {
        return $this->GET();
    }
}