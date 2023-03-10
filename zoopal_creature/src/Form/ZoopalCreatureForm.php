<?php

namespace Drupal\zoopal_creature\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the creature entity edit forms.
 */
class ZoopalCreatureForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    $form['authoring_information'] = [
      '#type' => 'details',
      '#title' => $this->t('Authoring information'),
      '#open' => FALSE,
      '#group' => 'advanced',
      '#weight' => 10,
    ];
    $form['uid']['#group'] = 'authoring_information';
    $form['created']['#group'] = 'authoring_information';

    $config = \Drupal::config('zoopal_creature.settings');
    $form['revision']['#default_value'] = $config->get('revision_default');

    return $form;
  }

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
        $this->messenger()->addStatus($this->t('New creature %label has been created.', $message_arguments));
        $this->logger('zoopal_creature')->notice('Created new creature %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The creature %label has been updated.', $message_arguments));
        $this->logger('zoopal_creature')->notice('Updated creature %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.zoopal_creature.canonical', ['zoopal_creature' => $entity->id()]);

    return $result;
  }

}
