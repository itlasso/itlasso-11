<?php

namespace Drupal\itlasso_questionnaire\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Website Development Questionnaire' Block.
 *
 * @Block(
 *   id = "website_questionnaire_block",
 *   admin_label = @Translation("Website Development Questionnaire"),
 * )
 */
class WebsiteQuestionnaireBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'website_questionnaire',
      'form' => \Drupal::formBuilder()->getForm('Drupal\itlasso_questionnaire\Form\WebsiteQuestionnaireForm'),
    ];
  }
}