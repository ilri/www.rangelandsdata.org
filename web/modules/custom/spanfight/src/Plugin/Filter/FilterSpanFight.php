<?php
/**
 * @file
 * Contains Drupal\spanfight\Plugin\Filter\FilterSpanFight
 */

namespace Drupal\spanfight\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a filter to help celebrate good times!
 *
 * @Filter(
 *   id = "filter_spanfight",
 *   title = @Translation("SpanFight Filter"),
 *   description = @Translation("Removes multiple nested <span> tags"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */


class FilterSpanFight extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    $regex = "\s*<span>\s*(?:[^<]*|(?R))\s*<\/span>\s*";
    preg_match_all('/'. $regex .'/', $text, $matches);
    foreach($matches[0] as $match) {
      $replace = strip_tags($match);
      $text = str_replace($match, $replace, $text);
    }

    $result = new FilterProcessResult($text);

    return $result;
  }


}
