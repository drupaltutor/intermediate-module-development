<?php

namespace Drupal\zoopal_creature;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a creature entity type.
 */
interface ZoopalCreatureInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
