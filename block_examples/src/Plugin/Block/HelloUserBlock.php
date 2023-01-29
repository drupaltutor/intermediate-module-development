<?php

namespace Drupal\block_examples\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Hello User' block.
 *
 * @Block(
 *   id = "block_examples_hello_user",
 *   admin_label = @Translation("Block Example: Hello User"),
 *   category = @Translation("DrupalTutor Training")
 * )
 */
class HelloUserBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var AccountInterface
   */
  protected AccountInterface $currentUser;

  /**
   * @var EntityTypeManagerInterface
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * @var RouteMatchInterface
   */
  protected RouteMatchInterface $routeMatch;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $current_user, EntityTypeManagerInterface $entity_type_manager, RouteMatchInterface $route_match) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $current_user;
    $this->entityTypeManager = $entity_type_manager;
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('entity_type.manager'),
      $container->get('current_route_match')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $cache = new CacheableMetadata();
    $cache->addCacheContexts(['user']);

    $user_storage = $this->entityTypeManager->getStorage('user');
    /** @var \Drupal\user\UserInterface $user */
    $user = $user_storage->load($this->currentUser->id());
    $cache->addCacheableDependency($user);

    $build = [
      '#plain_text' => $this->t('Hello @user!', ['@user' => $user->getDisplayName()]),
    ];

    $cache->applyTo($build);
    return $build;
  }

  /**
   * @inheritDoc
   */
  protected function blockAccess(AccountInterface $account) {
    if ($account->isAnonymous()) {
      return AccessResult::forbidden();
    }
    if ($this->routeMatch->getRouteName() !== 'entity.user.canonical') {
      return AccessResult::forbidden();
    }
    /** @var UserInterface $user */
    $user = $this->routeMatch->getParameter('user');
    if ($user === NULL || $user->id() !== $account->id()) {
      return AccessResult::forbidden();
    }
    return parent::blockAccess($account);
  }

}
