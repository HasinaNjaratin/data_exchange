<?php
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements of hook_form_FORM_ID_alter()
 */
function data_exchange_form_node_type_form_alter(&$form, FormStateInterface $form_state) {
  $form['data_exchange'] = array(
    '#type' => 'details',
    '#title' => t('Data exchange settings'),
    '#open' => TRUE,
    '#weight' => 10,
    '#group' => 'additional_settings',
  );
  $isImportableNode = !empty($form['type']['#default_value'])?\Drupal::state()->get($form['type']['#default_value'].'_importable'):0;
  $form['data_exchange']['importable'] = array(
    '#type' => 'checkbox',
    '#title' => t('Allow to import data'),
    '#default_value' => $isImportableNode
  );
  $isExportableNode = !empty($form['type']['#default_value'])?\Drupal::state()->get($form['type']['#default_value'].'_exportable'):0;
  $form['data_exchange']['exportable'] = array(
    '#type' => 'checkbox',
    '#title' => t('Allow to export data'),
    '#default_value' => $isExportableNode
  );
  $form['actions']['submit']['#submit'][] = 'data_exchange_node_type_submit';
}

/**
 * {@inheritdoc}
 * Settings content type :: data_exchange submission part
 */
function data_exchange_node_type_submit($form, FormStateInterface $form_state){
  $dataX = \Drupal::state()->get('dataX');
  $content_type = $form_state->getValue('type');
  $node_fields = get_fields_in($content_type);
  // Importability
  $isImportable = $form_state->getValue('importable');
  \Drupal::state()->set($content_type.'_importable', $isImportable);
  if($isImportable){
    if(!isset($dataX['import'][$content_type])){
      $dataX['import'][$content_type]=$node_fields;
    }
  }else{
    unset($dataX['import'][$content_type]);
  }
  // Exportability
  $isExportable = $form_state->getValue('exportable');
  \Drupal::state()->set($content_type.'_exportable', $isExportable);
  if($isExportable){
    if(!isset($dataX['export'][$content_type])){
      $dataX['export'][$content_type]=$node_fields;
    }
  }else{
    unset($dataX['export'][$content_type]);
  }
  // Set dataX
  \Drupal::state()->set('dataX', $dataX);
}
