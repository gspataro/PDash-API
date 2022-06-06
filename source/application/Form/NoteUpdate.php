<?php

namespace PDash\Form;

use PDash\Model\NoteModel;
use GSpataro\Routing\Request;
use GSpataro\Validation\Form;

class NoteUpdate extends Form
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
            "id" => [
                "value" => (int) $this->request->input("id"),
                "rules" => ["required"]
            ]
        ];
    }

    protected function onSuccess(): void
    {
        $title = (string) $this->request->input("title");
        $content = (string) $this->request->input("content");
        $id = (int) $this->request->input("id");

        $affectedRows = $this->noteModel->update(
            $id,
            $title,
            $content
        );

        $this->response += [
            "data" => [
                "id" => $id,
                "affected_rows" => $affectedRows
            ]
        ];
    }
}
