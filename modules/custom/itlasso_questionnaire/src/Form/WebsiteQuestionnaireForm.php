<?php

namespace Drupal\itlasso_questionnaire\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class WebsiteQuestionnaireForm extends FormBase {

  public function getFormId() {
    return 'website_questionnaire_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['contact'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Contact Information'),
    ];
    $form['contact']['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => TRUE,
    ];
    $form['contact']['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    ];
    $form['contact']['phone'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone Number'),
    ];
    $form['contact']['company'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Company Name'),
    ];
    $form['contact']['address'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Address'),
    ];
    $form['contact']['city_state_zip'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City, State, Zip Code'),
    ];

    $form['website'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Website Information'),
    ];
    $form['website']['existing_website'] = [
      '#type' => 'select',
      '#title' => $this->t('Do you have an existing website?'),
      '#options' => [
        '' => $this->t('- Select -'),
        'No' => $this->t('No'),
        'Yes' => $this->t('Yes'),
      ],
      '#required' => TRUE,
    ];
    $form['website']['existing_website_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('If yes, what is the URL?'),
      '#states' => [
        'visible' => [
          ':input[name="website[existing_website]"]' => ['value' => 'Yes'],
        ],
      ],
    ];
    $form['website']['current_domain'] = [
      '#type' => 'select',
      '#title' => $this->t('Do you have a current domain name?'),
      '#options' => [
        '' => $this->t('- Select -'),
        'No' => $this->t('No'),
        'Yes' => $this->t('Yes'),
      ],
      '#required' => TRUE,
    ];
    $form['website']['desired_domain'] = [
      '#type' => 'textfield',
      '#title' => $this->t('If a new domain is required, what is the name that you desire?'),
      '#description' => $this->t('e.g. https://www... (.com, .org, .net, etc.)'),
    ];

    $form['project'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Project Details'),
    ];
    $form['project']['project_description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Briefly describe your project and goals'),
      '#required' => TRUE,
    ];
    $form['project']['target_audience'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Who is your target audience?'),
    ];
    $form['project']['features'] = [
      '#type' => 'textarea',
      '#title' => $this->t('What features do you want on your website?'),
      '#description' => $this->t('e.g. Blog, Contact Form, E-commerce, Gallery, etc.'),
    ];
    $form['project']['competitors'] = [
      '#type' => 'textarea',
      '#title' => $this->t('List any competitor or inspiration websites'),
    ];
    $form['project']['timeline'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Desired timeline for launch'),
    ];
    $form['project']['budget'] = [
      '#type' => 'select',
      '#title' => $this->t('Estimated budget'),
      '#options' => [
        '' => $this->t('- Select -'),
        '$1000-$5000' => '$1000-$5000',
        '$5000-$10,000' => '$5000-$10,000',
        '$10,000-$20,000' => '$10,000-$20,000',
        'Over $20,000' => 'Over $20,000',
        'Undecided' => 'Undecided',
      ],
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit Questionnaire'),
      '#attributes' => ['class' => ['btn', 'btn-primary']],
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Example: Require URL if existing website is Yes
    if ($form_state->getValue(['website', 'existing_website']) === 'Yes' && empty($form_state->getValue(['website', 'existing_website_url']))) {
      $form_state->setErrorByName('website][existing_website_url', $this->t('Please provide the existing website URL.'));
    }
    // Example: Email must be valid (Drupal will also check this)
    if (!\Drupal::service('email.validator')->isValid($form_state->getValue(['contact', 'email']))) {
      $form_state->setErrorByName('contact][email', $this->t('Please enter a valid email address.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::messenger()->addStatus($this->t('Thank you for submitting your website questionnaire!'));
    // Here you could save to the database or send an email.
  }
}