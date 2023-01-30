<?php

namespace Drupal\entity_examples\Controller;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
          'entity_examples.node_publish',
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

  public function nodePublish(NodeInterface $node) {
    if ($node->get('status')->value === "0") {
      $node->set('status', 1)
        ->setRevisionLogMessage($this->t('Published from the queue'))
        ->save();
      $this->messenger()->addStatus($this->t('Published %node', ['%node' => $node->label()]));
    }
    return new RedirectResponse(
      Url::fromRoute('entity_examples.node_publish_queue')->toString()
    );
  }

}
