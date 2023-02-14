<?php

namespace Drupal\zoopal_habitat\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Habitat type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "zoopal_habitat_type",
 *   label = @Translation("Habitat type"),
 *   label_collection = @Translation("Habitat types"),
 *   label_singular = @Translation("habitat type"),
 *   label_plural = @Translation("habitat types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count habitat type",
 *     plural = "@count habitats types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\zoopal_habitat\Form\ZoopalHabitatTypeForm",
 *       "edit" = "Drupal\zoopal_habitat\Form\ZoopalHabitatTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\zoopal_habitat\ZoopalHabitatTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   admin_permission = "administer habitat types",
 *   bundle_of = "zoopal_habitat",
 *   config_prefix = "zoopal_habitat_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/zoopal/config/habitat-types/add",
 *     "edit-form" = "/admin/zoopal/config/habitat-types/manage/{zoopal_habitat_type}",
 *     "delete-form" = "/admin/zoopal/config/habitat-types/manage/{zoopal_habitat_type}/delete",
 *     "collection" = "/admin/zoopal/config/habitat-types"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   }
 * )
 */
class ZoopalHabitatType extends ConfigEntityBundleBase {

  /**
   * The machine name of this habitat type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the habitat type.
   *
   * @var string
   */
  protected $label;

}
