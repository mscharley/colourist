<?php

namespace Colourist;

use Colourist\Exception\SaturationUnsupportedException;
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

    $this->hue = self::bcfmod($hue, 360, self::$bcscale);
    if ($this->hue < 0) {
      $this->hue = bcadd($this->hue, 360, self::$bcscale);
    }
    $this->saturation = bcdiv($saturation, 100, self::$bcscale);
    $this->brightness = bcdiv($brightness, 100, self::$bcscale);

    $this->chroma = bcmul($this->brightness, $this->saturation, self::$bcscale);

    $this->hsb = $this;
    if (isset($original)) {
      $this->rgb = $original->rgb;
      $this->hsl = $original->hsl;
    }
  }

  /**
   * @inheritdoc
   */
  public function rotateHue($amount)
  {
    return new HSB($this->hue() + $amount, $this->saturation(), $this->brightness());
  }

  /**
   * @inheritDoc
   */
  public function brighten($amount)
  {
    $this->validatePercentage($amount);
    return new HSB($this->hue(), $this->saturation(), $this->brightness() + $amount);
  }

  /**
   * @inheritDoc
   */
  public function dim($amount)
  {
    $this->validatePercentage($amount);
    return new HSB($this->hue(), $this->saturation(), $this->brightness() - $amount);
  }

  /**
   * {@inheritdoc}
   */
  public function saturate($amount)
  {
    $this->validatePercentage($amount);
    if ($this->chroma == 0) {
      throw new SaturationUnsupportedException('Saturation is unsupported for greyscales.');
    }

    return new HSB($this->hue(), $this->saturation() + $amount, $this->brightness());
  }

  /**
   * {@inheritdoc}
   */
  public function desaturate($amount)
  {
    $this->validatePercentage($amount);
    if ($this->chroma == 0) {
      throw new SaturationUnsupportedException('Saturation is unsupported for greyscales.');
    }

    return new HSB($this->hue(), $this->saturation() - $amount, $this->brightness());
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
    if (!isset($this->rgb)) {
      $Hd = bcdiv($this->hue, 60, self::$bcscale);
      $m = bcsub($this->brightness, $this->chroma, self::$bcscale);
      $X = bcmul(
          $this->chroma,
          bcsub(1, abs(bcsub(self::bcfmod($Hd, 2, self::$bcscale), 1, self::$bcscale)), self::$bcscale),
          self::$bcscale
      );

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
          bcmul(bcadd($red, $m, self::$bcscale), RGB::MAX_RGB, self::$bcscale),
          bcmul(bcadd($green, $m, self::$bcscale), RGB::MAX_RGB, self::$bcscale),
          bcmul(bcadd($blue, $m, self::$bcscale), RGB::MAX_RGB, self::$bcscale),
          $this
      );
    }

    return $this->rgb;
  }

  /**
   * {@inheritdoc}
   */
  public function toHsl()
  {
    if (!isset($this->hsl)) {
      if ($this->saturation == 0 || $this->saturation == 1 || $this->brightness == 0 || $this->brightness == 1) {
        // Division by 0 issues if we use the below formula.
        $this->hsl = $this->toRgb()->toHsl();
      } else {
        $lightness = bcmul(
            bcmul(0.5, $this->brightness, self::$bcscale),
            bcsub(2, $this->saturation, self::$bcscale),
            self::$bcscale
        );

        $saturation = bcdiv(
            bcmul($this->brightness, $this->saturation, self::$bcscale),
            bcsub(1, abs(bcsub(bcmul(2, $lightness, self::$bcscale), 1, self::$bcscale)), self::$bcscale),
            self::$bcscale
        );

        $this->hsl = new HSL(
            $this->hue(),
            bcmul($saturation, 100, self::$bcscale),
            bcmul($lightness, 100, self::$bcscale),
            $this
        );
      }
    }

    return $this->hsl;
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
    return (int) round(bcmul($this->brightness, 100, self::$bcscale));
  }

  /**
   * @inheritdoc
   */
  public function inspect()
  {
    return "HSB(" . $this->hue() . ", " . $this->saturation() . ", " . $this->brightness() . ")";
  }
}
