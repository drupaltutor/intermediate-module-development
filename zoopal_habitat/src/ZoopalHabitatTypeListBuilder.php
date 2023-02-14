<?php

namespace Drupal\zoopal_habitat;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of habitat type entities.
 *
 * @see \Drupal\zoopal_habitat\Entity\ZoopalHabitatType
 */
class ZoopalHabitatTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['title'] = $this->t('Label');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['title'] = [
      'data' => $entity->label(),
      'class' => ['menu-label'],
    ];

    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No habitat types available. <a href=":link">Add habitat type</a>.',
      [':link' => Url::fromRoute('entity.zoopal_habitat_type.add_form')->toString()]
    );

    return $build;
  }

}
