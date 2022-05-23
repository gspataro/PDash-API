<?php

namespace PDash\Model;

use PDO;

final class TodoModel extends Model
{
    /**
     * Get all the todo from the database
     *
     * @return array
     */

    public function getAll($order): array
    {
        $query = $this->db->prepare("SELECT * FROM todo ORDER BY id {$order}");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Add a new todo and return its id
     *
     * @param string $content
     * @param bool $completed
     * @return int
     */

    public function add(string $content, bool $completed = false): int
    {
        $query = $this->db->prepare("INSERT INTO todo (content, completed) VALUES (:content, :completed)");
        $query->execute([
            "content" => $content,
            "completed" => (int) $completed
        ]);

        return $this->db->lastInsertId();
    }

    /**
     * Update a todo and returns the number of affected rows
     *
     * @param int $id
     * @param string|null $content
     * @param bool|null $completed
     * @return void
     */

    public function update(int $id, ?string $content, ?bool $completed): int
    {
        $query = $this->db->prepare("UPDATE todo
            SET content = case when :content is not null and length(:content) > 0
                        then :content
                        else content
                    end,
                completed = case when :completed is not null and length(:completed) > 0
                        then :completed
                        else completed
                    end
            WHERE id = :id");
        $query->execute([
            "content" => $content,
            "completed" => (int) $completed,
            "id" => $id
        ]);

        return $query->rowCount();
    }

    /**
     * Verify if a todo exists
     *
     * @param int $id
     * @return bool
     */

    public function exists(int $id): bool
    {
        $query = $this->db->prepare("SELECT * FROM todo WHERE id = :id");
        $query->execute([
            "id" => $id
        ]);

        return $query->rowCount() > 0;
    }

    /**
     * Delete a todo
     *
     * @param int $id
     * @return void
     */

    public function delete(int $id): void
    {
        $query = $this->db->prepare("DELETE FROM todo WHERE id = :id");
        $query->execute([
            "id" => $id
        ]);
    }
}
