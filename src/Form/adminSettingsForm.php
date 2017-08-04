<?php
/**
 * @file
 * Contains \Drupal\data_exchange\Form\adminSettingsForm.
 */
 
namespace Drupal\data_exchange\Form;


use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class adminSettingsForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'admin_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {   
    $dataX = \Drupal::state()->get('dataX'); 
    // Import settings
    $form['import_settings'] = array(
      '#type' => 'fieldset',
      '#title' => t('Import settings'),
      '#weight' => 50,
      '#collapsible' => true,
      '#collapsed' => true,
    );
    // Export settings
    $form['export_settings'] = array(
      '#type' => 'fieldset',
      '#title' => t('Export settings'),
      '#weight' => 50,
      '#collapsible' => true,
      '#collapsed' => true,
    );
    // Fields
    foreach ($dataX as $type => $data) {
      foreach ($data as $content_type => $fields) {
        $form[$type.'_settings'][$content_type] = array(
          '#type' => 'fieldset',
          '#title' => $content_type,
          '#weight' => 50,
          '#collapsible' => true,
          '#collapsed' => false,
        );
        foreach ($fields as $key => $field) {
          $form[$type.'_settings'][$content_type][$type.'_'.$content_type.'_'.$field['name']] = array(
            '#type' => 'checkbox',
            '#title' => $field['name'],
            '#default_value' => $field['status'],
            '#prefix' => "<div class='fields-settings-item'>".(($type == "export")?"<div class='fields-export-column'>":""),
          );
          if($type == "export"){
            $form[$type.'_settings'][$content_type][$type.'_'.$content_type.'_'.$field['name'].'_label'] = array(
              '#type' => 'textfield',
              '#size' => 20,
              '#default_value' => isset($field['label'])?$field['label']:$field['name'],
              '#attributes' => ['placeholder'=>'[numLabel]'],
              '#suffix' => '</div>'
            );
          }
          $form[$type.'_settings'][$content_type][$type.'_'.$content_type.'_'.$field['name'].'_column'] = array(
            '#type' => 'textfield',
            '#size' => 7,
            '#default_value' => isset($field['key'])?$field['key']:$key,
            '#attributes' => ['placeholder'=>'[numCol]'],
            '#suffix' => '</div>'
          );
        }
      }
    }
    // style
    $form['#attached']['library'][] = 'data_exchange/form-styling';
    // actions
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
  }
  
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Check duplicate column num
    $dataX = \Drupal::state()->get('dataX');
    foreach ($dataX as $type => $data) {
      foreach ($data as $content_type => $fields) {
        $numCol=[];
        foreach ($fields as $key => $field) {
          $numColField = $form_state->getValue($type.'_'.$content_type.'_'.$field['name'].'_column');
          if( in_array($numColField,$numCol) ){
            $form_state->setErrorByName($type.'_'.$content_type.'_'.$field['name'].'_column', t('Duplicate Column num ['.$type.'-'.$content_type.']. Please, reverify!'));
          }else{
            $numCol[] = $numColField;
          }
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $dataX = \Drupal::state()->get('dataX');
    foreach ($dataX as $type => $data) {
      foreach ($data as $content_type => $fields) {
        foreach ($fields as $key => $field) {
          $dataX[$type][$content_type][$key]['status'] = $form_state->getValue($type.'_'.$content_type.'_'.$field['name']);
          $dataX[$type][$content_type][$key]['label'] = $form_state->getValue($type.'_'.$content_type.'_'.$field['name'].'_label');
          $dataX[$type][$content_type][$key]['key'] = $form_state->getValue($type.'_'.$content_type.'_'.$field['name'].'_column');
        }
      }
    }
    // Set dataX
    \Drupal::state()->set('dataX', $dataX);
  }
}