(function ($) {
    var LanguageService = window.languageService || {};
    var allElements, localeElements = {};

    var trimCRLF = function (string) {
        return string.replace(/\r/g, '').replace(/\n/g, '');
    }
    var proxyFormCollection = function (languageService) {
        $("[data-repeater-create]").click(function () {
            $(".languageElement").each(function () {
                var languageElement = $(this);
                // jquery.repeater.jsによって付け直された要素nameを戻す
                languageElement.attr('name', languageElement.data('name'))
            });
        });
    }

    $.each(languageService.config.translations, function (locale, messages) {
        $.each(messages, function (key, val) {
            key = trimCRLF(key);
            languageService.config.translations[locale][key] = val;
        });
    })

    LanguageService.reset = function () {
        $.each(localeElements, function (_, elements) {
            $.each(elements, function (_, element) {
                element.$wrapper.append(element);
            })
        })
    },
    LanguageService.mapping = function () {
        var self = this;
        $('form[data-language]').each(function (_, form) {
            var fragment = document.createDocumentFragment();
            var wrapper  = document.createElement('div');
            var $wrapper = $(wrapper);
            allElements = $('input:text, textarea', form);
            $(wrapper).addClass('languageWrapper');
            $.each(self.config.languages, function (locale, _) {
                if (locale === self.config.locale) return;
                var languageElements = localeElements[locale] || {};
                var translations = self.config.translations[locale] || {};
                var mapping = self.config.mapping[locale];
                allElements.each(function () {
                    var element = this;
                    var elementName = element.name, elementValue;
                    var languageElement, internName;
                    var fieldsetName;
                    if (!elementName) return;
                    if (languageElements[elementName]) return;
                    $element = $(element);
                    if ($element.hasClass('nolanguage')) return;
                    fieldsetName = elementName.split('[')[0];
                    mapTo = mapping[fieldsetName];
                    if (!mapTo) return;
                    elementValue = $.trim($element.val());
                    elementValue = trimCRLF(elementValue);
                    languageName = elementName.replace(fieldsetName, mapTo);
                    languageValue = translations[elementValue] || null;
                    languageElement = $element.clone();
                    languageElement.val(languageValue);
                    languageElement.addClass('languageElement');
                    languageElement.attr('name', languageName);
                    languageElement.data('name', languageName);
                    languageElement.attr('placeholder', '（' + locale + '）' + languageElement.attr('placeholder'))
                    languageElements[elementName] = languageElement;
                    languageElement.mapTo = element;
                    languageElement.$wrapper = $wrapper;
                    $wrapper.append(languageElement);
                });
                localeElements[locale] = languageElements;
            });
            fragment.appendChild(wrapper);
            form.appendChild(fragment);
        });
    }
    LanguageService.switch = function (locale) {
        LanguageService.reset();
        if (locale == this.config.locale) {
            return;
        }
        var elements = localeElements[locale];
        $.each(elements, function (_, item) {
            $(item.mapTo).after(item);
        });
    }
    LanguageService.mapping();
    LanguageService.juageLanguageSupport = function () {
        var elementCount = $('.languageElement', 'form[data-language]').size();
        if(elementCount > 0) {
            $('#' + LanguageService.config.selector).removeClass('languageSelectorHide');
        } else {
            $('#' + LanguageService.config.selector).addClass('languageSelectorHide');
        }
    }
    $(document).on('click', '[data-repeater-create]', function() {
        LanguageService.reset();
        LanguageService.mapping();
        LanguageService.switch($('#' + LanguageService.config.selector).val());
        LanguageService.juageLanguageSupport();
    });
    LanguageService.juageLanguageSupport();
    LanguageService.switch(LanguageService.config.default_selector);
    proxyFormCollection(LanguageService);
    $('#' + LanguageService.config.selector).change(function () {
        var locale = this.value;
        var self = $(this);
        LanguageService.switch(locale);
        self.attr('data-locale', locale);
    }).change();
    window.languageService = LanguageService;
})(jQuery);