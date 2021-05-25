<?php

/**
 * @file
 * Contains \Drupal\pizzetta\Plugin\Field\FieldWidget\PizzettaSettingsWidget.
 */

namespace Drupal\pizzetta\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'dice' widget.
 *
 * @FieldWidget (
 *   id = "pizzetta_settings_widget",
 *   label = @Translation("Pizzetta Settings widget"),
 *   field_types = {
 *     "pizzetta_settings"
 *   }
 * )
 */
class PizzettaSettingsWidget extends WidgetBase {
  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
        'open' => false,
      ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $item = &$items[$delta];

    $options_title_level = [
      'h2' => 'h2',
      'h3' => 'h3',
      'h4' => 'h4',
      'h5' => 'h5',
      'h6' => 'h6',
    ];

    $percentage_options = [
      '10' => '10%',
      '20' => '20%',
      '30' => '30%',
      '40' => '40%',
      '50' => '50%',
      '60' => '60%',
      '70' => '70%',
      '80' => '80%',
      '90' => '90%',
      '100' => '100%',
    ];

    $distance_directions = pizzetta_get_distance_directions();
    $distance_options = [
      //'none' => '0', // used for reset / override purposes
      'half' => 'half',
      'single' => 'single',
      'double' => 'double',
      'triple' => 'triple',
    ];
    //todo: provide alter for distance_options

    $options_block_position = [];
    $block_position = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('block_position', 0, NULL, FALSE);
    foreach ($block_position as $bp) {
      $options_block_position[$bp->tid] = $bp->name;
    }

    $options_background_color = [];
    $background_color = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('colors', 0, NULL, FALSE);
    foreach ($background_color as $bc) {
      $options_background_color[$bc->tid] = $bc->name;
    }

    $block_styles = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('block_styles', 0, NULL, FALSE);
    foreach ($block_styles as $bs) {
      $options_block_styles[$bs->tid] = $bs->name;
    }

    $element['pizzetta_settings'] = array(
      '#type' => 'horizontal_tabs',
      '#theme_wrappers' => array('horizontal_tabs'),
      '#title' => $this->t('Style settings'),
      '#tree' => true,
    );

    /**
     * Title settings
     */
    $element['pizzetta_settings']['title_settings'] = array(
      '#type' => 'details',
      '#title' => $this->t('Title'),
      '#group' => 'pizzetta_settings',
      '#group_name' => 'pizzetta_settings',
      '#description' => '<i class="fa fa-info-circle" aria-hidden="true"></i>',
    );

    $element['pizzetta_settings']['title_settings']['title'] = array(
      '#type' => 'textfield',
      '#title' => t('Title'),
      '#default_value' => isset($item->title) ? $item->title : '',
      '#prefix' => '<div style="display:none" class="hidden d-none">',
      '#suffix' => '</div>',
    );
    $element['pizzetta_settings']['title_settings']['hide_title'] = array(
      '#type' => 'checkbox',
      '#title' => t('Hide title'),
      '#default_value' => isset($item->hide_title) ? $item->hide_title : 0,
    );
    $element['pizzetta_settings']['title_settings']['title_level'] = array(
      '#type' => 'select',
      '#title' => t('Title level'),
      '#default_value' => isset($item->title_level) ? $item->title_level : 'h2',
      '#options' => $options_title_level,
    );
    $element['pizzetta_settings']['title_settings']['show_title_in_side_menu'] = array(
      '#type' => 'checkbox',
      '#title' => t('Show title in the side menu'),
      '#default_value' => isset($item->show_title_in_side_menu) ? $item->show_title_in_side_menu : 0,
    );

    $block_position_default = 4470; //todo: variabilizzare via settings;
    $element['pizzetta_settings']['title_settings']['block_position'] = array(
      '#type' => 'select',
      '#title' => t('Block position'),
      '#default_value' => isset($item->block_position) ? $item->block_position : $block_position_default,
      '#options' => $options_block_position,
      //'#empty_value' => 0,
      //'#empty_option' => '-',
    );

    $element['pizzetta_settings']['title_settings']['negative'] = array(
      '#type' => 'checkbox',
      '#title' => t('Negative'),
      '#default_value' => isset($item->negative) ? $item->negative : 0,
    );

    /**
     * Internal padding
     */
    $element['pizzetta_settings']['internal_padding'] = array(
      '#type' => 'details',
      '#title' => $this->t('Internal padding'),
      '#group' => 'pizzetta_settings',
      '#group_name' => 'pizzetta_settings',
      '#description' => '<i class="fa fa-info-circle" aria-hidden="true"></i>',
    );
    foreach($distance_directions as $direction) {
      $key = 'internal_padding_' . $direction;
      $element['pizzetta_settings']['internal_padding'][$key] = array(
        '#type' => 'select',
        '#title' => t(ucwords($direction)),
        '#default_value' => isset($item->{$key}) ? $item->{$key} : '',
        '#options' => $distance_options,
        '#empty_option' => 'none',
      );
    }
    /**
     * Margin
     */
    $element['pizzetta_settings']['margin'] = array(
      '#type' => 'details',
      '#title' => $this->t('Margin'),
      '#group' => 'pizzetta_settings',
      '#group_name' => 'pizzetta_settings',
      '#description' => '<i class="fa fa-info-circle" aria-hidden="true"></i>',
    );
    foreach($distance_directions as $direction) {
      $key = 'margin_' . $direction;
      $element['pizzetta_settings']['margin'][$key] = array(
        '#type' => 'select',
        '#title' => t(ucwords($direction)),
        '#default_value' => isset($item->{$key}) ? $item->{$key} : '',
        '#options' => $distance_options,
        '#empty_option' => 'none',
      );
    }

