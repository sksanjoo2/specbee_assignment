<?php

namespace Drupal\specbee_assignment\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "current_date",
 *   admin_label = @Translation("Time Zone Block"),
 * )
 */
class CurrentDate extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The date calculator.
   *
   * @var \Drupal\specbee_assignment\DateSevices
   */
  protected $date;

  /**
   * Constructs an EventCountdownBlock object.
   *
   * @param array $configuration
   *   The block configuration.
   * @param string $plugin_id
   *   The ID of the plugin.
   * @param mixed $plugin_definition
   *   The plugin definition.
   * @param \Drupal\specbee_assignment\DateSevices $date
   *   The date calculator.
   */
  
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    $date
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->date = $date;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('specbee_assignment.current_date')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $time = $this->date->currentDate();
    $city = \Drupal::config('specbee_assignment.settings')->get('city');
    $country = \Drupal::config('specbee_assignment.settings')->get('country');
    return [
      '#theme' => 'block__user_timezone',
      '#time' => $time,
      '#city' => $city,
      '#country' => $country,
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['current_block_settings'] = $form_state->getValue('current_block_settings');
  }

}
