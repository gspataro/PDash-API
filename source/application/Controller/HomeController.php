<?php

namespace PDash\Controller;

final class HomeController extends Controller
{
    public function index()
    {
        echo "You are successfully connected to the PDash API!";
    }

    public function pageNotFound()
    {
        echo "404 Page not found";
    }

    public function methodNotAllowed()
    {
        echo "405 Method not allowed";
    }

    public function accessDenied()
    {
        $this->response->setStatusHeader(401);
        echo "Access denied";
    }
}
