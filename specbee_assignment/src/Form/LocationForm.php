<?php

namespace Drupal\specbee_assignment\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LocationForm.
 *
 * @package Drupal\specbee_assignment\Form
 */
class LocationForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'specbee_assignment.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'location_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('specbee_assignment.settings');
    $zone = [
      'America/Chicago' => 'America/Chicago',
      'America/NewYork' => 'America/NewYork',
      'Asia/Kolkata' => 'Asia/Kolkata',
      'Asia/Tokyo' => 'Asia/Tokyo',
      'Asia/Dubai' => 'Asia/Dubai',
      'Europe/Amsterdam' => 'Europe/Amsterdam',
      'Europe/Oslo' => 'Europe/Oslo',
      'Europe/London' => 'Europe/London',
    ];

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('country'),
      '#default_value' => $config->get('country'),
    ];

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('city'),
      '#default_value' => $config->get('city'),
    ];

    $form['timezone'] = [
      '#type' => 'select',
      '#title' => $this->t('timezone'),
      '#options' => $zone,
      '#default_value' => $config->get('zone'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $this->config('specbee_assignment.settings')
      ->set('city', $form_state->getValue('city'))
      ->set('country', $form_state->getValue('country'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();
  }

}
