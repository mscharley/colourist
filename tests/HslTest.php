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
