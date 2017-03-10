<?php

namespace Colourist\Tests;

abstract class ColourTestCase extends \PHPUnit\Framework\TestCase
{
  /**
   * @return string
   *   The name of the class that this TestCase is testing.
   */
  abstract protected function classToTest();

  /**
   * @return string[]
   *   A list of strings representing properties of the class to test.
   */
  abstract protected function properties();

  /**
   * @param array $args
   *   The arguments to pass to the constructor.
   *
   * @return mixed Returns a new object of type specified by testedClassName().
   *   Returns a new object of type specified by testedClassName().
   *
   * @see classToTest()
   */
  protected function newTestedClass(...$args)
  {
    $class = $this->classToTest();
    return new $class(...$args);
  }

  /**
   * @param object $expected
   *   Expected properties.
   * @param object $actual
   *   Actual properties.
   * @param array $except
   *   Properties to ignore in comparison.
   * @param string $message
   *   Message to display if properties don't match.
   */
  public function assertPropertiesSame($expected, $actual, $except = [], $message = '')
  {
    $expected_properties = [];
    $actual_properties = [];

    foreach ($this->properties() as $property) {
      if (in_array($property, $except)) {
        continue;
      }

      $expected_properties[$property] = $expected->$property();
      $actual_properties[$property] = $actual->$property();
    }

    $this->assertSame($expected_properties, $actual_properties, $message);
  }

  public function testGetters()
  {
    $i = 10;
    $properties = array_map(function ($property) use ($i) {
      $i += 10;
      return $i;
    }, $this->properties());

    $c = $this->newTestedClass(...$properties);

    $i = 0;
    foreach ($this->properties() as $property) {
      $this->assertSame($properties[$i], $c->$property());
      $i++;
    }
  }

  public function testEquals()
  {
    $colour = $this->newTestedClass(211, 90, 61);
    $other = $this->newTestedClass(211, 90, 61);
    $other_diff = $this->newTestedClass(211, 90, 63);
    $this->assertTrue($colour->equals($other));
    $this->assertFalse($colour->equals($other_diff));
  }
}
