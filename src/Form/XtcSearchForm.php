<?php

namespace Drupal\xtcelastica\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\xtc\Form\XtcSearchFormBase;

/**
 * Class AgendaForm.
 */
class XtcSearchForm extends XtcSearchFormBase
{
  protected function getSearchId() {
    return 'search';
  }

  /**
   * @return \Drupal\Core\GeneratedUrl|string
   */
  protected function resetLink(){
    return Url::fromRoute('xtcelastica.xtcsearch')->toString();
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $url = Url::fromRoute('xtcelastica.xtcsearch', ['s' => '*']);
    $form_state->setRedirectUrl($url);
  }

}
