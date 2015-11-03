<?php

namespace Colourist;

use Respect\Validation\Validator as v;

class HSB extends SaturatableColour
{
  /** @var float */
  protected $hue;
  /** @var float */
  protected $brightness;

  /**
   * Create a new RGB from the given red, green and blue channels.
   *
   * @param float $hue
   *   Hue is a value between 0 and 360 representing the hue of this colour. If
   *   a number outside this range is provided it will be wrapped to fit inside
   *   this range.
   * @param float $saturation
   *   Saturation of this colour.
   * @param float $brightness
   *   Brightness of this colour.
   * @param Colour $original
   *   A colour that this was transformed from.
   */
  public function __construct($hue, $saturation, $brightness, Colour $original = NULL)
  {
    v::numeric()->assert($hue);
    Colour::validatePercentage($saturation);
    Colour::validatePercentage($brightness);

    $this->hue = fmod($hue, 360);
    if ($this->hue < 0) {
      $this->hue += 360;
    }
    $this->saturation = $saturation / 100;
    $this->brightness = $brightness / 100;

    $this->chroma = $this->brightness * $this->saturation;

    $this->hsb = $this;
    if (isset($original)) {
      $this->rgb = $original->rgb;
      $this->hsl = $original->hsl;
    }
  }

  /**
   * @inheritDoc
   */
  public function brighten($amount)
  {
    // TODO: Implement brighten() method.
    return $this;
  }

  /**
   * @inheritDoc
   */
  public function dim($amount)
  {
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
   * @return RGB
   *   The RGB transformation of this colour.
   */
  public function toRgb()
  {
    $Hd = $this->hue / 60;
    $m = $this->brightness - $this->chroma;
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

    return new RGB(($red + $m) * RGB::MAX_RGB, ($green + $m) * RGB::MAX_RGB, ($blue + $m) * RGB::MAX_RGB);
  }

  /**
   * Convert this colour to an HSL colour.
   *
   * @return HSL
   *   The HSL transformation of this colour.
   */
  public function toHsl()
  {
    // TODO: Implement toHsl() method.
    throw new \InvalidArgumentException("Not implemented.");
  }

  /**
   * @return float
   */
  public function hue()
  {
    return (int) round($this->hue);
  }

  /**
   * @return float
   */
  public function brightness()
  {
    return (int) round($this->brightness * 100);
  }
}
