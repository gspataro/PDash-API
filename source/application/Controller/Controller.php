<?php

namespace PDash\Controller;

use GSpataro\Routing\Request;
use GSpataro\Routing\Response;
use GSpataro\Database\Connection;

abstract class Controller
{
    /**
     * Initialize controller
     *
     * @param Request $request
     * @param Response $response
     */

    public function __construct(
        protected Request $request,
        protected Response $response,
        protected Connection $db
    ) {
        if (method_exists($this, "init")) {
            $this->init();
        }
    }

    /**
     * Encode and send JSON response
     *
     * @param array $response
     * @return void
     */

    protected function sendResponse(array $response): void
    {
        echo json_encode($response);
    }
}
