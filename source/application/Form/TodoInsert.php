<?php

namespace PDash\Form;

use PDash\Model\TodoModel;
use GSpataro\Routing\Request;
use GSpataro\Validation\Form;

class TodoInsert extends Form
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
            "content" => [
                "value" => (string) $this->request->post("content"),
                "rules" => ["required"]
            ]
        ];
    }

    protected function onSuccess(): void
    {
        $content = (string) $this->request->post("content");
        $completed = $this->request->post("completed") ? true : false;

        $id = $this->todoModel->add(
            $content,
            $completed
        );

        $this->response += [
            "data" => [
                "id" => $id,
                "content" => $content,
                "completed" => $completed
            ]
        ];
    }
}
