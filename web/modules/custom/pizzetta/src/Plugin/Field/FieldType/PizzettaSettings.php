<?php

/**
 * @file
 * Contains \Drupal\pizzetta\Plugin\Field\FieldType\PizzettaSettings.
 */

namespace Drupal\pizzetta\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'dice' field type.
 *
 * @FieldType (
 *   id = "pizzetta_settings",
 *   label = @Translation("Pizzetta Settings"),
 *   description = @Translation("Stores Pizzetta settings for Paragraphs"),
 *   default_widget = "pizzetta_settings_widget",
 *   default_formatter = "pizzetta_settings_formatter"
 * )
 */
class PizzettaSettings extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = array();

    $schema['columns']['title'] = array(
      'type' => 'varchar',
      'length' => 255,
    );
    $schema['columns']['hide_title'] = array(
      'type' => 'int',
      'length' => 1,
    );
    $schema['columns']['title_level'] = array(
      'type' => 'varchar',
      'length' => 16,
    );
    $schema['columns']['show_title_in_side_menu'] = array(
      'type' => 'int',
      'length' => 1,
    );
    $schema['columns']['block_position'] = array(
      'type' => 'int',
      'length' => 16,
    );
    $schema['columns']['negative'] = array(
      'type' => 'int',
      'length' => 1,
    );
    $schema['columns']['background_fixed'] = array(
      'type' => 'int',
      'length' => 1,
    );
    $distance_directions = pizzetta_get_distance_directions();
    foreach($distance_directions as $direction) {
      $schema['columns']['internal_padding_' . $direction] = array(
        'type' => 'varchar',
        'length' => 64,
      );
    }
    foreach($distance_directions as $direction) {
      $schema['columns']['margin_' . $direction] = array(
        'type' => 'varchar',
        'length' => 64,
      );
    }

    $schema['columns']['background_color'] = array(
      'type' => 'int',
      'length' => 16,
    );
    $schema['columns']['background_image_opacity'] = array(
      'type' => 'int',
      'length' => 11,
    );
    $schema['columns']['background_image'] = array(
      'type' => 'int',
      'length' => 11,
    );
    $schema['columns']['css_id'] = array(
      'type' => 'varchar',
      'length' => 255,
    );
    $schema['columns']['css_classes'] = array(
      'type' => 'varchar',
      'length' => 255,
    );
    $schema['columns']['css_style'] = array(
      'type' => 'text',
    );
    $schema['columns']['block_styles'] = array(
      'type' => 'text',
      'serialize' => true,
    );
    $schema['columns']['custom_attributes'] = array(
      'type' => 'text',
    );

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    return false;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = [];

    // Add our properties.
    $properties['title'] = DataDefinition::create('string')
      ->setLabel(t('Title'))
      ->setDescription(t('Title'));
    $properties['hide_title'] = DataDefinition::create('integer')
      ->setLabel(t('Hide title'))
      ->setDescription(t('Hide title'));
    $properties['title_level'] = DataDefinition::create('string')
      ->setLabel(t('Title level'))
      ->setDescription(t('Title level'));
    $properties['show_title_in_side_menu'] = DataDefinition::create('integer')
      ->setLabel(t('Show title in the side menu'))
      ->setDescription(t('Show title in the side menu'));
    $properties['block_position'] = DataDefinition::create('integer')
      ->setLabel(t('Block position'))
      ->setDescription(t('Block position taxonomy term id'));
    $properties['negative'] = DataDefinition::create('integer')
      ->setLabel(t('Negative'))
      ->setDescription(t('Negative'));
    $properties['background_fixed'] = DataDefinition::create('integer')
      ->setLabel(t('Background fixed'))
      ->setDescription(t('Background fixed'));

    $distance_directions = pizzetta_get_distance_directions();
    //internal padding
    foreach($distance_directions as $direction) {
      $key = 'internal_padding_' . $direction;
      $label = 'Internal padding ' . ucwords($direction);
      $properties[$key] = DataDefinition::create('string')
        ->setLabel($label)
        ->setDescription($label);
    }
    //margin
    foreach($distance_directions as $direction) {
      $key = 'margin_' . $direction;
      $label = 'Margin ' . ucwords($direction);
      $properties[$key] = DataDefinition::create('string')
        ->setLabel($label)
        ->setDescription($label);
    }

    $properties['background_color'] = DataDefinition::create('integer')
      ->setLabel(t('Background color'))
      ->setDescription(t('Background color taxonomy term id'));

    $properties['background_image_opacity'] = DataDefinition::create('integer')
      ->setLabel(t('Background image opacity'))
      ->setDescription(t('Background image opacity'));
    $properties['background_image'] = DataDefinition::create('integer')
      ->setLabel(t('Background image'))
      ->setDescription(t('Background image file ID'));

    $properties['css_id'] = DataDefinition::create('string')
      ->setLabel(t('CSS ID'))
      ->setDescription(t('CSS ID'));
    $properties['css_classes'] = DataDefinition::create('string')
      ->setLabel(t('Custom CSS classes'))
      ->setDescription(t('Custom CSS classes'));
    $properties['css_style'] = DataDefinition::create('string')
      ->setLabel(t('Custom CSS style'))
      ->setDescription(t('Custom CSS style'));
    $properties['block_styles'] = DataDefinition::create('string')
      ->setLabel(t('Block Styles'))
      ->setDescription(t('Block Styles'));
    $properties['custom_attributes'] = DataDefinition::create('string')
      ->setLabel(t('Custom attributes'))
      ->setDescription(t('Custom attributes'));
    return $properties;
  }
}
