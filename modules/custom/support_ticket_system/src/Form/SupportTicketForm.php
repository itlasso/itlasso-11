<?php

namespace Drupal\support_ticket_system\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class SupportTicketForm extends FormBase {
  public function getFormId() {
    return 'support_ticket_form';
  }  

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => TRUE,
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    ];
    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#required' => TRUE,
    ];
    $form['priority'] = [
      '#type' => 'select',
      '#title' => $this->t('Priority'),
      '#options' => [
        'Low' => $this->t('Low'),
        'Medium' => $this->t('Medium'),
        'High' => $this->t('High'),
      ],
      '#required' => TRUE,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit Ticket'),
    ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValue('name');
    $email = $form_state->getValue('email');
    $description = $form_state->getValue('description');
    $priority = $form_state->getValue('priority');

    // Create Support Ticket node
    $node = Node::create([
      'type' => 'support_ticket_system', // Machine name of your content type
      'title' => $name . ' - ' . $priority,
      'field_name' => $name,
      'field_email' => $email,
      'field_description' => $description,
      'field_priority' => $priority,
      'status' => 1,
      'uid' => \Drupal::currentUser()->id(), // Set the author
    ]);
    $node->save();

    // Send notification to support@itlasso.com
    $mailManager = \Drupal::service('plugin.manager.mail');
    $module = 'support_ticket_system';
    $key = 'ticket_notification';
    $to = 'support@itlasso.com';
    $params['subject'] = 'New Support Ticket Submitted';
    $params['message'] = "Name: $name\nEmail: $email\nPriority: $priority\nDescription:\n$description";
    $langcode = \Drupal::currentUser()->getPreferredLangcode();
    $send = true;
    $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);

    // Send auto-response to user
    $params['subject'] = 'Your Support Ticket Submission';
    $params['message'] = "Thank you for contacting support. Your ticket has been received and someone will reach out to you soon.";
    $mailManager->mail($module, $key, $email, $langcode, $params, NULL, $send);

    \Drupal::messenger()->addStatus($this->t('Your support ticket has been submitted. We will contact you soon.'));
  }
}