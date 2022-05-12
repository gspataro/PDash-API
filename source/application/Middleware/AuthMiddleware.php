<?php

namespace PDash\Middleware;

use GSpataro\Routing\Middleware;

final class AuthMiddleware extends Middleware
{
    public function process(array $params = []): void
    {
        if ($this->request->get("access_key") !== API_ACCESS_KEY) {
            $this->response->redirect("accessDenied");
        }
    }
}
