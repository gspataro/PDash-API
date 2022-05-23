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

    public function delete(): void
    {
        $this->response->setContentTypeHeader("application/json");
        $todoId = $this->request->post("id");

        if ($todoId && $this->todo->exists($todoId)) {
            $this->todo->delete($todoId);

            $this->sendResponse([
                "status" => "success",
                "message" => "Todo with ID '{$todoId}' deleted successfully!"
            ]);
        } else {
            $this->sendResponse([
                "status" => "error",
                "message" => "Cannot delete todo with ID '{$todoId}'. Todo not found."
            ]);
        }
    }
}
