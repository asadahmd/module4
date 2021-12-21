<?php

namespace Drupal\json_data\Controller;

use Drupal\node\Entity\Node;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ExtendedSiteController.
 */
class ExtendedSiteController extends ControllerBase {

  /**
   * Hello.
   *check the value through endpoint and return node data in json format to the node
   */
  public function getVAlue($api_key, $content_type, $node_id) {
    $config = \Drupal::config('system.site');
    $key = $config->get('siteapikey');
    $contents = \Drupal::entityQuery('node')->condition('type', $content_type)->execute();
    $node_exist = Node::load($node_id);
    $node_type = $node_exist->getType();
    $json_array = [
      'data' => [],
    ];
    $json_array['data'][] = [
      'type' => $node_exist->get('type')->target_id,
      'id' => $node_exist->get('nid')->value,
      'attributes' => [
        'title' => $node_exist->get('title')->value,
        'content' => $node_exist->get('body')->value,
      ],
    ];
    if ($key !== $api_key || empty($contents) || empty($node_exist) || $node_type !== $content_type) {
      return [
        '#type' => 'markup',
        '#markup' => $this->t('Access Denied'),
      ];
    }
    else {
      return new JsonResponse($json_array);

    }
  }

}
