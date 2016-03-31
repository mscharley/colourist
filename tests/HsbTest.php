<?php

class HsbTest extends PHPUnit_Framework_TestCase
{
  public function testGetters()
  {
    $c = new \Colourist\HSB(250, 40, 60);
    $this->assertSame(250, $c->hue());
    $this->assertSame(40, $c->saturation());
    $this->assertSame(60, $c->brightness());
  }

  public function testHueWrapping()
  {
    $c = new \Colourist\HSB(390, 40, 60);
    $this->assertSame(30, $c->hue());
    $c = new \Colourist\HSB(-330, 40, 60);
    $this->assertSame(30, $c->hue());
  }

  public function testRotateHue()
  {
    $c = new \Colourist\HSL(50, 40, 20);
    $this->assertSame(70, $c->rotateHue(20)->hue());
  }

  /**
   * @expectedException \Colourist\Exception\SaturationUnsupportedException
   */
  public function testSaturateWithNoChroma()
  {
    (new \Colourist\HSB(0, 0, 50))->saturate(30);
  }

  /**
   * @expectedException \Colourist\Exception\SaturationUnsupportedException
   */
  public function testDesaturateWithNoChroma()
  {
    (new \Colourist\HSB(0, 0, 50))->desaturate(30);
  }

  public function testSaturate()
  {
    $c = (new \Colourist\HSB(250, 50, 50))->saturate(30);
    $this->assertSame(250, $c->hue());
    $this->assertSame(80, $c->saturation());
    $this->assertSame(50, $c->brightness());
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testSaturateOverBounds()
  {
    (new \Colourist\HSB(250, 50, 50))->saturate(60);
  }

  public function testDesaturate()
  {
    $c = (new \Colourist\HSB(250, 50, 50))->desaturate(30);
    $this->assertSame(250, $c->hue());
    $this->assertSame(20, $c->saturation());
    $this->assertSame(50, $c->brightness());
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testDesaturateUnderBounds()
  {
    (new \Colourist\HSB(250, 50, 50))->desaturate(60);
  }

  public function testBrighten()
  {
    $c = (new \Colourist\HSB(250, 50, 50))->brighten(30);
    $this->assertSame(250, $c->hue());
    $this->assertSame(50, $c->saturation());
    $this->assertSame(80, $c->brightness());
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testBrightenOverBounds()
  {
    (new \Colourist\HSB(250, 50, 50))->brighten(60);
  }

  public function testDim()
  {
    $c = (new \Colourist\HSB(250, 50, 50))->dim(30);
    $this->assertSame(250, $c->hue());
    $this->assertSame(50, $c->saturation());
    $this->assertSame(20, $c->brightness());
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testDimUnderBounds()
  {
    (new \Colourist\HSB(250, 50, 50))->dim(60);
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testSaturationOverBounds()
  {
    new \Colourist\HSB(250, 101, 60);
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testSaturationUnderBounds()
  {
    new \Colourist\HSB(250, -1, 60);
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testBrightnessOverBounds()
  {
    new \Colourist\HSB(250, 40, 101);
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testBrightnessUnderBounds()
  {
    new \Colourist\HSB(250, 40, -1);
  }
}
