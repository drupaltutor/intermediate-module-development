<?php

namespace Drupal\zoopal_creature\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configuration form for a creature entity type.
 */
class ZoopalCreatureSettingsForm extends ConfigFormBase {

  protected function getEditableConfigNames() {
    return ['zoopal_creature.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'zoopal_creature_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['revision_default'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable revisions by default'),
      '#default_value' => $this->config('zoopal_creature.settings')->get('revision_default'),
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('zoopal_creature.settings')
      ->set('revision_default', $form_state->getValue('revision_default'))
      ->save();

    $this->messenger()->addStatus($this->t('The configuration has been updated.'));
  }

}
