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
}
