<?php

/*
* Simple Rental Product Type Class
*/

class WC_Product_Simple_Rental extends WC_Product_Variable {

  public function __construct( $product ) {

    parent::__construct( $product );

  }

  public function get_type() {
    return 'simple_rental';
  }

  public function get_4_hour_rate() {
    if ($this->get_meta('_4_hour_rate')) {
      $rate = $this->get_meta('_4_hour_rate');
    } else if ($this->get_meta('_daily_rate')) {
      $rate = $this->get_meta('_daily_rate');
    } else if ($this->get_meta('_weekly_rate')) {
      $rate = $this->get_meta('_weekly_rate');
    } else {
      return "Call";
    }

    return number_format($rate, 2);
  }

  public function get_daily_rate() {
    if ($this->get_meta('_daily_rate')) {
      $rate = $this->get_meta('_daily_rate');
    } else if ($this->get_meta('_weekly_rate')) {
      $rate = $this->get_meta('_weekly_rate');
    } else {
      return "Call";
    }

    return number_format($rate, 2);
  }

  public function get_weekly_rate() {
    if ($this->get_meta('_weekly_rate')) {
      $rate = $this->get_meta('_weekly_rate');
    } else {
      return "Call";
    }

    return number_format($rate, 2);
  }

  public function get_weekend_sat_rate() {
    $rate = $this->get_daily_rate();

    return number_format($rate, 2);
  }

  public function get_weekend_fri_rate() {
    $rate = $this->get_daily_rate() * 1.5;

    return number_format($rate, 2);
  }

}



 ?>
