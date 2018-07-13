<?php

namespace Drupal\Tests\xtcelastica\Functional\Serve\XtcRequest;

use Drupal\Core\Url;
use Drupal\Core\Entity\Entity;
use Drupal\Tests\BrowserTestBase;
use Drupal\Tests\Core\Entity\EntityTypeBundleInfoTest;
use Drupal\Tests\Core\Entity\EntityTypeTest;
use Drupal\Tests\UnitTestCase;


/**
 * Simple test to ensure that main page loads with module enabled.
 *
 * @group csoec_content
 */
class EntityElasticaTest extends EntityTypeBundleInfoTest {

  private $entity;
  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['csoec_content'];

  /**
   * A user with permission to administer site configuration.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $user;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $definition = [
      'id' => 'node',
    ];
    $this->entity = $this->get;
    dump($this->entity->getAllBundleInfo());
  }

  /**
   * Tests that the home page loads with a 200 response.
   */
  public function testEntity() {
    dump($this->entity);
    $toto = 5;
    $this->assertSame(5, $toto);
  }

}
