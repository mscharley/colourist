<?php

class ConversionTest extends PHPUnit_Framework_TestCase
{
  public function testReversibility()
  {
    $c = new \Colourist\RGB(10, 20, 30);
    $this->assertSame($c, $c->toHsb()->toRgb());
    $this->assertSame($c, $c->toHsl()->toRgb());

    $c = new \Colourist\HSL(200, 50, 50);
    $this->assertSame($c, $c->toRgb()->toHsl());
    // $this->assertSame($c, $c->toHsb()->toHsl());

    $c = new \Colourist\HSB(200, 50, 50);
    $this->assertSame($c, $c->toRgb()->toHsb());
    // $this->assertSame($c, $c->toHsv()->toHsl());
  }

  public function testRgbToHsb()
  {
    $tests = [
      '#FFB638' => [38, 78, 100],
      '#52FF9B' => [145, 68, 100],
      '#8219CC' => [275, 88, 80],
      '#FFFFFF' => [0, 0, 100],
      '#AAAAAA' => [0, 0, 67],
      '#000000' => [0, 0, 0],
    ];

    foreach ($tests as $rgb => $values) {
      $c = \Colourist\Colour::fromHex($rgb)->toHsb();
      $this->assertSame($values[0], $c->hue());
      $this->assertSame($values[1], $c->saturation());
      $this->assertSame($values[2], $c->brightness());
    }
  }

  public function testRgbToHsl()
  {
    $tests = [
      '#FEF888' => [57, 98, 76],
      '#19CB97' => [162, 78, 45],
      '#362698' => [248, 60, 37],
      '#FFFFFF' => [0, 0, 100],
      '#000000' => [0, 0, 0],
    ];

    foreach ($tests as $rgb => $values) {
      $c = \Colourist\Colour::fromHex($rgb)->toHsl();
      $this->assertSame($values[0], $c->hue());
      $this->assertSame($values[1], $c->saturation());
      $this->assertSame($values[2], $c->lightness());
    }
  }

  public function testHsbToRgb()
  {
    $tests = [
      '#FFB638' => [38, 78, 100],
      '#52FF9A' => [145, 68, 100],
      '#8118CC' => [275, 88, 80],
      '#FFFFFF' => [0, 0, 100],
      '#000000' => [0, 0, 0],
    ];

    foreach ($tests as $rgb => $values) {
      $c = (new \Colourist\Hsb($values[0], $values[1], $values[2]))->toRgb();
      $this->assertSame($rgb, $c->toHex());
    }
  }

  public function testHslToRgb()
  {
    $tests = [
      '#FEF886' => [57, 98, 76],
      '#19CC97' => [162, 78, 45],
      '#352697' => [248, 60, 37],
      '#FFFFFF' => [0, 0, 100],
      '#000000' => [0, 0, 0],
    ];

    foreach ($tests as $rgb => $values) {
      $c = (new \Colourist\Hsl($values[0], $values[1], $values[2]))->toRgb();
      $this->assertSame($rgb, $c->toHex());
    }
  }
}
