<?php

namespace Colourist;

abstract class Colour {


  abstract public function toRgb();
  abstract public function toHsl();
  abstract public function toHsv();
  public function toHsb() {
    return $this->toHsv();
  }
}
