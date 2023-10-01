import { decode } from "../../../../libraries/blurhash/dist/esm/index.js";

(function ($, Drupal, once) {
  Drupal.behaviors.myModuleBehavior = {
    attach: function (context, settings) {
      once('blurhash', '[data-blurhash]').forEach(function (element) {
        const pixels = decode(element.dataset.blurhash, element.width, element.height);
        const canvas = document.createElement("canvas");
        canvas.height = element.height;
        canvas.width = element.width;
        canvas.className = 'blurhash';

        const ctx = canvas.getContext("2d");
        const imageData = ctx.createImageData(element.width, element.height);
        imageData.data.set(pixels);
        ctx.putImageData(imageData, 0, 0);

        $(canvas).insertBefore(element);
      });
    }
  };
})(jQuery, Drupal, once);
