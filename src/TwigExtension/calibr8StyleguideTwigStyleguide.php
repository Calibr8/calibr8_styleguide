<?php

namespace Drupal\calibr8_styleguide\TwigExtension;

use Drupal\Component\Utility\Html;

class calibr8StyleguideTwigStyleguide extends \Twig_Extension {

  /**
   * Generate a list of all Twig filters that this extension defines.
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('styleguide', [$this, 'styleguide']),
      new \Twig_SimpleFunction('styleguideHtml', [$this, 'styleguideHtml']),
    ];
  }

  /**
   * Get a unique identifier for this Twig extension.
   */
  public function getName() {
    return 'calibr8_styleguide.twig_extension';
  }

  /**
   * Custom Twig function to wrap the provided html in specific classes.
   * And print, depending on the given $code argument, different html output.
   */
  public static function styleguide($html, $code = NULL) {
    // if $code is not passed, it means it must be the same value as $html, make it so.
    if (!$code) {
      $code = $html;
    }
    $output = '<div class="col-md-6"><div class="sg-example">' . $html . '</div></div>';
    $output .= '<div class="col-md-6"><pre class="sg-code"><code class="language-markup">' . Html::escape($code) . '</code></pre></div>';
    echo (string) $output;
  }

  /**
   * @param $html string
   */
  public static function styleguideHtml($html) {
    $output = Html::escape(rtrim($html));
    echo (string) $output;
  }

}