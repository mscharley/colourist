<?php

namespace Colourist;

abstract class SaturatableColour extends Colour
{
  /** @var float */
  protected $saturation;

  /**
   * Saturate this colour by a certain amount.
   *
   * @param $amount
   *   A percentage to saturate this colour by.
   *
   * @return Colour
   *   This colour saturated by a given amount.
   *
   * @see SaturatableColour::desaturate()
   */
  public function saturate($amount)
  {
    // TODO: Implement saturate() method.
    return $this;
  }

  /**
   * Desaturate this colour by a certain amount.
   *
   * @param $amount
   *   A percentage to desaturate this colour by.
   *
   * @return Colour
   *   This colour desaturated by a given amount.
   *
   * @see SaturatableColour::saturate()
   */
  public function desaturate($amount)
  {
    // TODO: Implement desaturate() method.
    return $this;
  }

  /**
   * @return int
   */
  public function saturation()
  {
    return (int) round($this->saturation * 100);
  }
}
