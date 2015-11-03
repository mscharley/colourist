<?php

namespace Colourist;

use Respect\Validation\Validator as v;

class Hsl extends SaturatableColour
{
  /** @var float */
  protected $hue;
  /** @var float */
  protected $lightness;

  /**
   * Create a new RGB from the given red, green and blue channels.
   *
   * @param float $hue
   *   Hue is a value between 0 and 360 representing the hue of this colour. If
   *   a number outside this range is provided it will be wrapped to fit inside
   *   this range.
   * @param float $saturation
   *   Saturation of this colour.
   * @param float $lightness
   *   Lightness of this colour.
   * @param Colour $original
   *   A colour that this was transformed from.
   */
  public function __construct($hue, $saturation, $lightness, Colour $original = NULL)
  {
    v::numeric()->assert($hue);
    Colour::validatePercentage($saturation);
    Colour::validatePercentage($lightness);

    $this->hue = fmod($hue, 360);
    if ($this->hue < 0) {
      $this->hue += 360;
    }
    $this->saturation = $saturation / 100;
    $this->lightness = $lightness / 100;

    $this->hsl = $this;
    if (isset($original)) {
      $this->rgb = $original->rgb;
      $this->hsb = $original->hsb;
    }
  }

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
  public function toRgb()
  {
    // TODO: Implement toRgb() method.
  }

  /**
   * Convert this colour to an RGB colour.
   *
   * @return Rgb
   *   The RGB transformation of this colour.
   */
  public function toHsb()
  {
    // TODO: Implement toHsb() method.
  }

  /**
   * @return int
   */
  public function hue()
  {
    return (int) round($this->hue);
  }

  /**
   * @return int
   */
  public function lightness()
  {
    return (int) round($this->lightness * 100);
  }
}
