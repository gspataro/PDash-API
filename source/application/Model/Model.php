<?php

namespace PDash\Model;

use GSpataro\Database\Connection;

abstract class Model
{
    /**
     * Initialize model
     *
     * @param Connection $db
     */

    public function __construct(
        protected Connection $db
    ) {
    }
}
