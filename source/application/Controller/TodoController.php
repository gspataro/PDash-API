<?php

namespace PDash\Controller;

use PDash\Model\TodoModel;

final class TodoController extends Controller
{
    private TodoModel $todo;

    public function init(): void
    {
        $this->todo = new TodoModel($this->db);
    }

    public function list(): void
    {
        $this->response->setContentTypeHeader("application/json");
        $order = "asc";

        if ($this->request->get("order")) {
            $order = match ($this->request->get("order")) {
                "asc" => "ASC",
                "desc" => "DESC",
                default => "ASC"
            };
        }

        echo json_encode($this->todo->getAll($order));
    }

    public function insert(): void
    {
    }
}
