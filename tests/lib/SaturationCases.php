<?php

namespace Colourist\Tests;

trait SaturationCases
{
  /**
   * @expectedException \Colourist\Exception\SaturationUnsupportedException
   */
  public function testSaturateWithNoChroma()
  {
    /** @var \Colourist\SaturatableColour $c */
    $c = $this->newTestedClass(0, 0, 50);
    $c->saturate(30);
  }

  /**
   * @expectedException \Colourist\Exception\SaturationUnsupportedException
   */
  public function testDesaturateWithNoChroma()
  {
    /** @var \Colourist\SaturatableColour $c */
    $c = $this->newTestedClass(0, 0, 50);
    $c->desaturate(30);
  }

  public function testSaturate()
  {
    /** @var \Colourist\SaturatableColour $c */
    $c = $this->newTestedClass(250, 50, 50);
    $c2 = $c->saturate(30);
    $this->assertPropertiesSame($c, $c2, ['saturation']);
    $this->assertSame(80, $c2->saturation());
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testSaturateOverBounds()
  {
    /** @var \Colourist\SaturatableColour $c */
    $c = $this->newTestedClass(250, 50, 50);
    $c->saturate(60);
  }

  public function testDesaturate()
  {
    /** @var \Colourist\SaturatableColour $c */
    $c = $this->newTestedClass(250, 50, 50);
    $c2 = $c->desaturate(30);
    $this->assertPropertiesSame($c, $c2, ['saturation']);
    $this->assertSame(20, $c2->saturation());
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testDesaturateUnderBounds()
  {
    /** @var \Colourist\SaturatableColour $c */
    $c = $this->newTestedClass(250, 50, 50);
    $c->desaturate(60);
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
}
