<?php

namespace PDash\Controller;

use PDash\Form;
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

        $this->sendResponse($this->todo->getAll($order));
    }

    public function insert(): void
    {
        $this->response->setContentTypeHeader("application/json");

        $form = new Form\TodoInsert($this->request, $this->todo);
        $form->validate();

        $this->sendResponse($form->getResponse());
    }

    public function update(): void
    {
        $this->response->setContentTypeHeader("application/json");

        $form = new Form\TodoUpdate($this->request, $this->todo);
        $form->validate();

        $this->sendResponse($form->getResponse());
    }
}
