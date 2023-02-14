<?php

namespace Drupal\zoopal_habitat;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a habitat entity type.
 */
interface ZoopalHabitatInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
