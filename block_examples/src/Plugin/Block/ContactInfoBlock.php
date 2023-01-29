<?php

namespace Drupal\block_examples\Plugin\Block;

use Drupal\Core\Block\BlockBase;

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
}
