# Node Duplicate

**Node Duplicate** is a simple Drupal 11 module that adds a "Duplicate" tab to content nodes, allowing users to quickly create a copy of any node.

## Features

- Adds a "Duplicate" local task/tab to all nodes.
- Copies all field values except system fields (`nid`, `vid`, `uid`, `created`, `changed`, `uuid`).
- Redirects to the edit form of the newly created node for further customization.

## Installation

1. Place the `node_duplicate` folder in your site's `web/modules/custom/` directory.
2. Enable the module:
   ```
   ddev drush en node_duplicate
   ```
3. Clear the cache:
   ```
   ddev drush cr
   ```

## Usage

- Visit any node's page.
- Click the "Duplicate" tab.
- You will be redirected to the edit form of the new node copy.

## Requirements

- Drupal 11.x
- Node module enabled

## Notes

- Only users with "create content" permission can duplicate nodes.
- The module copies all field values except system fields and generates a new UUID for the duplicate.
- For advanced duplication (media, paragraphs, references), further customization may be needed.

## License

This module is provided as-is under the