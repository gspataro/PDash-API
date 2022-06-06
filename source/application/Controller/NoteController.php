<?php

namespace PDash\Controller;

use PDash\Form;
use PDash\Model\NoteModel;

final class NoteController extends Controller
{
    private NoteModel $note;

    public function init(): void
    {
        $this->note = new NoteModel($this->db);
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

        $this->sendResponse($this->note->getAll($order));
    }

    public function insert(): void
    {
        $this->response->setContentTypeHeader("application/json");

        $form = new Form\NoteInsert($this->request, $this->note);
        $form->validate();

        $this->sendResponse($form->getResponse());
    }

    public function update(): void
    {
        $this->response->setContentTypeHeader("application/json");

        $form = new Form\NoteUpdate($this->request, $this->note);
        $form->validate();

        $this->sendResponse($form->getResponse());
    }

    public function delete(): void
    {
        $this->response->setContentTypeHeader("application/json");
        $noteId = $this->request->input("id");

        if ($noteId && $this->note->exists($noteId)) {
            $this->note->delete($noteId);

            $this->sendResponse([
                "status" => "success",
                "message" => "Todo with ID '{$noteId}' deleted successfully!"
            ]);
        } else {
            $this->sendResponse([
                "status" => "error",
                "message" => "Cannot delete todo with ID '{$noteId}'. Todo not found."
            ]);
        }
    }
}
