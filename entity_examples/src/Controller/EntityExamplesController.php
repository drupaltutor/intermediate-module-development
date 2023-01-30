<?php

namespace Drupal\entity_examples\Controller;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;

/**
 * Returns responses for Entity Examples routes.
 */
class EntityExamplesController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function nodePublishQueue() {
    $cache = new CacheableMetadata();
    $build = [];

    $node_storage = $this->entityTypeManager()->getStorage('node');
    $results = $node_storage->getQuery()
      ->condition('status', 0)
      ->condition('type', ['article', 'page'], 'IN')
      ->condition('nid', 20, '>')
      ->exists('field_image')
      ->sort('created', 'ASC')
      ->range(0, 10)
      ->accessCheck(TRUE)
      ->execute();

    if (!empty($results)) {
      $node_view_builder = $this->entityTypeManager()->getViewBuilder('node');
      foreach ($results as $nid) {
        $node = $node_storage->load($nid);
        $cache->addCacheableDependency($node);
        $node_view = $node_view_builder->view($node, 'teaser');
        $build[$nid] = [
          '#type' => 'container',
        ];
        $build[$nid]['publish'] = Link::createFromRoute(
          $this->t('Publish Post'),
          'entity.node.canonical',
          ['node' => $node->id()],
          ['attributes' => ['class' => ['button']]],
        )->toRenderable();
        $build[$nid]['view'] = $node_view;
      }
    }

    $cache->addCacheTags(['node_list']);
    $cache->applyTo($build);


    return $build;
  }

}
