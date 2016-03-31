<?php

use Colourist\Tests\ColourTestCase;

class RgbTest extends ColourTestCase
{
  protected function classToTest()
  {
    return "\\Colourist\\RGB";
  }

  public function testGetters()
  {
    $colour = $this->newTestedClass(10, 20, 30);
    $this->assertSame(10, $colour->red());
    $this->assertSame(20, $colour->green());
    $this->assertSame(30, $colour->blue());
  }

  public function testRounding()
  {
    $colour = $this->newTestedClass(10.5, 20.3, 29.7);
    $this->assertSame(10, $colour->red());
    $this->assertSame(20, $colour->green());
    $this->assertSame(30, $colour->blue());
  }

  public function testToHex()
  {
    $colour = $this->newTestedClass(10, 20, 30);
    $this->assertSame('#0A141E', $colour->toHex());
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testInvalidRedUnderBounds()
  {
    $this->newTestedClass(-1, 20, 30);
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testInvalidRedOverBounds()
  {
    $this->newTestedClass(256, 20, 30);
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testInvalidGreenUnderBounds()
  {
    $this->newTestedClass(10, -1, 30);
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testInvalidGreenOverBounds()
  {
    $this->newTestedClass(10, 256, 30);
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testInvalidBlueUnderBounds()
  {
    $this->newTestedClass(10, 20, -1);
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testInvalidBlueOverBounds()
  {
    $this->newTestedClass(10, 20, 256);
  }
}
