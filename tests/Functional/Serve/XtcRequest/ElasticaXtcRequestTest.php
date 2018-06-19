<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 03/05/2018
 * Time: 16:34
 */


namespace Drupal\Tests\csoec_user\Functional\Serve\XtcRequest;

use Drupal\Tests\UnitTestCase;
use Drupal\xtc\XtendedContent\Serve\XtcRequest\XtcRequestInterface;
use Drupal\xtcelastica\XtendedContent\Serve\XtcRequest\ElasticaXtcRequest;
use Elastica\Request;

class ElasticaXtcRequestTest extends UnitTestCase
{
  /**
   * @var XtcRequestInterface
   */
  protected $xtcRequest;

  protected function setUp() {
    parent::setUp();
  }

  public function testPerformAllRequest(){
    foreach ($this->accounts() as $account){
      $this->performRequest('test_local', 'account-'.$account);
    }
  }

  private function performRequest($profile, $request){
    $xtcRequest = New ElasticaXtcRequest($profile);
    $xtcRequest->setRequest($request);
    $fullconfig = array_merge_recursive($this->setXtcConfig(),$this->setClientConfig());
    $xtcRequest->setConfig($fullconfig);
    $xtcRequest->getClient()->setXtcConfig($this->setClientConfig());
    $this->xtcRequest = $xtcRequest;

    $method = $this->setClientConfig()['xtc']['serve_client']['request'][$request]['method'];
    $this->xtcRequest->get($method);
    $response = $this->xtcRequest->getData();
    $expected = $this->expected($request);
    $this->assertSame($expected, $response);
  }

  private function setXtcConfig(){
    return [
      "xtc" => [
        "serve_xtcrequest" => [
          "test_local" => [
            "allowed" => [
              0 => 'getElasticaData',
              1 => 'getElasticaVersion',
            ],
          ],
        ],
      ],
    ];
  }

  private function setClientConfig(){
    return [
      "xtc" => [
        "serve_client" => [
          "server" => [
            "test_local" => [
              "type" => "elastica",
              "env" => "local-dev",
              "connection" => [
                "local-dev" => [
                  "host" => 'localhost',
                  "port" => '9200',
                ],
              ],
            ],
          ],
          "request" => [
            "test_version" => [
              "method" => 'getElasticaVersion',
              "verb" => 'GET',
            ],
            "account-693" => [
              "method" => 'getElasticaData',
              "params" => [
                'index' => 'bank',
                'type' => 'account',
                'id' => 693,
              ],
            ],
            "account-18" => [
              "method" => 'getElasticaData',
              "params" => [
                'index' => 'bank',
                'type' => 'account',
                'id' => 18,
              ],
            ],
            "account-247" => [
              "method" => 'getElasticaData',
              "params" => [
                'index' => 'bank',
                'type' => 'account',
                'id' => 247,
              ],
            ],

          ],
        ],
      ],
    ];
  }

  private function expected($name) {
    switch ($name) {
      case 'account-693':
        return '{"_index":"bank","_type":"account","_id":"693","_version":1,"found":true,"_source":{"account_number":693,"balance":31233,"firstname":"Tabatha","lastname":"Zimmerman","age":30,"gender":"F","address":"284 Emmons Avenue","employer":"Pushcart","email":"tabathazimmerman@pushcart.com","city":"Esmont","state":"NC"}}';
        break;
      case 'account-18':
        return '{"_index":"bank","_type":"account","_id":"18","_version":1,"found":true,"_source":{"account_number":18,"balance":4180,"firstname":"Dale","lastname":"Adams","age":33,"gender":"M","address":"467 Hutchinson Court","employer":"Boink","email":"daleadams@boink.com","city":"Orick","state":"MD"}}';
        break;
      case 'account-247':
        return '{"_index":"bank","_type":"account","_id":"247","_version":1,"found":true,"_source":{"account_number":247,"balance":45123,"firstname":"Mccormick","lastname":"Moon","age":37,"gender":"M","address":"582 Brighton Avenue","employer":"Norsup","email":"mccormickmoon@norsup.com","city":"Forestburg","state":"DE"}}';
        break;
    }
  }

  private function accounts(){
    return [693, 18, 247];
  }
}
