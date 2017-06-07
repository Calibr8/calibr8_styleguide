<?php

namespace Drupal\calibr8_styleguide\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'calibr8_styleguide_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'calibr8_styleguide.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('calibr8_styleguide.settings');
    // Check if webform & webform_node modules are enabled
    $webform_exists = \Drupal::moduleHandler()->moduleExists('webform');

    if ($webform_exists) {
      $form['webform_display'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Use webform'),
        '#description' => $this->t('Use webform as form example in styleguide.'),
        '#default_value' => $config->get('webform_display'),
      ];

      $form['webform_system_name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Webform system name'),
        '#description' => $this->t('Insert system name of the webform you wish to use.'),
        '#default_value' => $config->get('webform_system_name'),
      ];
      $form['webform_exists'] = [
        '#type' => 'hidden',
        '#value' => $webform_exists
      ];
    }
    // Print info text if modules are not enabled.
    else {
      $form['webform_display'] = [
        '#type' => 'inline_template',
        '#template' => "<p>The <strong>webform</strong> module is not enabled, so these settings can not be filled in. Enable the module and try again.</p>",
      ];
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // webform must be enabled to save the form.
    if ($form_state->getValue('webform_exists')) {
      // Set error if checkbox is set to true, but no nodeID is filled in.
      if ($form_state->getValue('webform_display') == 1 && empty($form_state->getValue('webform_system_name'))) {
        $form_state->setErrorByName('webform_display', $this->t('Invalid: You must provide a webform if you check "Use webform".'));
      }
      else if ($webform_system_name = $form_state->getValue('webform_system_name')) {
        // Check if system name is a valid one.
        $webform = \Drupal::entityTypeManager()->getStorage('webform')->load($webform_system_name);
        if(!$webform) {
          $form_state->setErrorByName('webform_system_name', $this->t('Webform system name: This is not valid webform.'));
        }
      }
    }
    else {
      $form_state->setErrorByName('webform_display', $this->t('Invalid: The webform module must be enabled to save this option.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::service('config.factory')->getEditable('calibr8_styleguide.settings');
    $config->set('webform_display', $form_state->getValue('webform_display'))
           ->set('webform_system_name', $form_state->getValue('webform_system_name'))
           ->save();

    parent::submitForm($form, $form_state);
  }

}