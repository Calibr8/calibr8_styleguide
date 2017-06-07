<?php

namespace Drupal\calibr8_styleguide\Plugin\Calibr8Styleguide;

use Drupal\Core\Block\BlockManager;
use Drupal\Core\Breadcrumb\ChainBreadcrumbBuilderInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Menu\MenuLinkTreeInterface;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\Theme\ThemeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\calibr8_styleguide\Plugin\Calibr8StyleguidePluginBase;

/**
 * Default Styleguide items implementation.
 *
 * @Plugin(
 *   id = "calibr8_styleguide",
 *   label = @Translation("Default Calibr8 Styleguide elements")
 * )
 */
class DefaultCalibr8Styleguide extends Calibr8StyleguidePluginBase {

  /**
   * The request stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilder
   */
  protected $formBuilder;

  /**
   * The current_route_match service.
   *
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;

  /**
   * The block plugin manager.
   *
   * @var \Drupal\Core\Block\BlockManager
   */
  protected $blockManager;

  /**
   * The theme manager service.
   *
   * @var \Drupal\Core\Theme\ThemeManagerInterface
   */
  protected $themeManager;

  /**
   * The module handler service.
   *
   * @var ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Constructs a new defaultStyleguide.
   *
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   * @param \Drupal\Core\Menu\MenuLinkTreeInterface $link_tree
   * @param \Drupal\Core\Form\FormBuilder $form_builder
   * @param \Drupal\Core\Breadcrumb\ChainBreadcrumbBuilderInterface $breadcrumb_manager
   * @param \Drupal\Core\Routing\CurrentRouteMatch $current_route_match
   * @param BlockManager $block_manager
   * @param ThemeManagerInterface $theme_manager
   * @param ModuleHandlerInterface $module_handler
   *
   * @internal param \Drupal\Core\Breadcrumb\ChainBreadcrumbBuilderInterface $breadcrumb
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RequestStack $request_stack, MenuLinkTreeInterface $link_tree, FormBuilder $form_builder, ChainBreadcrumbBuilderInterface $breadcrumb_manager, CurrentRouteMatch $current_route_match, BlockManager $block_manager, ThemeManagerInterface $theme_manager, ModuleHandlerInterface $module_handler) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->requestStack = $request_stack;
    $this->linkTree = $link_tree;
    $this->formBuilder = $form_builder;
    $this->breadcrumbManager = $breadcrumb_manager;
    $this->currentRouteMatch = $current_route_match;
    $this->blockManager = $block_manager;
    $this->themeManager = $theme_manager;
    $this->moduleHandler = $module_handler;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($configuration, $plugin_id, $plugin_definition,
      $container->get('request_stack'),
      $container->get('menu.link_tree'),
      $container->get('form_builder'),
      $container->get('breadcrumb'),
      $container->get('current_route_match'),
      $container->get('plugin.manager.block'),
      $container->get('theme.manager'),
      $container->get('module_handler'));
  }

  /**
   * {@inheritdoc}
   */
  public function items() {
     return _styleguide_builder($this);
  }

}
