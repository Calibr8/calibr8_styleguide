(function ($, Drupal) {

  Drupal.behaviors.colors = {
    attach: function(context, settings) {
      // Add color hexcodes
      $('.sg-section .color-hex').each(function(index) {
        if($(this).parent().css('background-color')) {
          var hexCode = Drupal.behaviors.colors.rgb2hex($(this).parent().css('background-color'));
          $(this).html(hexCode);
        }
      });
    },

    rgb2hex: function(rgb) {
      if (/^#[0-9A-F]{6}$/i.test(rgb)) return rgb;
      rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
      if(rgb) {
        function hex(x) {
          return ("0" + parseInt(x).toString(16)).slice(-2);
        }
        return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
      }
    }

  }

})(jQuery, Drupal);