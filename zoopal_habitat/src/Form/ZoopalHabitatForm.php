<?php

namespace Drupal\zoopal_habitat\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the habitat entity edit forms.
 */
class ZoopalHabitatForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $entity = $this->getEntity();

    $message_arguments = ['%label' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%label' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New habitat %label has been created.', $message_arguments));
        $this->logger('zoopal_habitat')->notice('Created new habitat %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The habitat %label has been updated.', $message_arguments));
        $this->logger('zoopal_habitat')->notice('Updated habitat %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.zoopal_habitat.canonical', ['zoopal_habitat' => $entity->id()]);

    return $result;
  }

}
