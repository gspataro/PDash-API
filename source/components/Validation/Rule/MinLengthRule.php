<?php

namespace GSpataro\Validation\Rule;

use GSpataro\Validation\Rule;

final class MinLengthRule extends Rule
{
    public static function validate(mixed $value, array $params = []): array
    {
        if (isset($params[0]) && (is_null($value) || strlen($value) < $params[0])) {
            return self::prepareResponse(true, "minlength", $params[0], strlen($value));
        }

        return self::prepareResponse(false);
    }
}
