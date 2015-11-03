<?php

class HslTest extends PHPUnit_Framework_TestCase
{
  public function testGetters()
  {
    $c = new \Colourist\HSL(250, 40, 60);
    $this->assertSame(250, $c->hue());
    $this->assertSame(40, $c->saturation());
    $this->assertSame(60, $c->lightness());
  }

  public function testHueWrapping()
  {
    $c = new \Colourist\HSL(390, 40, 60);
    $this->assertSame(30, $c->hue());
    $c = new \Colourist\HSL(-330, 40, 60);
    $this->assertSame(30, $c->hue());
  }

  public function testSaturate()
  {
    $c = (new \Colourist\HSL(250, 50, 50))->saturate(30);
    $this->assertSame(250, $c->hue());
    $this->assertSame(80, $c->saturation());
    $this->assertSame(50, $c->lightness());
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testSaturateOverBounds()
  {
    (new \Colourist\HSL(250, 50, 50))->saturate(60);
  }

  public function testDesaturate()
  {
    $c = (new \Colourist\HSL(250, 50, 50))->desaturate(30);
    $this->assertSame(250, $c->hue());
    $this->assertSame(20, $c->saturation());
    $this->assertSame(50, $c->lightness());
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testDesaturateUnderBounds()
  {
    (new \Colourist\HSL(250, 50, 50))->desaturate(60);
  }

  public function testLighten()
  {
    $c = (new \Colourist\HSL(250, 50, 50))->lighten(30);
    $this->assertSame(250, $c->hue());
    $this->assertSame(50, $c->saturation());
    $this->assertSame(80, $c->lightness());
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testLightenOverBounds()
  {
    (new \Colourist\HSL(250, 50, 50))->lighten(60);
  }

  public function testDarken()
  {
    $c = (new \Colourist\HSL(250, 50, 50))->darken(30);
    $this->assertSame(250, $c->hue());
    $this->assertSame(50, $c->saturation());
    $this->assertSame(20, $c->lightness());
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testDarkenUnderBounds()
  {
    (new \Colourist\HSL(250, 50, 50))->darken(60);
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testSaturationOverBounds()
  {
    new \Colourist\HSL(250, 101, 60);
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testSaturationUnderBounds()
  {
    new \Colourist\HSL(250, -1, 60);
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testLightnessOverBounds()
  {
    new \Colourist\HSL(250, 40, 101);
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testLightnessUnderBounds()
  {
    new \Colourist\HSL(250, 40, -1);
  }
}
