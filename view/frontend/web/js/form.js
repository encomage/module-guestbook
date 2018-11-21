define([
    'jquery',
    'domReady!'
], function ($) {
    'use strict';
    return function (config, element) {
        var stars = $('.guest-book-form .review-control-vote label');
        $(document).on('click', '.js-click', function () {
            var click = $(this).data('click');
            stars.removeClass('active');
            var i = $(this).data('i');
            for (var j = 1; i >= j; j++) {
                $('.guest-book-form .review-control-vote label[data-i="' + j + '"][data-click="' + click + '"]').addClass('active');

            }
            $('.js-guest-post-rating').removeAttr('disabled').val(i);
        });

            $(document).on('keyup', '.js-comment-area', function(e){
                var container = $(e.target).parents('.js-area-comment-container'),
                    maxCharts = container.find('.js-comment-area'),
                    max_length = maxCharts.attr('maxlength'),
                    comment =  container.find('.js-comment'),
                    counter = container.find('.js-comment-area-counter');
                if (max_length > 0) {
                    counter.text(max_length);
                    length = maxCharts.val().length;
                    counter.text(max_length - length);
                    counter.text() === '0' ? comment.css('color', 'red') : comment.css('color', 'black');
                }
            });
        }
});