    $element['pizzetta_settings']['background'] = array(
      '#type' => 'details',
      '#title' => $this->t('Background'),
      '#group' => 'pizzetta_settings',
      '#group_name' => 'pizzetta_settings',
      '#description' => '<i class="fa fa-info-circle" aria-hidden="true"></i>',
    );
    $element['pizzetta_settings']['background']['background_color'] = array(
      '#type' => 'select',
      '#title' => t('Background color'),
      '#default_value' => isset($item->background_color) ? $item->background_color : '',
      '#options' => $options_background_color,
      '#empty_value' => 0,
      '#empty_option' => '-',
    );
    $element['pizzetta_settings']['background']['background_image_opacity'] = array(
      '#type' => 'select',
      '#title' => t('Background image opacity'),
      '#default_value' => isset($item->background_image_opacity) ? $item->background_image_opacity : '',
      '#options' => $percentage_options,
      '#empty_value' => 0,
      '#empty_option' => '-',
    );
    $element['pizzetta_settings']['background']['background_fixed'] = array(
      '#type' => 'checkbox',
      '#title' => t('Background fixed'),
      '#default_value' => isset($item->background_fixed) ? $item->background_fixed : 0,
    );
    $element['pizzetta_settings']['background']['background_image'] = [
      '#type' => 'media_library',
      '#allowed_bundles' => ['image'],
      '#title' => t('Upload your image'),
      '#default_value' => isset($item->background_image) ? $item->background_image : NULL,
      '#description' => t('Upload or select your an image.'),
    ];

    $element['pizzetta_settings']['attributes'] = array(
      '#type' => 'details',
      '#title' => $this->t('Attributes'),
      '#group' => 'pizzetta_settings',
      '#group_name' => 'pizzetta_settings',
      '#description' => '<i class="fa fa-info-circle" aria-hidden="true"></i>',
    );
    $element['pizzetta_settings']['attributes']['css_id'] = array(
      '#type' => 'textfield',
      '#title' => t('CSS ID'),
      '#default_value' => isset($item->css_id) ? $item->css_id : '',
    );
    $element['pizzetta_settings']['attributes']['css_classes'] = array(
      '#type' => 'textfield',
      '#title' => t('Custom CSS classes'),
      '#default_value' => isset($item->css_classes) ? $item->css_classes : '',
    );
    $element['pizzetta_settings']['attributes']['css_style'] = array(
      '#type' => 'textarea',
      '#title' => t('Custom CSS style'),
      '#default_value' => isset($item->css_style) ? $item->css_style : '',
      '#resizable' => 'both',
      '#rows' => 3,
    );
    $element['pizzetta_settings']['attributes']['block_styles'] = array(
      '#type' => 'checkboxes',
      '#title' => t('Style'),
      //'#default_value' => [6086, 6087],
      '#default_value' => isset($item->block_styles) ? unserialize($item->block_styles) : '',
      '#options' => $options_block_styles,
    );
    $element['pizzetta_settings']['attributes']['custom_attributes'] = array(
      '#type' => 'textarea',
      '#title' => t('Custom Attributes'),
      '#default_value' => isset($item->custom_attributes) ? $item->custom_attributes : '',
      '#resizable' => 'both',
      '#rows' => 3,
      '#description' => 'One attribute per line in key=value form. E.g. data-myattr=123',
    );


    // If cardinality is 1, ensure a label is output for the field by wrapping
    // it in a details element.
    if ($this->fieldDefinition->getFieldStorageDefinition()
        ->getCardinality() == 1) {
      $element += array(
        '#type' => 'details',
        '#open' => false,
      );
    }

    return $element;
  }

  public function massageFormValues(array $values, array $form, FormStateInterface $form_state){
    // Turn the nested array structure into a flat key => value array.
    $values_flat = [];
    if (!empty($values)) {
      //todo: manage the block_styles values
      if(isset($values[0]["pizzetta_settings"]["attributes"]["block_styles"])) {
        $bs = $values[0]["pizzetta_settings"]["attributes"]["block_styles"];
        $styles = [];
        foreach ($bs as $tid=>$style) {
          if($style == 0) {continue;}
          $styles[$tid] = $style;
        }
        $values[0]["pizzetta_settings"]["attributes"]["block_styles"] = serialize($styles);
      }
      foreach ($values as $delta => $field) {
        $it = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($field));
        foreach ($it as $k => $v) {
          $values_flat[$delta][$k] = $v;
        }
      }
    }


    return $values_flat;
  }


}
