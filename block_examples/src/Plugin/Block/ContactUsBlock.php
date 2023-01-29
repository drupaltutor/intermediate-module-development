<?php

namespace Drupal\block_examples\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\form_examples\Form\ContactForm;

/**
 * Provides a 'Contact Us' block.
 *
 * @Block(
 *   id = "block_examples_contact_us",
 *   admin_label = @Translation("Block Example: Contact Us"),
 *   category = @Translation("DrupalTutor Training")
 * )
 */
class ContactUsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return \Drupal::formBuilder()->getForm(ContactForm::class);
  }
}
