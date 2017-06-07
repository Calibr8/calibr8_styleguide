<?php

namespace Drupal\calibr8_styleguide\Plugin;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Plugin\PluginBase;
use Drupal\Core\Menu;
use Drupal\calibr8_styleguide\Calibr8StyleguideInterface;

/**
 * Base class for Calibr8 Styleguide plugins.
 */
abstract class Calibr8StyleguidePluginBase extends PluginBase implements Calibr8StyleguideInterface, ContainerFactoryPluginInterface {

  /**
   * Build list of all available icons in calibr8 theme
   *
   * @return array
   *    Array of icons
   */
  public function iconsListBuilder() {
    // Get active theme (should be a Calibr8 subtheme)
    $active_theme = \Drupal::theme()->getActiveTheme()->getName();
    // Get icons
    $icons = [];
    $icons_dir = drupal_get_path('theme', $active_theme) . '/icons';
    if (file_exists($icons_dir)) {
      $icons_files = scandir($icons_dir);
      foreach ($icons_files as $icon_file) {
        if (pathinfo($icon_file, PATHINFO_EXTENSION) == 'svg') {
          $name = pathinfo($icon_file, PATHINFO_FILENAME);
          $icons[] = [
            'name' => $name,
            'class' => 'icon-' . $name,
          ];
        }
      }
    }

    return $icons;
  }

  /**
   * @return array
   *    Drupal pager markup
   */
  public function pagerBuilder($size = 20, $total = 200) {
    pager_default_initialize($total, $size);
    return ['#type' => 'pager'];
  }

  /**
   * @return array
   *    List of messages
   */
  public function messagesBuilder() {
    $message_queue = drupal_get_messages();

    $messages = [
      '#theme' => 'status_messages',
      '#message_list' => [
        'status' => [
          'message' => 'Lorem ipsum.',
        ],
        'warning' => [
          'message' => 'Lorem ipsum.',
        ],
        'error' => [
          'message' => 'Lorem ipsum.',
        ],
      ],
      '#status_headings' => [
        'status' => t('Status message'),
        'error' => t('Error message'),
        'warning' => t('Warning message'),
      ],
    ];

    // Loop through the original messages, resetting them.
    foreach ($message_queue as $message_type => $messages) {
      foreach ($messages as $message) {
        drupal_set_message($message, $message_type);
      }
    }

    return $messages;
  }

  /**
   * Path to image folder in styleguide module.
   *
   * @return array
   *    String of path
   */
  public function imagePath() {
    global $base_url;
    return $base_url . '/' . drupal_get_path('module', 'calibr8_styleguide') . '/images';
  }

  /**
   * @return array
   *    List of messages
   */
  public function formBuilder() {
    $config = \Drupal::config('calibr8_styleguide.settings');
    $webform_exists = \Drupal::moduleHandler()->moduleExists('webform');
    $webform_system_name = $config->get('webform_system_name');
    // If webform must be displayed, get that form and pass to render array
    if ((boolean) $config->get('webform_display') && $webform_exists) {
      $webform = \Drupal::entityTypeManager()->getStorage('webform')->load($webform_system_name);
      if($webform) {
        $form = $webform->getSubmissionForm();
      } else {
        drupal_set_message('Webform "' . $webform_system_name . '"" does not exist. Showing default Styleguide form.');
      }
    }
    // Otherwise display the default styleguide form.
    if(!isset($form)) {
      // Build the example form.
      $form = \Drupal::formBuilder()
        ->getForm('Drupal\calibr8_styleguide\Form\Calibr8StyleguideForm');
    }
    return $form;
  }

}
