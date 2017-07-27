<?php
/**
 * @file
 * Contains \Drupal\data_exchange\Controller\DataExchangeMenu.
 */
 
namespace Drupal\data_exchange\Controller;
 
use Drupal\Core\Controller\ControllerBase;
use Drupal\data_exchange\Form;
class DataExchangeMenu extends ControllerBase {
  public function adminPage() {
    $form = \Drupal::formBuilder()->getForm('\Drupal\data_exchange\Form\adminSettingsForm');
    return $form;
  }
}