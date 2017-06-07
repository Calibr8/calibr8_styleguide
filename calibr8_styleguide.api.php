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

  $items['table2'] = [
    '#title' => 'Table2',
    '#template' => 'table',
    '#weight' => 55
  ];

  $items['text2'] = [
    '#title' => 'Text styles 2',
    '#template' => 'text-styles',
    '#weight' => 10
  ];

  $items['titles2'] = [
    '#title' => 'Titles 2',
    '#template' => 'titles',
    '#weight' => 55
  ];

  return $items;
}