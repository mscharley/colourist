<?php

class RgbTest extends PHPUnit_Framework_TestCase
{
  public function testGetters()
  {
    $colour = new \Colourist\RGB(10, 20, 30);
    $this->assertSame(10, $colour->red());
    $this->assertSame(20, $colour->green());
    $this->assertSame(30, $colour->blue());
  }

  public function testRounding()
  {
    $colour = new \Colourist\RGB(10.5, 20.3, 29.7);
    $this->assertSame(11, $colour->red());
    $this->assertSame(20, $colour->green());
    $this->assertSame(30, $colour->blue());
  }

  public function testToHex()
  {
    $colour = new \Colourist\RGB(10, 20, 30);
    $this->assertSame('#0A141E', $colour->toHex());
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testInvalidRedUnderBounds()
  {
    new \Colourist\RGB(-1, 20, 30);
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testInvalidRedOverBounds()
  {
    new \Colourist\RGB(256, 20, 30);
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testInvalidGreenUnderBounds()
  {
    new \Colourist\RGB(10, -1, 30);
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testInvalidGreenOverBounds()
  {
    new \Colourist\RGB(10, 256, 30);
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testInvalidBlueUnderBounds()
  {
    new \Colourist\RGB(10, 20, -1);
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testInvalidBlueOverBounds()
  {
    new \Colourist\RGB(10, 20, 256);
  }
}
