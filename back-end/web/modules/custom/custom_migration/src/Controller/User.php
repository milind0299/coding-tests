<?php

namespace Drupal\custom_migration\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;
use Drupal\node\Entity\Node;

class User extends ControllerBase
{

    protected $database;

    public function __construct(Connection $database)
    {
        $this->database = $database;
    }

    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('database')
        );
    }

    public function getUserAndCompany()
    {

        $users = $this->database->select('node_field_data', 'nfd');
        $users->fields('nfd', ['title']);
        $users->join('node__field_id', 'nfid', 'nfd.nid = nfid.entity_id');
        $users->fields('nfid', ['field_id_value']);
        $users->condition('nfd.type', 'user', '=');
        $results = $users->execute()->fetchAll();
        $data = [];
        foreach ($results as $result) {
            $field_id = $this->database->select('node__field_id', 'nfid');
            $field_id->fields('nfid', ['entity_id']);
            $field_id->condition('nfid.bundle', 'company', '=');
            $field_id->condition('nfid.field_id_value', $result->field_id_value, '=');
            $nid = $field_id->execute()->fetchAssoc();
            $node = Node::load($nid['entity_id']);
            if ($node) {
                $company_name = $node->getTitle();
                $data[$result->title] = $company_name;
            }
        }

        // Return the data to a twig template
        return [
            '#theme' => 'custom_module_user_company',
            '#data' => $data,
        ];
    }
}
