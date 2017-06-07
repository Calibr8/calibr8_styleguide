<?php

namespace Drupal\calibr8_styleguide\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Contribute form.
 */
class Calibr8StyleguideForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'calibr8_styleguide_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['textfield'] = [
      '#type' => 'textfield',
      '#title' => 'Standard textfield',
      '#description' => 'Description text',
    ];
    $form['textfield_compact'] = [
      '#type' => 'textfield',
      '#title' => 'Compact textfield',
      '#title_display' => 'compact',
      '#description' => 'Description text',
    ];
    $form['textfield_compact'] = [
      '#type' => 'textfield',
      '#title' => 'Inline textfield',
      '#title_display' => 'inline',
      '#description' => 'Description text',
    ];
    $form['textfield_clearable'] = [
      '#type' => 'textfield',
      '#title' => 'Clearable textfield',
      '#clearable' => true,
      '#description' => 'Type anything to see it in action',
    ];
    $form['password'] = [
      '#type' => 'password',
      '#title' => 'Password',
      '#description' => 'Description text',
    ];
    $form['fieldset'] = [
      '#type' => 'fieldset',
      '#title' => 'Fieldset',
      '#collapsible' => true,
      '#collapsed' => false,
    ];
    $form['fieldset']['date'] = [
      '#type' => 'date',
      '#title' => 'Date field',
      '#description' => 'Description text',
    ];
    $form['fieldset']['managed_file'] = [
      '#type' => 'managed_file',
      '#title' => 'Managed File',
      '#description' => 'Description text',
    ];
    $form['checkbox'] = [
      '#type' => 'checkbox',
      '#title' => 'Single checkbox',
      '#description' => 'Description text',
    ];
    $form['checkboxes'] = [
      '#type' => 'checkboxes',
      '#title' => 'Multiple checkboxes',
      '#options' =>
        [
          0 => 'Apple',
          1 => 'Banana',
          2 => 'Strawberry',
        ],
      '#description' => 'Description text',
    ];
    $form['radiobuttons'] = [
      '#type' => 'radios',
      '#title' => 'Radio buttons',
      '#options' =>
        [
          0 => 'Apple',
          1 => 'Banana',
          2 => 'Strawberry',
        ],
      '#description' => 'Description text',
    ];
    $form['select'] = [
      '#type' => 'select',
      '#title' => 'Select',
      '#options' =>
        [
          0 => 'Apple',
          1 => 'Banana',
          2 => 'Strawberry',
        ],
      '#description' => 'Description text',
    ];
    $form['textarea'] = [
      '#type' => 'textarea',
      '#title' => 'Textarea',
    ];
    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => 'Save',
      ],
      'delete' => [
        '#type' => 'button',
        '#value' => 'Delete',
      ],
      'cancel' => [
        '#markup' => 'Cancel',
      ],
    ];

    return $form;

  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

}
