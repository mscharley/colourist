<?php

namespace Colourist;

class Hsb extends Colour
{
  /** @var float */
  protected $hue;
  /** @var float */
  protected $brightness;

  /**
   * @inheritDoc
   */
  public function brighten($amount) {
    // TODO: Implement brighten() method.
    return $this;
  }

  /**
   * @inheritDoc
   */
  public function dim($amount) {
    // TODO: Implement dim() method.
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function toHsb()
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
   * Convert this colour to an HSL colour.
   *
   * @return Hsl
   *   The HSL transformation of this colour.
   */
  public function toHsl() {
    // TODO: Implement toHsl() method.
  }
}
