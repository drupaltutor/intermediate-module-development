<?php

namespace Drupal\block_examples\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\CacheableMetadata;

/**
 * Provides a 'Hello User' block.
 *
 * @Block(
 *   id = "block_examples_hello_user",
 *   admin_label = @Translation("Block Example: Hello User"),
 *   category = @Translation("DrupalTutor Training")
 * )
 */
class HelloUserBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $cache = new CacheableMetadata();
    $cache->addCacheContexts(['user']);

    $account = \Drupal::currentUser();
    $entity_type_manager = \Drupal::entityTypeManager();
    $user_storage = $entity_type_manager->getStorage('user');
    /** @var \Drupal\user\UserInterface $user */
    $user = $user_storage->load($account->id());
    $cache->addCacheableDependency($user);

    $build = [
      '#plain_text' => $this->t('Hello @user!', ['@user' => $user->getDisplayName()]),
    ];

    $cache->applyTo($build);
    return $build;
  }

}
