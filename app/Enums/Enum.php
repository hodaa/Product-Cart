<?php

namespace App\Enums;

use ReflectionClass;
use UnexpectedValueException;

class Enum
{
    /**
     * Default enum value.
     *
     * @constant(__default)
     */
    public const __default = null;

    /**
     * Enum value.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Enum constructor.
     * @param null $value
     */

    public function __construct($value = null)
    {
        $reflected = new ReflectionClass($this);

        if (!in_array($value, $reflected->getConstants())) {
            throw new UnexpectedValueException("Value '$value' is not part of the enum " . get_called_class());
        }

        $this->value = $value;
    }

    /**
     * Get an array of all enum constants.
     *
     * @param bool $include_default include default value or not
     *
     * @return array
     *
     */
    public static function getValues(bool $include_default = false): array
    {
        $reflected = new ReflectionClass(new static(null));
        $constants = $reflected->getConstants();
        if (!$include_default) {
            unset($constants['__default']);
            return array_values($constants);
        }
        return array_values($constants);
    }


    /**
     * Get an array of all enum constants.
     *
     * @param bool $include_default include default value or not
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function getConstList($include_default = false)
    {
        $reflected = new ReflectionClass(new static(null));

        $constants = $reflected->getConstants();

        if (!$include_default) {
            unset($constants['__default']);

            return $constants;
        }

        return $constants;
    }

    /**
     * String representation of the enum.
     *
     * @return string
     */
    final public function __toString()
    {
        return strval($this->value);
    }

    /**
     * @param $value
     * @return string
     * @throws \ReflectionException
     */
    public static function getName($value)
    {
        $constants = array_flip(self::getConstList());
        return strtolower($constants[$value]);
    }
    /**
     * @param string $key
     * @return mixed|string
     * @throws \ReflectionException
     */
    public static function getValue(string $key)
    {
        $constants = array_change_key_case(self::getConstList(), CASE_LOWER);
        return $constants[$key];
    }
}
