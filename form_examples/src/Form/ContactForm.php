<?php

namespace Drupal\form_examples\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ContactForm extends FormBase {

  public function getFormId() {
    return 'form_examples.contact_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus(
      $this->t('Thank you for contacting us. We will respond as soon as possible.')
    );
  }

}
