<?php

namespace Colourist\Tests;

abstract class ColourTestCase extends \PHPUnit_Framework_TestCase
{
  abstract protected function classToTest();

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
}
