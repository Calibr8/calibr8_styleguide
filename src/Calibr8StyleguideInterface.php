<?php

namespace Drupal\calibr8_styleguide;

/**
 * Styleguide plugin interface.
 */
interface Calibr8StyleguideInterface {

  /**
   * Calibr8 Styleguide elements implementation.
   *
   * @return array
   *   An array of Calibr8 Styleguide elements.
   */
  public function items();

}
