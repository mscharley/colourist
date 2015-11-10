<?php

use QCheck\Generator as Gen;
use QCheck\Quick;

class QuickcheckTest extends PHPUnit_Framework_TestCase {
  const RUN_COUNT = 5000;

  public function testRgbToHsb() {
    $r = Gen::choose(0, 255);
    $g = Gen::choose(0, 255);
    $b = Gen::choose(0, 255);
    $gen = Gen::forAll([$r, $g, $b], function($r, $g, $b) {
      (new \Colourist\RGB($r, $g, $b))->toHsb();
      return true;
    });

    $check = Quick::check(self::RUN_COUNT, $gen);
    if ($check['result']) {
      $this->assertTrue($check['result'], "This should never happen!");
    }
    else {
      $failed = new \Colourist\RGB(...$check['fail']);
      $this->assertTrue($check['result'], "Unable to generate HSB colour for " . $failed->toHex());
    }
  }

  public function testRgbToHsl() {
    $r = Gen::choose(0, 255);
    $g = Gen::choose(0, 255);
    $b = Gen::choose(0, 255);
    $gen = Gen::forAll([$r, $g, $b], function($r, $g, $b) {
      (new \Colourist\RGB($r, $g, $b))->toHsl();
      return true;
    });

    $check = Quick::check(self::RUN_COUNT, $gen);
    if ($check['result']) {
      $this->assertTrue($check['result'], "This should never happen!");
    }
    else {
      $failed = new \Colourist\RGB(...$check['fail']);
      $this->assertTrue($check['result'], "Unable to generate HSL colour for " . $failed->toHex());
    }
  }

  public function testHsbToRgb() {
    $h = Gen::choose(0, 255);
    $s = Gen::choose(0, 100);
    $b = Gen::choose(0, 100);
    $gen = Gen::forAll([$h, $s, $b], function($h, $s, $b) {
      (new \Colourist\HSB($h, $s, $b))->toRgb();
      return true;
    });

    $check = Quick::check(self::RUN_COUNT, $gen);
    if ($check['result']) {
      $this->assertTrue($check['result'], "This should never happen!");
    }
    else {
      $failed = new \Colourist\HSB(...$check['fail']);
      $this->assertTrue($check['result'], "Unable to generate RGB colour for hsb(" . $failed->hue() . ", " . $failed->saturation() . ", " . $failed->brightness() . ")");
    }
  }

  public function testHslToRgb() {
    $h = Gen::choose(0, 255);
    $s = Gen::choose(0, 100);
    $b = Gen::choose(0, 100);
    $gen = Gen::forAll([$h, $s, $b], function($h, $s, $b) {
      (new \Colourist\HSL($h, $s, $b))->toRgb();
      return true;
    });

    $check = Quick::check(self::RUN_COUNT, $gen);
    if ($check['result']) {
      $this->assertTrue($check['result'], "This should never happen!");
    }
    else {
      $failed = new \Colourist\HSL(...$check['fail']);
      $this->assertTrue($check['result'], "Unable to generate RGB colour for hsl(" . $failed->hue() . ", " . $failed->saturation() . ", " . $failed->lightness() . ")");
    }
  }
}
