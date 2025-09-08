<?php

namespace Drupal\support_ticket_system\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a Support Ticket block.
 *
 * @Block(
 *   id = "support_ticket_block",
 *   admin_label = @Translation("Support Ticket Block")
 * )
 */
class SupportTicketBlock extends BlockBase {
  public function build() {
    return \Drupal::formBuilder()->getForm('Drupal\support_ticket_system\Form\SupportTicketForm');
  }
}