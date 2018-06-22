<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:21
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\XtcRequest;


use Drupal\xtc\XtendedContent\Serve\XtcRequest\AbstractXtcRequest;
use Drupal\xtcelastica\XtendedContent\Serve\Client\ElasticaClient;

class AbstractElasticaXtcRequest extends AbstractXtcRequest
{

  private $request;

  protected function buildClient(){
    dump("BUILD");
    $this->client = $this->getElasticaClient();
    $this->client->setXtcConfig($this->config);
    $this->client->setRequest($this->request);
    return $this;
  }

  public function setRequest($request){
    $this->request = $request;
    return $this;
  }

  protected function getElasticaClient(){
    return New ElasticaClient($this->profile);
  }

  /**
   * @return $this
   */
  protected function setWebservice()
  {
    $this->webservice = array_merge_recursive(
      $this->config['xtc']['serve_client']['server'][$this->profile],
      $this->config['xtc']['serve_client']['request'][$this->request],
      $this->config['xtc']['serve_xtcrequest'][$this->profile]
    );
    return $this;
  }
}
