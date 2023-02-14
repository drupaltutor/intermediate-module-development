<?php

namespace Drupal\zoopal_creature;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the creature entity type.
 */
class ZoopalCreatureAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {

    switch ($operation) {
      case 'view':
        /** @var ZoopalCreatureInterface $entity */
        if ($account->hasPermission('view unpublished creatures')) {
          return AccessResult::allowed();
        }
        return AccessResult::allowedIfHasPermission($account, 'view creature')
          ->andIf(AccessResult::allowedIf(!empty($entity->get('status')->value)));


      case 'update':
        return AccessResult::allowedIfHasPermissions(
          $account,
          ['edit creature', 'administer creature'],
          'OR',
        );

      case 'delete':
        return AccessResult::allowedIfHasPermissions(
          $account,
          ['delete creature', 'administer creature'],
          'OR',
        );

      default:
        // No opinion.
        return AccessResult::neutral();
    }

  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermissions(
      $account,
      ['create creature', 'administer creature'],
      'OR',
    );
  }

}
