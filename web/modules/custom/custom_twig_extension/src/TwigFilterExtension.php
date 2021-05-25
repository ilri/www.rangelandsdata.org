<?php
namespace Drupal\custom_twig_extension;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class TwigFilterExtension.
 */
class TwigFilterExtension extends AbstractExtension{
  /**
   * Declare your custom twig filter here
   *
   * @return array|\Twig_SimpleFilter[]
   */
  public function getFilters()
  {
    return [
      new TwigFilter(
        'remove_p',
        array($this, 'removeParagraphs')
      )
    ];
  }
  /**
   * Function to remove only links from the html
   * @param $string
   *  Html as string
   *
   * @return string
   *  Filtered html
   */
  public static function removeParagraphs($string)
  {
    return preg_replace('#<p.*?>(.*?)</p>#i',
      '\1',
      $string);
  }
}
