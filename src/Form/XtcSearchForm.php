<?php

namespace Drupal\xtcelastica\Form;

use Drupal\xtcsearch\Form\XtcSearchFormBase;

/**
 * Class XtcSearchForm
 *
 * @package Drupal\xtcelastica\Form
 */
class XtcSearchForm extends XtcSearchFormBase
{
  public function getSearchId() {
    return 'search';
  }

}
