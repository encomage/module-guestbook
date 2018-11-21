define([
    'jquery',
    'domReady!'
], function ($) {
    'use strict';
    return function (config, element) {
        $(document).on('click', '.js-answer-reply-open', function () {
            var dataReplyMessage = $(this).data('message');
            $('.js-reply-form-container-' + dataReplyMessage).show();
            $('.js-answer-reply-close').show();
            $('.js-answer-reply-open').hide();
        });

        $(document).on('click', '.js-answer-reply-close', function () {
            var dataReplyMessage = $(this).data('message');
            $('.js-reply-form-container-' + dataReplyMessage).hide();
            $('.js-answer-reply-open').show();
            $('.js-answer-reply-close').hide();
        });
    };
});