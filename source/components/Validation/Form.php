<?php

namespace GSpataro\Validation;

abstract class Form extends Validator
{
    /**
     * Store form fields
     *
     * @var array
     */

    private array $fields = [];

    /**
     * Initialize a form
     */

    public function __construct()
    {
        foreach ($this->createFields() as $tag => $data) {
            $this->addField($tag, $data['value'] ?? null, $data['rules'] ?? []);
        }
    }

    /**
     * Create fields
     *
     * @return array
     */

    protected function createFields(): array
    {
        return [];
    }

    /**
     * Verify if the form has a field
     *
     * @param string $tag
     * @return bool
     */

    public function hasField(string $tag): bool
    {
        return isset($this->fields[$tag]);
    }

    /**
     * Add a field to the form
     *
     * @param string $tag
     * @param mixed $value
     * @param array $rules
     * @return void
     */

    public function addField(string $tag, mixed $value, array $rules): void
    {
        if ($this->hasField($tag)) {
            throw new Exception\FieldFoundException(
                "Field named '{$tag}' already added to the form."
            );
        }

        for ($i = 0; $i < count($rules); $i++) {
            self::hasRuleOrDie($rules[$i]);
        }

        $this->fields[$tag] = [
            "value" => $value,
            "rules" => $rules
        ];
    }

    /**
     * Get a field from the form
     *
     * @param string $tag
     * @return array
     */

    public function getField(string $tag): array
    {
        if (!$this->hasField($tag)) {
            throw new Exception\FieldNotFoundException(
                "Field named '{$tag}' not found."
            );
        }

        return $this->fields[$tag];
    }

    /**
     * Validate a value against multiple rules
     * If a rule validation fails, return the first failed rule response
     *
     * @param mixed $value
     * @param array $rules
     * @return array
     */

    public function validateAgainstRules(mixed $value, array $rules): array
    {
        $lastResponse = [];

        foreach ($rules as $ruleTag) {
            $lastResponse = $this->validateAgainstRule($value, $ruleTag);

            if ($lastResponse['failed']) {
                break;
            }
        }

        return $lastResponse;
    }

    /**
     * Validate the form
     *
     * @return void
     */

    public function validate(): void
    {
        $this->executed = true;

        foreach ($this->fields as $tag => $field) {
            $response = $this->validateAgainstRules($field['value'], $field['rules']);
            $this->response = $response;

            if ($response['failed']) {
                $this->failed = true;
                $this->response['field'] = $tag;
                $this->onFail();
                return;
            }
        }

        $this->onSuccess();
    }

    /**
     * Form action to execute on success
     *
     * @return void
     */

    protected function onSuccess(): void
    {
    }

    /**
     * Form action to execute on fail
     *
     * @return void
     */

    protected function onFail(): void
    {
    }
}
