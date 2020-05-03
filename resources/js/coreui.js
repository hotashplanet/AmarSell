/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import 'perfect-scrollbar';
import '@coreui/coreui/dist/js/coreui';

import 'jquery-confirm';

// Vue.component('slugify', require('./components/HotashSLUG.vue').default);

import 'sumoselect';
require('slick-carousel');
require('slick-lightbox');
import Drift from 'drift-zoom';

// var $ = jQuery = window.$ = window.jQuery = require('jquery');
// require( 'jszip' );
import 'datatables.net';
import 'datatables.net-bs4';
// import 'datatables.net-editor-bs4';
import 'datatables.net-buttons-bs4';
import 'datatables.net-buttons/js/buttons.colVis.js';
import 'datatables.net-buttons/js/buttons.flash.js';
import 'datatables.net-buttons/js/buttons.html5.js';
import 'datatables.net-buttons/js/buttons.print.js';
// import 'datatables.net-responsive-bs4';
import 'datatables.net-select-bs4';

$(document).ready(function(){
    $('select[selector]').SumoSelect({
        search: true,
    });
    
    $('.delete-action').click(function(e) {
        e.preventDefault();
        var $this = $(this);
        $.confirm({
            icon: 'fa fa-warning',
            title: 'Are You Sure To Delete?',
            content: 'Something is going to be deleted.',
            type: 'red',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Delete',
                    btnClass: 'btn-red',
                    action: function() {
                        $this.parents('form').submit();
                    }
                },
                close: function() {}
            }
        });
    });
    $('.remove-action').click(function(e) {
        e.preventDefault();
        var $this = $(this);
        $.confirm({
            icon: 'fa fa-warning',
            title: $this.data('title') || 'Are You Sure To Remove?',
            content: $this.data('content') || 'Something is going to be removed.',
            type: 'red',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Remove',
                    btnClass: 'btn-red',
                    action: function() {
                        $this.parents($this.data('target')).fadeOut(350, function(){
                            $(this).remove();
                        });
                    }
                },
                close: function() {}
            }
        });
    });



    
    /*----------------------------------------*/
    /*      product image
    /*----------------------------------------*/

    function productImage(baseImageConfig = {}, additionalImageConfig = {}) {
        let baseImage = $('.base-image');
        let additionalImage = $('.additional-image');

        baseImage.slick($.extend({
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false,
            arrows: false,
            infinite: false,
            fade: false,
            draggable: false,
            swipe: false,
            rows: 0,
            rtl: false,
        }, baseImageConfig));

        additionalImage.slick($.extend({
            slidesToShow: 4,
            slideToScroll: 1,
            dots: false,
            arrows: true,
            infinite: false,
            centerMode: false,
            focusOnSelect: true,
            asNavFor: '.base-image',
            rows: 0,
            rtl: false,
            responsive: [
                {
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 4,
                    },
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                    },
                },
            ],
        }, additionalImageConfig));

        $('.base-image-inner img').each((i, img) => {
            new Drift(img, {
                sourceAttribute: 'src',
                paneContainer: document.querySelector('.product-details'),
                inlinePane: 991,
                inlineOffsetY: -80,
                containInline: true,
                hoverBoundingBox: true,
            });
        });

        baseImage.slickLightbox({
            itemSelector: '.base-image-inner',
            useHistoryApi: true,
            slick: {
                infinite: false,
                rtl: false,
            },
        });
    }

    productImage();

    $('.thumb-image').on('click', function () {
        $('.thumb-image').removeClass('slick-current');
        $(this).addClass('slick-current');
    });

});