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

class ElasticaXtcRequest extends AbstractXtcRequest
{

  private $request;

  protected function buildClient(){
    if(isset($this->profile)){
      $this->client = new ElasticaClient($this->profile);
    }
    $this->client->setXtcConfigFromYaml();
    $this->client->setClientRequest($this->request);
    return $this;
  }

  protected function buildClientFromConfig($config){
    if(isset($this->profile)){
      $this->client = new ElasticaClient($this->profile);
    }
    $this->client->setXtcConfig($config);
    $this->client->setRequest($this->request);
    return $this;
  }

  public function setRequest($request){
    $this->request = $request;
    return $this;
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
