<?php

namespace Drupal\form_examples\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ContactForm extends FormBase {

  /**
   * @var MailManagerInterface
   */
  protected MailManagerInterface $mailManager;

  public function __construct(MailManagerInterface $mail_manager) {
    $this->mailManager = $mail_manager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.mail')
    );
  }

  public function getFormId() {
    return 'form_examples.contact_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email Address'),
      '#required' => TRUE,
    ];
    $form['department'] = [
      '#type' => 'select',
      '#title' => $this->t('Purpose of Your Message'),
      '#options' => [
        'billing' => $this->t('Billing Inquiry'),
        'tech_support' => $this->t('Technical Support'),
        'other' => $this->t('Other')
      ],
      '#required' => TRUE,
    ];
    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#rows' => 10,
      '#required' => TRUE,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    if (!str_ends_with($email, '.edu')) {
      $form_state->setError(
        $form['email'],
        $this->t('Only .edu addresses are allowed.')
      );
    }
    parent::validateForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus(
      $this->t('Thank you for contacting us. We will respond as soon as possible.')
    );
    dsm($form_state->getValues());
  }

}
