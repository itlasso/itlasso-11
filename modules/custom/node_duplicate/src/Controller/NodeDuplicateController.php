<?php

namespace Drupal\node_duplicate\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\RedirectResponse;

class NodeDuplicateController extends ControllerBase {

  public function duplicate(Node $node) {
    // Create a new node with the same type and field values.
    $new_node = Node::create([
      'type' => $node->bundle(),
      'title' => $node->getTitle() . ' (Copy)',
    ]);

    // Copy all field values except system fields, including 'uuid'.
    foreach ($node->getFieldDefinitions() as $field_name => $field_definition) {
      if (
        $node->hasField($field_name) &&
        !in_array($field_name, ['nid', 'vid', 'uid', 'created', 'changed', 'uuid'])
      ) {
        $new_node->set($field_name, $node->get($field_name)->getValue());
      }
    }

    $new_node->save();

    $this->messenger()->addStatus($this->t('Node duplicated.'));

    // Redirect to the edit page of the new node.
    return new RedirectResponse($new_node->toUrl('edit-form')->toString());
  }
}