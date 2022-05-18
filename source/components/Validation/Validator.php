<?php

namespace GSpataro\Validation;

class Validator
{
    /**
     * Store validator execution status
     *
     * @var bool
     */

    protected bool $executed = false;

    /**
     * Store validator failed status
     *
     * @var bool
     */

    protected bool $failed = false;

    /**
     * Store validator response
     *
     * @var array
     */

    protected array $response = [];

    /**
     * Store rules
     *
     * @var array
     */

    private static array $rules = [];

    /**
     * Store rule tag regex
     *
     * @var string
     */

    private static string $ruleTagRegex = "/^(.+)\((.+)\)$/";

    /**
     * Load default rules
     *
     * @return void
     */

    public static function loadDefaultRules(): void
    {
        self::addRule("required", Rule\RequiredRule::class);
        self::addRule("maxlength", Rule\MaxLengthRule::class);
        self::addRule("minlength", Rule\MinLengthRule::class);
    }

    /**
     * Verify if a rule exists
     *
     * @param string $tag
     * @return bool
     */

    public static function hasRule(string $tag): bool
    {
        return isset(self::$rules[$tag]);
    }

    /**
     * Verify if a rule exists or throw an exception
     *
     * @param string $tag
     * @return void
     */

    public static function hasRuleOrDie(string $tag): void
    {
        if (preg_match(self::$ruleTagRegex, $tag, $matches)) {
            $tag = $matches[1];
        }

        if (!self::hasRule($tag)) {
            throw new Exception\RuleNotFoundException(
                "Rule named '{$tag}' not found."
            );
        }
    }

    /**
     * Add a rule
     *
     * @param string $tag
     * @param string $ruleClass
     * @return void
     */

    public static function addRule(string $tag, string $ruleClass): void
    {
        if (self::hasRule($tag)) {
            throw new Exception\RuleFoundException(
                "Rule named '{$tag}' already exists."
            );
        }

        if (get_parent_class($ruleClass) !== Rule::class) {
            throw new Exception\InvalidRuleException(
                "Invalid rule named '{$tag}'. A rule must extend the GSpataro\Validation\Rule abstract class."
            );
        }

        self::$rules[$tag] = $ruleClass;
    }

    /**
     * Get a rule
     *
     * @param string $tag
     * @return Rule
     */

    public static function getRule(string $tag): string
    {
        self::hasRuleOrDie($tag);
        return self::$rules[$tag];
    }

    /**
     * Verify if the validator failed
     *
     * @return bool
     */

    public function hasFailed(): bool
    {
        return $this->failed;
    }

    /**
     * Validate a value against a rule
     *
     * @param mixed $value
     * @param string $ruleTag
     * @return array
     */

    protected function validateAgainstRule(mixed $value, string $ruleTag): array
    {
        if (preg_match(self::$ruleTagRegex, $ruleTag, $matches)) {
            $ruleTag = $matches[1];
            $ruleParams = explode(",", trim($matches[2]));
        }

        $rule = self::getRule($ruleTag);
        return $rule::validate($value, $ruleParams ?? []);
    }

    /**
     * Get validator response
     *
     * @return array
     */

    public function getResponse(): array
    {
        return $this->executed ? $this->response : ["failed" => true, "code" => "form_not_executed"];
    }
}
