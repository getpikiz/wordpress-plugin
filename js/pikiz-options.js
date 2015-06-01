;
jQuery(function ($) {
  'use strict';
  var PIKIZ_URL = "https://localhost:5000";

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
  var type = 'both';

  var $allowFontend = $('[data-allow-fontend]');
  var $disableForAllow = $('.disable_allow');
  var $positionFieldset = $('.disable_content_type_text');
  var $pikizType = $('[data-pikiz-type]');
  var $typeFieldset = $('.disable_auto'); // remove
  var $buttonOrange = $('[data-button-orange]');
  var $buttonWhite = $('[data-button-white]');
  var $buttonDefault = $('[data-button-default]');
  var $buttonLarge = $('[data-button-large]');
  var $buttonPosition = $('[data-button-position]');
  var $buttonLanguage = $('[data-button-language]');
  var $buttonCode = $('[data-button-code]');
  var $captionImgBtn = $ ('[data-caption-img-btn]');
  var $imgFrameOverview = $('[data-pikiz-img-btn-overview]');
  var $quoteTextBtn = $ ('[data-quote-text-btn]');
  var $textFrameOverview = $('[data-pikiz-text-btn-overview]');
  var $autoInfo = $('[data-auto-info]');
  var $autoFieldset = $('[data-auto-fieldset]');
  var $buttonAuto = $('[data-button-auto]');
  var $buttonHover = $('[data-button-hover]');
  var $inputUrl = $('[data-button-url]');
  var $inputTarget = $('[data-button-target]');

  function reloadOverview () {
    if (type === 'image') {
      $imgFrameOverview.attr('src', PIKIZ_URL + '/buttons/templates/' + options[type].language + '/' +
    options[type].size + '/image/' + options[type].style + '.html');
      $quoteTextBtn.css('display', 'none');
      $captionImgBtn.css('display', 'block');
    } else if (type === 'text') {
      $textFrameOverview.attr('src', PIKIZ_URL + '/buttons/templates/' + options[type].language + '/' +
    options[type].size + '/text/' + options[type].style + '.html');
      $captionImgBtn.css('display', 'none');
      $quoteTextBtn.css('display', 'block');
    } else {
      $imgFrameOverview.attr('src', PIKIZ_URL + '/buttons/templates/' + options[type].language + '/' +
    options[type].size + '/image/' + options[type].style + '.html');
      $textFrameOverview.attr('src', PIKIZ_URL + '/buttons/templates/' + options[type].language + '/' +
    options[type].size + '/text/' + options[type].style + '.html');
      $captionImgBtn.css('display', 'block');
      $quoteTextBtn.css('display', 'block');
    }
  }

  function generateCode () {
    var buttonCode;
    if (type === 'inline') {
      buttonCode = '<pikiz:button ';

      for (var property in options[type]) {
        var value = options[type][property];
        if (value !== '' && property !== 'auto') {
          buttonCode += 'data-' + property + '="' + value + '" ';
        }
      }

      buttonCode += '></pikiz:button>';
    }

    $buttonCode.text(buttonCode);
  }

  $allowFontend.on('change', function () {
    $disableForAllow.prop('disabled', !this.checked);

    if (!this.checked || (this.checked && type == 'text')) {
      $positionFieldset.prop('disabled', true);
    }
  });

  $pikizType.on('change', function () {
    type =  this.value;
    $positionFieldset.prop('disabled', type == 'text');
    if ($buttonOrange.prop('checked')) {
      setValue('style', 'orange');
    } else if ($buttonWhite.prop('checked')) {
      setValue('style', 'white');
    }

    if ($buttonLarge.prop('checked')) {
      setValue('size', 'large');
    } else if ($buttonDefault.prop('checked')) {
      setValue('size', 'default');
    }

    generateCode();
    reloadOverview();
  });

  $buttonPosition.on('change', function () {
    setValue('position', $(this).val());
    generateCode();
  });

  $buttonOrange.on('change', function () {
    if (this.checked) {
      setValue('style', 'orange');
      reloadOverview();
      generateCode();
    }
  });

  $buttonWhite.on('change', function () {
    if (this.checked) {
      setValue('style', 'white');
      reloadOverview();
      generateCode();
    }
  });

  $buttonDefault.on('change', function () {
    if (this.checked) {
      setValue('size', 'default');
      reloadOverview();
      generateCode();
    }
  });

  $buttonLarge.on('change', function () {
    if (this.checked) {
      setValue('size', 'large');
      reloadOverview();
      generateCode();
    }
  });

  $buttonAuto.on('change', function () {
    if (this.checked) {
      type = $pikizType.val();
      $autoInfo.text(WPPikiz.strings.uncheck_auto);
    } else {
      type = 'inline';
      $autoInfo.text(WPPikiz.strings.check_auto);
      checkValues();
    }

    $autoFieldset.toggle(!this.checked);
    $buttonCode.toggle(!this.checked);
    $typeFieldset.prop('disabled', !this.checked);

    generateCode();
  });

  $buttonHover.on('change', function () {
    setValue('hover', this.checked);
    generateCode();
  });

  $buttonLanguage.on('change', function () {
    setValue('language', $(this).val());
    generateCode();
    reloadOverview();
  });

  $inputUrl.on('input', function () {
    setValue('url', this.value);
    generateCode();
  });

  $inputTarget.on('input', function () {
    setValue('target', this.value);
    generateCode();
  });

  var setValue = function (property, value) {
    if (options[type][property] !== undefined) {
      options[type][property] = value;
    }
  };

  var checkValues = function () {
    var autoValue = $buttonAuto.prop('checked');
    var allowFontendValue = $allowFontend.prop('checked');
    if (!autoValue) {
      type = 'inline';
    } else {
      type = $pikizType.val();
    }

    $autoFieldset.toggle(!autoValue);
    $buttonCode.toggle(!autoValue);
    $typeFieldset.prop('disabled', !autoValue);
    $disableForAllow.prop('disabled', !allowFontendValue);

    if (!allowFontendValue || (allowFontendValue && type == 'text')) {
      $positionFieldset.prop('disabled', true);
    }

    setValue('url', $inputUrl.val());
    setValue('target', $inputTarget.val());

    if ($buttonDefault.prop('checked')) {
      setValue('size', 'default');
    }

    if ($buttonLarge.prop('checked')) {
      setValue('size', 'large');
    }

    if ($buttonOrange.prop('checked')) {
      setValue('style', 'orange');
    }

    if ($buttonWhite.prop('checked')) {
      setValue('style', 'white');
    }

    if ($buttonHover.prop('checked')) {
      setValue('hover', true);
    }

    setValue('language', $buttonLanguage.val());
    setValue('position', $buttonPosition.val());
  };

  checkValues();
  generateCode();
  reloadOverview();
});
