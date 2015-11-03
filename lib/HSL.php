<?php

namespace Colourist;

use Respect\Validation\Validator as v;

class HSL extends SaturatableColour
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

    $this->chroma = $this->saturation * (1 - abs(2 * $this->lightness - 1));

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
    $this->validatePercentage($amount);
    return new HSL($this->hue(), $this->saturation(), $this->lightness() + $amount);
  }

  /**
   * @inheritDoc
   */
  public function darken($amount)
  {
    $this->validatePercentage($amount);
    return new HSL($this->hue(), $this->saturation(), $this->lightness() - $amount);
  }

  /**
   * {@inheritdoc}
   */
  public function saturate($amount)
  {
    $this->validatePercentage($amount);
    return new HSL($this->hue(), $this->saturation() + $amount, $this->lightness());
  }

  /**
   * {@inheritdoc}
   */
  public function desaturate($amount)
  {
    $this->validatePercentage($amount);
    return new HSL($this->hue(), $this->saturation() - $amount, $this->lightness());
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
   * @return RGB
   *   The RGB transformation of this colour.
   */
  public function toRgb()
  {
    if (!isset($this->rgb)) {
      $Hd = $this->hue / 60;
      $m = $this->lightness - $this->chroma / 2;
      $X = $this->chroma * (1 - abs(fmod($Hd, 2) - 1));

      if ($Hd < 1) {
        list($red, $green, $blue) = [$this->chroma, $X, 0];
      } elseif ($Hd < 2) {
        list($red, $green, $blue) = [$X, $this->chroma, 0];
      } elseif ($Hd < 3) {
        list($red, $green, $blue) = [0, $this->chroma, $X];
      } elseif ($Hd < 4) {
        list($red, $green, $blue) = [0, $X, $this->chroma];
      } elseif ($Hd < 5) {
        list($red, $green, $blue) = [$X, 0, $this->chroma];
      } else {
        list($red, $green, $blue) = [$this->chroma, 0, $X];
      }

      $this->rgb = new RGB(
          ($red + $m) * RGB::MAX_RGB,
          ($green + $m) * RGB::MAX_RGB,
          ($blue + $m) * RGB::MAX_RGB,
          $this
      );
    }

    return $this->rgb;
  }

  /**
   * Convert this colour to an RGB colour.
   *
   * @return RGB
   *   The RGB transformation of this colour.
   */
  public function toHsb()
  {
    if (!isset($this->hsb)) {
      $this->hsb = $this->toRgb()->toHsb();
    }

    return $this->hsb;
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
