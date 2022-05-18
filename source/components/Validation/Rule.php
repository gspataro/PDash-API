<?php

namespace GSpataro\Validation;

abstract class Rule
{
    /**
     * Prepare a response
     *
     * @param bool $failed
     * @param ?string $code
     * @param ?string $expected
     * @param ?string $given
     * @return array
     */

    protected static function prepareResponse(
        bool $failed,
        ?string $code = null,
        ?string $expected = null,
        ?string $given = null
    ): array {
        $response = [
            "failed" => $failed,
            "code" => $code ?? "success"
        ];

        if ($failed) {
            $response += [
                "expected" => $expected,
                "given" => $given
            ];
        }

        return $response;
    }

    /**
     * Validate a value against this rule and return a response
     *
     * @param mixed $value
     * @param array $params
     * @return array
     */

    abstract public static function validate(mixed $value, array $params = []): array;
}
