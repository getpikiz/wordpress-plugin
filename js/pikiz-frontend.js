;
jQuery(function ($) {
  var options = {
    text: {
      type: 'text',
      size:'default',
      style: 'orange',
      language: 'en'
    },
    image: {
      type: 'image',
      position: 'topLeft',
      size:'default',
      style: 'orange',
      hover: false,
      language: 'en'
    },
    both: {
      style: 'orange',
      position: 'topLeft',
      size:'default',
      hover: false,
      language: 'en'
    },
    inline: {
      auto: false,
      style: 'orange',
      size: 'default',
      url: '',
      target: '',
      language: 'en'
    }
  };

  var type = WPPikiz.options.type || 'both';
  var json = $.extend(options[type], WPPikiz.options);

  if (!window.Pikiz || (window.Pikiz && typeof window.Pikiz.init !== "function") ) {
    var s = document.createElement("script");
    var g = document.getElementsByTagName("script")[0];
    s.addEventListener("load", function () {
      window.Pikiz.init(WPPikiz.options.api_key, json);
    });
    s.async = true;
    s.src= WPPikiz.PIKIZ_URL + "/scripts/embed/pikiz.js";
    g.parentNode.insertBefore(s,g);
  }
});
