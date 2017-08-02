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
    $form['importable_settings'] = array(
      '#type' => 'fieldset',
      '#title' => t('Import settings'),
      '#weight' => 50,
      '#collapsible' => true,
      '#collapsed' => true,
    );
    foreach ($dataX['importable'] as $content_type => $fields) {
      $form['importable_settings'][$content_type] = array(
        '#type' => 'fieldset',
        '#title' => $content_type,
        '#weight' => 50,
        '#collapsible' => true,
        '#collapsed' => false,
      );
      foreach ($fields as $key => $field_name) {
        $form['importable_settings'][$content_type][$content_type.'_'.$field_name['name']] = array(
          '#type' => 'checkbox',
          '#title' => $field_name['name'],
          '#default_value' => $field_name['status'],
          '#prefix' => "<div class='fields-settings-item'>"
        );
        $form['importable_settings'][$content_type][$content_type.'_'.$field_name['name'].'_column'] = array(
          '#type' => 'textfield',
          '#size' => 11,
          '#default_value' => isset($field_name['key'])?$field_name['key']:$key,
          '#suffix' => '</div>'
        );
        $form['importable_settings'][$content_type][$content_type.'_'.$field_name['name'].'_column']['#attributes']['placeholder'] = '[num column]';
      }
    }
    // Export settings
    $form['exportable_settings'] = array(
      '#type' => 'fieldset',
      '#title' => t('Export settings'),
      '#weight' => 50,
      '#collapsible' => true,
      '#collapsed' => true,
    );
    foreach ($dataX['exportable'] as $content_type => $fields) {
      $form['exportable_settings'][$content_type] = array(
        '#type' => 'fieldset',
        '#title' => $content_type,
        '#weight' => 50,
        '#collapsible' => true,
        '#collapsed' => false,
      );
      foreach ($fields as $field_name) {
        $form['exportable_settings'][$content_type][$content_type.'_'.$field_name] = array(
          '#type' => 'checkbox',
          '#title' => $field_name,
          '#attributes' => array('class' => array('item-row-weight')),
        );
      }
    }
    // style
    $form['#attached']['library'][] = 'data-exchange/data-exchange.css';
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
    
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
  }


}