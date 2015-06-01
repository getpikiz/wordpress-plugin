;
jQuery(function ($) {
  'use strict';
  var PIKIZ_URL = "https://localhost:5000";

  (function (w, d) {
    if (!w.Pikiz || (w.Pikiz && typeof w.Pikiz.init !== "function") ) {
      var _s = d.createElement("script");
     _s.src = PIKIZ_URL + "/scripts/embed/pikiz.js";
     _s.addEventListener("load", function () {
       w.Pikiz.init("", {"appUrl": PIKIZ_URL, "auto": false});
     });
     d.body.appendChild(_s);
    }
  })(window, document);

  var media_window = wp.media({
    title: 'Choose an image',
    library: {type: 'image'},
    multiple: false,
    button: {text: 'Choose'}
  });

  media_window.on('select', function(){
    var files = media_window.state().get('selection').toArray();
    var first = files[0].toJSON();

    if (window.Pikiz) {
      var url = PIKIZ_URL +
        '/images/create?origin=wordpress_plugin' +
        '&img=' + first.url +
        '&apikey=' +
        '&referrer=' + window.location.href;

      window.Pikiz.Dialog.open(url);
    }
  });

  window.addEventListener('message', function (e) {
    if (e.origin === PIKIZ_URL && e.data.action === 'close') {
      var html = '<a href="' + e.data.pageUrl +'">' +
        '<img src="' + e.data.imgUrl + '" />' +
      '</a>';

      wp.media.editor.insert(html);
    }
  });

  $(document).ready(function () {
    $('#pikiz-insert-media').on('click', function (e) {
      e.preventDefault();
      media_window.open();
    });
  });

});
