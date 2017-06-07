<?php

namespace Drupal\calibr8_styleguide\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Theme\ThemeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Core\Template\TwigEnvironment;
use Drupal\calibr8_styleguide\Calibr8StyleguidePluginManager;

/**
 * Provides route responses for the Example module.
 */
class Calibr8StyleguideController extends ControllerBase {

  /**
   * @var Drupal\Core\Template\TwigEnvironment
   */
  protected $twig;

  /**
   * The theme handler service.
   *
   * @var ThemeHandlerInterface
   */
  protected $themeHandler;

  /**
   * The styleguide generator service.
   *
   * @var \Drupal\styleguide\Generator
   */
  protected $generator;

  /**
   * The theme manager service.
   *
   * @var \Drupal\Core\Theme\ThemeManagerInterface
   */
  protected $themeManager;

  /**
   * The request stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * The block plugin manager.
   *
   * @var \Drupal\styleguide\StyleguidePluginManager
   */
  protected $styleguideManager;

  /**
   * Constructs a new StyleguideController.
   *
   * @param ThemeHandlerInterface $theme_handler
   *   The theme handler.
   * @param \Drupal\calibr8_styleguide\Calibr8StyleguidePluginManager $styleguide_manager
   * @param \Drupal\Core\Theme\ThemeManagerInterface $theme_manager
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   * @param \Drupal\Core\Template\TwigEnvironment $twig
   */
  public function __construct(ThemeHandlerInterface $theme_handler, Calibr8StyleguidePluginManager $styleguide_manager, ThemeManagerInterface $theme_manager, RequestStack $request_stack, TwigEnvironment $twig) {
    $this->themeHandler = $theme_handler;
    $this->styleguideManager = $styleguide_manager;
    $this->themeManager = $theme_manager;
    $this->requestStack = $request_stack;
    $this->twig = $twig;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('theme_handler'),
      $container->get('plugin.manager.calibr8_styleguide'),
      $container->get('theme.manager'),
      $container->get('request_stack'),
      $container->get('twig')
    );
  }

  /**
   * Builds the Style guide items.
   *
   * @return array
   *   render array for styleguide page.
   */
  public function styleguidePage() {

    $items = $render_items = $menu = [];
    $extension = '.html.twig';

    // Provide the theme with the ability to override twig tpl's.
    $theme_path = \Drupal::theme()->getActiveTheme()->getPath();
    $theme_name = \Drupal::theme()->getActiveTheme()->getName();
    $sg_path = $theme_path . '/styleguide/';
    $overrides = [];
    if(file_exists($sg_path)) {
      $overrides = array_diff(scandir($sg_path), array('..', '.'));
    }

    // get items via plugin manager from default styleguide items.
    foreach ($this->styleguideManager->getDefinitions() as $plugin_id => $plugin_definition) {
      $plugin = $this->styleguideManager->createInstance($plugin_id, array('of' => 'configuration values'));
      $items = array_merge($items, $plugin->items());
    }

    // Get items from hook implementations, normal module hooks AND hook in default theme.
    \Drupal::moduleHandler()->invokeAll('calibr8_styleguide_items', array(&$items));
    \Drupal::moduleHandler()->invoke($theme_name, 'calibr8_styleguide_items', array(&$items));

    // Loop over items and build the correct render array, render the tpl's etc...
    foreach ($items as $display => $item) {
      $context = [];
      if (isset($item['context']) && is_array($item['context'])) {
        $context = $item['context'];
      }

      // Get twig templates from elements folder
      $twigFilePath = drupal_get_path('module', 'calibr8_styleguide') . '/elements/' . $item['#template'] . $extension;

      // Override tpl that are in theme
      if ($overrides && is_array($overrides)) {
        foreach ($overrides as $file) {
          $name = current(explode(".", $file));
          if ($name == $item['#template']) {
            $twigFilePath = $sg_path . $name . $extension;
          }
        }
      }

      // Render twig templates
      $template = $this->twig->loadTemplate($twigFilePath);
      $markup = $template->render($context);

      // Build items array
      $render_items[] = [
        '#theme' => 'calibr8_styleguide_item',
        '#content' => $markup,
        '#id' => $item['#template'],
        '#title' => $item['#title'],
        '#weight' => $item['#weight'],
      ];

      // Build menu array
      $menu[] = [
        'menu_title' => $item['#title'],
        'menu_link' => $item['#template'],
        '#weight' => $item['#weight'],
      ];

    }

    // Sort by weight
    uasort($render_items, '\Drupal\Component\Utility\SortArray::sortByWeightProperty');
    uasort($menu, '\Drupal\Component\Utility\SortArray::sortByWeightProperty');

    // Page render array
    $page = [
      'main' => [
        '#theme' => 'calibr8_styleguide_main',
        '#content' => $render_items,
        '#menu_items' => $menu,
        '#attached' => [
          'library' => [
            'calibr8_styleguide/calibr8_styleguide',
            'calibr8_styleguide/prism'
          ],
        ],
        $cache = [
          'keys' => ['entity_view', 'theme'],
          'contexts' => ['languages', 'theme'],
          'tags' => ['library_info'],
          'max-age' => 36000,
        ],
      ],
    ];

    return $page;

  }

}