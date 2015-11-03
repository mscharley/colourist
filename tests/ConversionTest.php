<?php

class ConversionTest extends PHPUnit_Framework_TestCase {
  public function testRgbToHsb() {
    $tests = [
      '#FFB638' => [38, 78, 100],
      '#52FF9B' => [145, 68, 100],
      '#8219CC' => [275, 88, 80],
      '#FFFFFF' => [0, 0, 100],
    ];

    foreach ($tests as $rgb => $values) {
      $c = \Colourist\Colour::fromHex($rgb)->toHsb();
      $this->assertSame($values[0], $c->hue());
      $this->assertSame($values[1], $c->saturation());
      $this->assertSame($values[2], $c->brightness());
    }
  }
}
