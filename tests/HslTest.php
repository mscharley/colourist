<?php

class HslTest extends \Colourist\Tests\ColourTestCase
{
  protected function classToTest()
  {
    return "\\Colourist\\HSL";
  }

  public function testGetters()
  {
    $c = $this->newTestedClass(250, 40, 60);
    $this->assertSame(250, $c->hue());
    $this->assertSame(40, $c->saturation());
    $this->assertSame(60, $c->lightness());
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
    $this->assertSame(50, $c->lightness());
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
    $this->assertSame(50, $c->lightness());
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testDesaturateUnderBounds()
  {
    $this->newTestedClass(250, 50, 50)->desaturate(60);
  }

  public function testLighten()
  {
    $c = $this->newTestedClass(250, 50, 50)->lighten(30);
    $this->assertSame(250, $c->hue());
    $this->assertSame(50, $c->saturation());
    $this->assertSame(80, $c->lightness());
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testLightenOverBounds()
  {
    $this->newTestedClass(250, 50, 50)->lighten(60);
  }

  public function testDarken()
  {
    $c = $this->newTestedClass(250, 50, 50)->darken(30);
    $this->assertSame(250, $c->hue());
    $this->assertSame(50, $c->saturation());
    $this->assertSame(20, $c->lightness());
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testDarkenUnderBounds()
  {
    $this->newTestedClass(250, 50, 50)->darken(60);
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
  public function testLightnessOverBounds()
  {
    $this->newTestedClass(250, 40, 101);
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testLightnessUnderBounds()
  {
    $this->newTestedClass(250, 40, -1);
  }
}
