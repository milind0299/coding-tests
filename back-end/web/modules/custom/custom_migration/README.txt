Module Name: Custom Migration
-------------------------------

1. Have created two migrate api files named:
    i. migrate_json_company.yml
    ii. migrate_json_user.yml
Both the files have the field mappings from the JSON Endpoint to the drupal content type field machine name
The source, destination and the process plugins are added to these two files.

The commands that are required to perform the migration are
    i. ddev drush ms -> shows the list of migration ids and count of content.
    ii. ddev drush migrate-import migration_id -> migrated the content from the json endpoint to drupal content
    iii. ddev drush migrate-rollback migration_id -> rolls back all the migrated content.
    iv. ddev drush migrate-stop -> stops the Migration
    v. ddev drush migrate-reset-status -> Resets the migration status.
There are many other migration commands.

2. Create a Controller file and retured a template file named custom-module-user-company.html.twig which is defined in the hook_theme
3. Added a routing to the Controller so that the twig is visible
4. Got the user and company data using drupal sql queries and preprared the array structure to display in the twig file
5. Looped through the array in the twig file to show the result in the front end.