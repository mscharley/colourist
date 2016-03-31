<?php

use Colourist\Tests\ColourTestCase;
use Colourist\Tests\HueCases;
use Colourist\Tests\SaturationCases;

class HsbTest extends ColourTestCase
{
  use HueCases;
  use SaturationCases;

  protected function classToTest()
  {
    return "\\Colourist\\HSB";
  }

  protected function properties()
  {
    return ['hue', 'saturation', 'brightness'];
  }

  public function testGetters()
  {
    $c = $this->newTestedClass(250, 40, 60);
    $this->assertSame(250, $c->hue());
    $this->assertSame(40, $c->saturation());
    $this->assertSame(60, $c->brightness());
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
