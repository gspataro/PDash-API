<?php

namespace PDash\Model;

use PDO;

final class NoteModel extends Model
{
    /**
     * Get all the notes from the database
     *
     * @return array
     */

    public function getAll($order): array
    {
        $query = $this->db->prepare("SELECT * FROM notes ORDER BY id {$order}");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Add a new note and return its id
     *
     * @param string $title
     * @param string $content
     * @return int
     */

    public function add(string $title, string $content): int
    {
        $query = $this->db->prepare("INSERT INTO notes (title, content) VALUES (:title, :content)");
        $query->execute([
            "title" => $title,
            "content" => $content
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Update a note and returns the number of affected rows
     *
     * @param int $id
     * @param string|null $title
     * @param string|null $content
     * @return void
     */

    public function update(int $id, ?string $title, ?bool $content): int
    {
        $query = $this->db->prepare("UPDATE notes
            SET title = case when :title is not null and length(:title) > 0
                        then :title
                        else title
                    end,
                content = case when :content is not null and length(:content) > 0
                        then :content
                        else content
                    end
            WHERE id = :id");
        $query->execute([
            "title" => $title,
            "content" => $content,
            "id" => $id
        ]);

        return $query->rowCount();
    }

    /**
     * Verify if a note exists
     *
     * @param int $id
     * @return bool
     */

    public function exists(int $id): bool
    {
        $query = $this->db->prepare("SELECT * FROM notes WHERE id = :id");
        $query->execute([
            "id" => $id
        ]);

        return $query->rowCount() > 0;
    }

    /**
     * Delete a note
     *
     * @param int $id
     * @return void
     */

    public function delete(int $id): void
    {
        $query = $this->db->prepare("DELETE FROM notes WHERE id = :id");
        $query->execute([
            "id" => $id
        ]);
    }
}
