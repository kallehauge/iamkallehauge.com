<?php

/**
 * @file
 * Contains \Drupal\gistEmbed\Plugin\Field\FieldFormatter\LinkFormatter.
 */

namespace Drupal\gist_embed\Plugin\Field\FieldFormatter;

use Drupal\link\Plugin\Field\FieldFormatter\LinkFormatter;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Component\Utility\UrlHelper;
use Drupal\Component\Utility\Unicode;

/**
 * Plugin implementation of the 'gist_embed' formatter.
 *
 * Takes a Github Gist url and embed it on the page inside of a <script> tag.
 *
 * @FieldFormatter(
 *   id = "gist_embed",
 *   label = @Translation("Gist Embed"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class GistEmbedFormatter extends LinkFormatter {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    // Define element array.
    $element = [];

    foreach ($items as $delta => $item) {
      // Convert the link-field item to a \Drupal\Core\Url object.
      $url = $this->buildUrl($item);

      // Parse the URL so we can check if the path contains a Github Gist. We do
      // this to check if we should actually render the element or provide a
      // notice in the log.
      $url = UrlHelper::parse($url->getUri());
      if (FALSE !== Unicode::strpos($url['path'], 'gist.github.com')) {
        $element[$delta] = [
          '#theme' => 'gist_embed',
          '#url' => $url,
        ];
      }
      // Provide a log-message about what entity that had a wrong URL.
      else {
        $entity = $items->getEntity();
        $message = $this->t('The entity type: "@type" with the ID: "@id" is trying to use a link that isn\'t a Github Gist link for the Gist Embed Formatter.', array(
          '@type' => ucfirst($entity->getEntityType()->id()),
          '@id' => $entity->id(),
        ));
        \Drupal::logger('gist_embed')->notice($message);
      }
    }

    return $element;
  }
}
