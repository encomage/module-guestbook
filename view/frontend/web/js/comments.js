define([
    'jquery',
    'mage/template',
    'jquery/ui',
    'mage/translate',
    "domReady!"
], function ($) {
    'use strict';
    return function (config, element) {
        var button = $('.js-show-form'),
            form = $('.guest-book-form'),
            listingAjaxUrl = config.listingAjaxUrl,
            commentListContainer = $(document).find('.guest-book-list'),
            toolbar = $(document).find('.toolbar-number');

        $.ajax({
            url: listingAjaxUrl,
            type: "POST",
            dataType: "json",
            data: {isAjax: true},
            showLoader: true,
            success: function (data) {
                commentListContainer.html(data.html);
                toolbar.html(data.count + " " + $.mage.__('Comment(s)'));
            }
        });

        button.on('click', function () {
            if (button.data('logged')) {
                $('.js-clean-form').html('');
                scrollTo(form, 7000);
            } else {
                $('.js-form-button').attr('disabled', true);
                $('.js-show-message').show();
            }
        });

        $(document).on('click', '.js-reply-message', function () {
            var dataMessage = $(this).data('reply-message'),
                messageForm = $('.js-message-form-container-' + dataMessage);
            if (messageForm.is(":hidden")) {
                messageForm.show();

            } else {
                messageForm.hide();
            }
        });

        $(document).on('click', '.see-more', function () {
            var dataMessageId = $(this).data('message-id'),
                url = $(this).data('url'),
                answerContainer = $('.answer-' + dataMessageId),
                _this = this;
            if (answerContainer.hasClass('.received')) {
                if (answerContainer.is(":hidden")) {
                    answerContainer.show();
                    $(this).text($.mage.__('See Less'));
                } else {
                    answerContainer.hide();
                    $(this).text($.mage.__('See More'));
                }
            } else {
                $.ajax({
                    url: url,
                    method: "POST",
                    dataType: "json",
                    data: {messageId: dataMessageId},
                    showLoader: true,
                    success: function (response) {
                        $(".answer-" + dataMessageId).html(response.html);
                        $(_this).text($.mage.__('See less'));
                        answerContainer.addClass('.received');

                        var children = answerContainer.children();
                        $.each(children, function (key, value) {
                            var margin = $(value).data('margin');
                            $(value).css('margin-left', margin + 'px');
                        })
                    }
                });
            }
        });
    }
});
