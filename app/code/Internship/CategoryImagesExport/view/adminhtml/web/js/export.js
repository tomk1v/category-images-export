/**
 * Category Images Export
 *
 * @category Internship
 * @package Internship\CategoryImagesExport
 * @author Andrii Tomkiv <tomkivandrii18@gmail.com>
 * @copyright 2024 tomk1v
 */
define([
    'underscore',
    'uiElement',
    'mageUtils',
    'jquery'
], function (_, Element, utils, $) {
    'use strict';

    return Element.extend({
        defaults: {
            clientConfig: {
                urls: {
                    save: '${ $.submit_url }',
                    beforeSave: '${ $.validate_url }'
                }
            },
            ignoreTmpls: {
                data: true
            }
        },

        /**
         * Save function that should be invoked when the button is clicked.
         */
        save: function () {
            $('body').trigger('processStart');

            $.ajax({
                url: window.imageExportUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    category_id: this.data.category_id,
                    form_key: window.FORM_KEY
                },
                success: function (response) {
                    $('body').trigger('processStop');

                    if (response && response.zipFileName) {
                        const downloadLink = document.createElement('a');
                        downloadLink.href = window.location.origin + '/media/category_images_export/' + response.zipFileName;
                        downloadLink.download = response.zipFileName;
                        document.body.appendChild(downloadLink);
                        downloadLink.click();
                        document.body.removeChild(downloadLink);

                        window.location.reload();
                    }
                },
                error: function (xhr, status, error) {
                    $('body').trigger('processStop');
                    window.location.reload();
                }
            });
        }
    });
});
