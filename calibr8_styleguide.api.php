<?php

/**
 * Register a style guide element for display.
 *
 * This hook only works in themes, not modules. Due to issues with the template
 * detection only working in themes.
 *
 * hook_calibr8_styleguide_items() defines an array of items to render for theme
 * testing. Each item is rendered as an element on the style guide page.
 *
 * @return $items
 *   An array of items to render.
 */
function hook_calibr8_styleguide_items() {
  return $items;
}