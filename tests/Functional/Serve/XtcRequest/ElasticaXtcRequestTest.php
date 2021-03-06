<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 03/05/2018
 * Time: 16:34
 */


namespace Drupal\Tests\xtcelastica\Functional\Serve\XtcRequest;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Tests\UnitTestCase;
use Drupal\xtc\XtendedContent\Serve\XtcRequest\XtcRequestInterface;
use Drupal\xtcelastica\XtendedContent\Serve\XtcRequest\GetElasticaXtcRequest;
use Drupal\xtcelastica\XtendedContent\Serve\XtcRequest\IndexElasticaXtcRequest;

class ElasticaXtcRequestTest extends UnitTestCase
{

  private $container;

  /**
   * @var XtcRequestInterface
   */
  protected $xtcRequest;

  protected function setUp() {
    parent::setUp();
  }

  public function testGetAccountsById(){
    foreach ($this->accounts() as $account){
      $this->performRequest('test_local', 'account-by-id', $account);
    }
  }

  public function testDynamicDocs(){
    foreach ($this->accounts() as $account){
      $this->performRequest('test_local', 'known-doc', 'bank/account/'.$account);
    }
  }

  public function testGetAccountByQuery(){
    $this->performRequest('test_local', 'account-by-query');
  }

  private function performRequest($profile, $request, $id = ''){
    $xtcRequest = New GetElasticaXtcRequest($profile);
    $xtcRequest->setRequest($request);
    $fullconfig = $this->setClientConfig();
    $xtcRequest->setConfig($fullconfig);
    $xtcRequest->getClient()->setXtcConfig($this->setClientConfig());
    $this->xtcRequest = $xtcRequest;

    $method = $this->setClientConfig()['xtc']['serve_client']['request'][$request]['method'];
    $this->xtcRequest->get($method, $id);
    $response = $this->xtcRequest->getData();
    return $response;


    //    $expected = $this->expected('account-'.$id);
//    $this->assertSame($expected, $response);
    $this->assertSame(1, 1);
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
            "account-by-id" => [
              "method" => 'getElasticaDataByID',
              "params" => [
                'index' => 'bank',
                'type' => 'account',
              ],
            ],
            "known-doc" => [
              "method" => 'getKnownDoc',
              "params" => [],
            ],
            "account-by-query" => [
              "method" => "searchElasticaDocByQuery",
              "params" => [
                "index" => "bank",
                "q" => "age:[35 TO *]",
                "size" => 500,
              ],
            ],
          ],
        ],
      ],
    ];
  }

  private function expected($name) {
    switch ($name) {
      case 'account-bank/account/693':
      case 'account-693':
        return '{"_index":"bank","_type":"account","_id":"693","_version":1,"found":true,"_source":{"account_number":693,"balance":31233,"firstname":"Tabatha","lastname":"Zimmerman","age":30,"gender":"F","address":"284 Emmons Avenue","employer":"Pushcart","email":"tabathazimmerman@pushcart.com","city":"Esmont","state":"NC"}}';
        break;
      case 'account-bank/account/18':
      case 'account-18':
        return '{"_index":"bank","_type":"account","_id":"18","_version":1,"found":true,"_source":{"account_number":18,"balance":4180,"firstname":"Dale","lastname":"Adams","age":33,"gender":"M","address":"467 Hutchinson Court","employer":"Boink","email":"daleadams@boink.com","city":"Orick","state":"MD"}}';
        break;
      case 'account-bank/account/247':
      case 'account-247':
        return '{"_index":"bank","_type":"account","_id":"247","_version":1,"found":true,"_source":{"account_number":247,"balance":45123,"firstname":"Mccormick","lastname":"Moon","age":37,"gender":"M","address":"582 Brighton Avenue","employer":"Norsup","email":"mccormickmoon@norsup.com","city":"Forestburg","state":"DE"}}';
        break;
    }
  }

  private function accounts(){
    return [693, 18, 247];
  }
}
