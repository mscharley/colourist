<?php

use Colourist\Tests\ColourTestCase;
use Colourist\Tests\HueCases;
use Colourist\Tests\SaturationCases;

class HslTest extends ColourTestCase
{
  use HueCases;
  use SaturationCases;

  protected function classToTest()
  {
    return "\\Colourist\\HSL";
  }

  protected function properties()
  {
    return ['hue', 'saturation', 'lightness'];
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
