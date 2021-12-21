<?php

namespace Drupal\json_data\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;

/**
 * Class ExtendedSiteInformationForm.
 */
class ExtendedSiteInformationForm extends SiteInformationForm {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'extended_site_information_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $site_config = $this->config('system.site');
    $form = parent::buildForm($form, $form_state);
    $form['site_information']['siteapikey'] = [
      '#type' => 'textfield',
      '#title' => t('Site API Key'),
      '#default_value' => $site_config->get('siteapikey') ?: 'No API Key Saved',
      '#description' => t("Custom field to set the API Key"),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save Configuration'),
    ];

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
    // Display result.
    $this->configFactory()
      ->getEditable('system.site')
      ->set('siteapikey', $form_state->getValue('siteapikey'))
      ->save();
  }

}
