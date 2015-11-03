<?php

namespace Colourist;

class Hsl extends Colour
{
  /** @var float */
  protected $hue;
  /** @var float */
  protected $lightness;

  /**
   * @inheritDoc
   */
  public function lighten($amount)
  {
    // TODO: Implement this.
    return $this;
  }

  /**
   * @inheritDoc
   */
  public function darken($amount)
  {
    // TODO: Implement this.
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function toHsl()
  {
    return $this;
  }

  /**
   * Convert this colour to an RGB colour.
   *
   * @return Rgb
   *   The RGB transformation of this colour.
   */
  public function toRgb() {
    // TODO: Implement toRgb() method.
  }

  /**
   * Convert this colour to an RGB colour.
   *
   * @return Rgb
   *   The RGB transformation of this colour.
   */
  public function toHsb() {
    // TODO: Implement toHsb() method.
  }
}
