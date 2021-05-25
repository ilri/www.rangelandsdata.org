<?php

/**
 * @file
 * Contains \Drupal\pizzetta\Plugin\Field\FieldFormatter\PizzettaSettingsFormatter.
 */

namespace Drupal\pizzetta\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'pizzetta_settings_formatter' formatter.
 *
 * @FieldFormatter (
 *   id = "pizzetta_settings_formatter",
 *   label = @Translation("pizzetta_settings_formatter"),
 *   field_types = {
 *     "pizzetta_settings"
 *   }
 * )
 */
class PizzettaSettingsFormatter extends FormatterBase {
  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $output = [];
    // Iterate over every field item and build a renderable array
    // (I call them rarray for short) for each item.
    foreach ($items as $delta => $item) {
      $build = array(
        '#type' => 'container',
        'value' => array()
      );
      if(!empty($item)){
        foreach($item as $key => $value){
          $build['value'][$key] = [
            '#type' => 'container',
            '#title' => $value->getName(),
            '#attributes' => array(
              'class' => \Drupal\Component\Utility\Html::cleanCssIdentifier($value->getName()),
            ),
            '#plain_text' => $value->getValue(),
          ];
        }
      }
      $output[$delta] = $build;
    }
    return $output;
  }
}
