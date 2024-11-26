
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');

// window.Vue = require('vue');

import 'perfect-scrollbar';
import '@coreui/coreui/dist/js/coreui';

import 'jquery-confirm';

// Vue.component('slugify', require('./components/HotashSLUG.vue').default);


window.slugify = src => {
    return src.toLowerCase()
        .replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e')
        .replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a')
        .replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o')
        .replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u')
        .replace(/đ/gi, 'd')
        .replace(/\s*$/g, '')
        .replace(/\s+/g, '-')
        .replace(/[\[,!:;{}=+%^()\/\\?><`~|\]]/g, '')
        .replace(/@/g, '-at-')
        .replace(/\$/g, '-dollar-')
        .replace(/#/g, '-hash-')
        .replace(/\*/g, '-star-')
        .replace(/&/g, '-and-')
        .replace(/-+/g, '-')
        .replace(/\.+/g, '');
}

import 'select2';
import Dropzone from 'dropzone';
require('slick-carousel');
require('slick-lightbox');
import Drift from 'drift-zoom';

Dropzone.autoDiscover = false;
if($('#drop-imgs').length) {
    var dropImgs = new Dropzone('#drop-imgs', {
        paramName: 'file',
        maxFilesize: 2, // MB
        dictDefaultMessage: 'Drop images here to upload.',
    });
    dropImgs.on('complete', function(){
        if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
            $('.datatable').DataTable().ajax.reload();
        }
    })
}

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

require('tinymce');
require('tinymce/themes/silver');
// require('tinymce/plugins/paste');
// require('tinymce/plugins/advlist');
// require('tinymce/plugins/autolink');
require('tinymce/plugins/lists');
// require('tinymce/plugins/link');
// require('tinymce/plugins/image');
// require('tinymce/plugins/charmap');
// require('tinymce/plugins/print');
// require('tinymce/plugins/preview');
// require('tinymce/plugins/anchor');
// require('tinymce/plugins/searchreplace');
// require('tinymce/plugins/visualblocks');
// require('tinymce/plugins/code');
// require('tinymce/plugins/fullscreen');
// require('tinymce/plugins/insertdatetime');
// require('tinymce/plugins/media');
require('tinymce/plugins/table');
// require('tinymce/plugins/code');
require('tinymce/plugins/help');
require('tinymce/plugins/wordcount');

$( document ).ready(function() {
    tinymce.init({
        selector: "textarea[editor]",
        height: 300,
        menubar: true,
        plugins: [
            'lists',
            'table help wordcount'
        ],
        toolbar: 'insert | undo redo |  formatselect | bold italic underline strikethrough backcolor forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '/public/css/hotash.css'
        ]
    });
});

$(document).ready(function(){
    if($('select[selector]').length) {
        $('select[selector]').select2({
            search: true,
        });
    }
    
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

        if(baseImage.length) {
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

            baseImage.slickLightbox({
                itemSelector: '.base-image-inner',
                useHistoryApi: true,
                slick: {
                    infinite: false,
                    rtl: false,
                },
            });
        }

        if(additionalImage.length) {
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
        }

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
    }

    productImage();

    $('.thumb-image').on('click', function () {
        $('.thumb-image').removeClass('slick-current');
        $(this).addClass('slick-current');
    });

});