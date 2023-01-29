<?php

namespace Drupal\block_examples\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Contact Info' block.
 *
 * @Block(
 *   id = "block_examples_contact_info",
 *   admin_label = @Translation("Block Example: Contact Info"),
 *   category = @Translation("DrupalTutor Training")
 * )
 */
class ContactInfoBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['phone'] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $this->t('Phone Number: @phone', ['@phone' => '555-666-7777']),
    ];
    $build['email'] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $this->t('Email: @email', ['@email' => 'someone@example.com']),
    ];
    return $build;
  }

  public function defaultConfiguration() {
    return [
      'phone' => '',
      'email' => '',
    ];
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $form['phone'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone Number'),
      '#required' => TRUE,
      '#default_value' => $this->configuration['phone'],
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
      '#default_value' => $this->configuration['email'],
    ];
    return $form;
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['phone'] = $form_state->getValue('phone');
    $this->configuration['email'] = $form_state->getValue('email');
    parent::blockSubmit($form, $form_state);
  }

}
