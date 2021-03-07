<?php

final class CustomNumberType
{
    private array $definition;

    public function __construct(int|array $definition)
    {
        $this->definition = is_int($definition)
            ? self::convert($definition)
            : $definition;
    }

    public static function convert(int $integer)
    {
        $definition = [];
        
        while ($integer > 9) {
            $currentDigit = $integer % 10;
            array_unshift($definition, $currentDigit);
            $integer = ($integer - $currentDigit) / 10;
        }
        
        array_unshift($definition, $integer);
        return $definition;
    }

    public function __toString()
    {
        return implode('', $this->definition);
    }
    
    public function increment(int $increment = 1) {
        $definition = $this->_increment(
            $this->definition, 
            count($this->definition) - 1, 
            $increment
        );

        return new self($definition);
    }

    private function _increment(array $number, int $index, int $carry) {
        if ($index < 0) {
            return array_merge(self::convert($carry), $number);
        } 

        $incremented = $number[$index] + $carry;
        if ($incremented < 9) {
            $number[$index] = $incremented;
            return $number;
        }

        $number[$index] = $incremented % 10;
        $carry = ($incremented - $number[$index]) / 10;
        return $this->_increment($number, $index - 1, $carry);
    }
}

// Single digit increment
$number = new CustomNumberType([1, 2, 2]);
echo $number->increment(1);
echo PHP_EOL;

// Increment with one carry
$number = new CustomNumberType([1, 2, 9]);
echo $number->increment(1);
echo PHP_EOL;

// Increment with multiple carries
$number = new CustomNumberType([1, 9, 9]);
echo $number->increment(1);
echo PHP_EOL;

// Increment with multiple carries and a prepend
$number = new CustomNumberType([9, 9]);
echo $number->increment(1);
echo PHP_EOL;

// Multi-digit increment with multiple carries and preprends
$number = new CustomNumberType([8, 9]);
echo $number->increment(2113);
echo PHP_EOL;