/**
 * @file
 * View frontpage.
 *
 * Init the Masonry jQuery library on the .view-frontpage element.
 */
(function ($, Drupal) {
  'use strict';

  /**
   * Initialise masonry.
   *
   * @see http://masonry.desandro.com/
   */
  Drupal.behaviors.ViewFrontpageMasonry = {
    attach: function (context, settings) {
      // Init masonry.
      var $masonry = $('.view-frontpage__content', context).masonry({
        itemSelector: '.article-teaser'
      });

      // Reposition elements after each image load.
      $masonry.imagesLoaded().progress(function() {
        $masonry.masonry('layout');
      });
    }
  };

})(jQuery, Drupal);
