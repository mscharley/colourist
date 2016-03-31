<?php

namespace Colourist\Tests;

trait HueCases
{
  abstract public function assertSame($expected, $actual, $message = '');
  abstract public function newTestedClass(...$args);

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
}
