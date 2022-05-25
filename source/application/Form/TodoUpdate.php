<?php

namespace PDash\Form;

use PDash\Model\TodoModel;
use GSpataro\Routing\Request;
use GSpataro\Validation\Form;

class TodoUpdate extends Form
{
    public function __construct(
        private Request $request,
        private TodoModel $todoModel
    ) {
        parent::__construct();
    }

    protected function createFields(): array
    {
        return [
            "id" => [
                "value" => (int) $this->request->input("id"),
                "rules" => ["required"]
            ]
        ];
    }

    protected function onSuccess(): void
    {
        $content = (string) $this->request->input("content");
        $completed = !is_null($this->request->input("completed")) && strlen($this->request->input("completed") > 0);
        $id = (int) $this->request->input("id");

        $affectedRows = $this->todoModel->update(
            $id,
            $content,
            $completed
        );

        $this->response += [
            "data" => [
                "id" => $id,
                "affected_rows" => $affectedRows
            ]
        ];
    }
}
