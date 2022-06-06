<?php

namespace PDash\Form;

use PDash\Model\NoteModel;
use GSpataro\Routing\Request;
use GSpataro\Validation\Form;

class NoteInsert extends Form
{
    public function __construct(
        private Request $request,
        private NoteModel $noteModel
    ) {
        parent::__construct();
    }

    protected function createFields(): array
    {
        return [
            "title" => [
                "value" => (string) $this->request->post("title"),
                "rules" => ["required"]
            ],
            "content" => [
                "value" => (string) $this->request->post("content"),
                "rules" => ["required"]
            ]
        ];
    }

    protected function onSuccess(): void
    {
        $title = (string) $this->request->post("title");
        $content = (string) $this->request->post("content");

        $id = $this->noteModel->add(
            $title,
            $content
        );

        $this->response += [
            "data" => [
                "id" => $id,
                "title" => $title,
                "content" => $content
            ]
        ];
    }
}
