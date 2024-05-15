<?php

namespace App\Data;

class SearchData
{
  /**
   * @var integer
   */
  public $page = 1;

  /**
   * @var string
   */
  public $q = '';

  /**
   * @var Category[]
   */
  public $categories = [];

  /**
   * @var Color[]
   */
  public $color = [];

  /**
   * @var Country[]
   */
  public $country = [];

  /**
   * @var null|integer
   */
  public $min;

  /**
   * @var null|integer
   */
  public $max;
}
