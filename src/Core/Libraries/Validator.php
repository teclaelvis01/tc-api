<?php

namespace App\Core\Libraries;

/**
 * Validator
 * @author Elvis Reyes <teclaelvis01@gmail.com>
 * @package App\Core\Libraries
 */
class Validator
{
    public static $errors = [];

    public static function make($data, $rules)
    {
        // validate rules with data
        foreach ($rules as $key => $rule) {
            $rulesArray = explode('|', $rule);
            foreach ($rulesArray as $rule) {
                $ruleParams = [];
                if(strpos($rule, ":") !== false){
                    $rule = explode(':', $rule);
                    $ruleParams = explode(',', $rule[1]);
                    $rule = $rule[0];
                }
                if (!isset($data[$key])) {
                    self::$errors[$key][] = "The $key field not found";
                    break;
                }
                self::$rule($data[$key], $key, $ruleParams);
            }
        }

        return new static;
    }

    public function fails()
    {
        return count(self::$errors) > 0;
    }

    public static function required($value, $key, $params = [])
    {
        if (empty($value)) {
            self::$errors[$key][] = "This field {$key} is required";
        }
    }
    public static function email($value, $key, $params = [])
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            self::$errors[$key][] = "This field {$key} is not valid email";
        }
    }

    public static function numeric($value, $key, $params = [])
    {
        if (!is_numeric($value)) {
            self::$errors[$key][] = "This field {$key} is not valid numeric";
        }
    }
    public static function date($value, $key, $params = [])
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            self::$errors[$key][] = "This field {$key} is not valid date";
        }
    }
    public static function enum($value, $key, $params = [])
    {
        if (!in_array($value, $params)) {
            self::$errors[$key][] = "This field {$key} is not valid enum";
        }
    }

    public function errors()
    {
        return self::$errors;
    }
}
