<?php

namespace Drupal\calibr8_styleguide;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * The Calibr8 Styleguide plugins manager.
 */
class Calibr8StyleguidePluginManager extends DefaultPluginManager {

  /**
   * {@inheritdoc}
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    $subdir = 'Plugin/Calibr8Styleguide';
    $plugin_interface = 'Drupal\calibr8_styleguide\Calibr8StyleguideInterface';
    $plugin_definition_annotation_name = 'Drupal\Component\Annotation\Plugin';

    parent::__construct($subdir, $namespaces, $module_handler, $plugin_interface, $plugin_definition_annotation_name);
    $this->alterInfo('calibr8_styleguide_info');
    $this->setCacheBackend($cache_backend, 'calibr8_styleguide_info');
  }

}
