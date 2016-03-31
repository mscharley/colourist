<?php

class HsbTest extends \Colourist\Tests\ColourTestCase
{
  protected function classToTest()
  {
    return "\\Colourist\\HSB";
  }

  public function testGetters()
  {
    $c = $this->newTestedClass(250, 40, 60);
    $this->assertSame(250, $c->hue());
    $this->assertSame(40, $c->saturation());
    $this->assertSame(60, $c->brightness());
  }

  public function testHueWrapping()
  {
    $c = $this->newTestedClass(390, 40, 60);
    $this->assertSame(30, $c->hue());
    $c = $this->newTestedClass(-330, 40, 60);
    $this->assertSame(30, $c->hue());
  }

  public function testRotateHue()
  {
    $c = $this->newTestedClass(50, 40, 20);
    $this->assertSame(70, $c->rotateHue(20)->hue());
  }

  /**
   * @expectedException \Colourist\Exception\SaturationUnsupportedException
   */
  public function testSaturateWithNoChroma()
  {
    $this->newTestedClass(0, 0, 50)->saturate(30);
  }

  /**
   * @expectedException \Colourist\Exception\SaturationUnsupportedException
   */
  public function testDesaturateWithNoChroma()
  {
    $this->newTestedClass(0, 0, 50)->desaturate(30);
  }

  public function testSaturate()
  {
    $c = $this->newTestedClass(250, 50, 50)->saturate(30);
    $this->assertSame(250, $c->hue());
    $this->assertSame(80, $c->saturation());
    $this->assertSame(50, $c->brightness());
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testSaturateOverBounds()
  {
    $this->newTestedClass(250, 50, 50)->saturate(60);
  }

  public function testDesaturate()
  {
    $c = $this->newTestedClass(250, 50, 50)->desaturate(30);
    $this->assertSame(250, $c->hue());
    $this->assertSame(20, $c->saturation());
    $this->assertSame(50, $c->brightness());
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testDesaturateUnderBounds()
  {
    $this->newTestedClass(250, 50, 50)->desaturate(60);
  }

  public function testBrighten()
  {
    $c = $this->newTestedClass(250, 50, 50)->brighten(30);
    $this->assertSame(250, $c->hue());
    $this->assertSame(50, $c->saturation());
    $this->assertSame(80, $c->brightness());
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testBrightenOverBounds()
  {
    $this->newTestedClass(250, 50, 50)->brighten(60);
  }

  public function testDim()
  {
    $c = $this->newTestedClass(250, 50, 50)->dim(30);
    $this->assertSame(250, $c->hue());
    $this->assertSame(50, $c->saturation());
    $this->assertSame(20, $c->brightness());
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testDimUnderBounds()
  {
    $this->newTestedClass(250, 50, 50)->dim(60);
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testSaturationOverBounds()
  {
    $this->newTestedClass(250, 101, 60);
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testSaturationUnderBounds()
  {
    $this->newTestedClass(250, -1, 60);
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testBrightnessOverBounds()
  {
    $this->newTestedClass(250, 40, 101);
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testBrightnessUnderBounds()
  {
    $this->newTestedClass(250, 40, -1);
  }
}
