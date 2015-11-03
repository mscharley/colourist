<?php

class HsbTest extends PHPUnit_Framework_TestCase {
  public function testGetters() {
    $c = new \Colourist\Hsb(250, 40, 60);
    $this->assertSame(250, $c->hue());
    $this->assertSame(40, $c->saturation());
    $this->assertSame(60, $c->brightness());
  }

  public function testHueWrapping() {
    $c = new \Colourist\Hsb(390, 40, 60);
    $this->assertSame(30, $c->hue());
    $c = new \Colourist\Hsb(-330, 40, 60);
    $this->assertSame(30, $c->hue());
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testSaturationOverBounds() {
    new \Colourist\Hsb(250, 101, 60);
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testSaturationUnderBounds() {
    new \Colourist\Hsb(250, -1, 60);
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testBrightnessOverBounds() {
    new \Colourist\Hsb(250, 40, 101);
  }

  /**
   * @expectedException Respect\Validation\Exceptions\AllOfException
   */
  public function testBrightnessUnderBounds() {
    new \Colourist\Hsb(250, 40, -1);
  }
}
