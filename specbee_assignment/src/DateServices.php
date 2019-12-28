<?php

namespace Drupal\specbee_assignment;

/**
 * DateService give time as per user selection in date form.
 */
class DateServices {

  /**
   * The date variable.
   *
   * @var date
   */
  protected $date;

  /**
   * It will give current date as per selection of timezone.
   */
  public function currentDate() {
    $time = time();
    $timezone = \Drupal::config('specbee_assignment.settings')->get('timezone');
    $date = \Drupal::service('date.formatter')->format($time, '', 'dS M Y- h:i A', $timezone);
    return $date;
  }

}
