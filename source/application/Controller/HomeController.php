<?php

namespace PDash\Controller;

use GSpataro\Routing\Controller;

final class HomeController extends Controller
{
    public function index()
    {
        echo "hello world";
    }

    public function pageNotFound()
    {
        echo "page not found";
    }

    public function methodNotAllowed()
    {
        echo "method not allowed";
    }
}
