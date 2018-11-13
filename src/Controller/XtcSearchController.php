<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 20/08/2018
 * Time: 16:37
 */

namespace Drupal\xtcelastica\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\csoec_search\Form\CsoecXtcSearchForm;

class XtcSearchController extends ControllerBase
{

  /**
   * @param $id
   *
   * @return array
   */
  public function search() {
    $form = \Drupal::formBuilder()
      ->getForm(CsoecXtcSearchForm::class);

    return [
      '#theme' => 'csoec_agenda',
      '#response' => ['headline' => $this->getTitle()],
      '#form_events' => $form,
    ];
  }

  public function getTitle() {
    return 'Recherche';
  }

  protected function getType() {
    return 'document';
  }

}
