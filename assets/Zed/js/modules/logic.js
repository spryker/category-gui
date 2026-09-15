/**
 * Copyright (c) 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

'use strict';

require('./request-helper.js');

var STORE_SELECTOR_ID = '#category_store_relation_id_stores';
var STORE_FORM_NAME = 'category';
var STORE_SELECTOR_LOADER_CLASS_NAME = '.relation-selector-loader';
var STORE_SELECTOR_ACTION_URL_ATTRIBUTE = 'action-url';
var STORE_SELECTOR_ACTION_EVENT_ATTRIBUTE = 'action-event';
var STORE_SELECTOR_ACTION_FIELD_ATTRIBUTE = 'action-field';

/**
 * @return {void}
 */
var handleStoreSelector = function () {
    var storeSelector = $(STORE_SELECTOR_ID);
    var storeSelectorActionFieldName = storeSelector.attr(STORE_SELECTOR_ACTION_FIELD_ATTRIBUTE);
    var parentCategorySelector = $("[name='" + STORE_FORM_NAME + '[' + storeSelectorActionFieldName + "]']");

    var parentCategoryData = parentCategorySelector.select2('data');
    if (!parentCategoryData) {
        return;
    }

    var storeSelectorLoader = storeSelector.parent().find(STORE_SELECTOR_LOADER_CLASS_NAME);
    var storeSelectorActionUrl = storeSelector.attr(STORE_SELECTOR_ACTION_URL_ATTRIBUTE);
    var storeSelectorActionEvent = storeSelector.attr(STORE_SELECTOR_ACTION_EVENT_ATTRIBUTE);
    var parentCategoryId = parentCategoryData[0].id;
    if (!parentCategoryId) {
        storeSelector.prop('disabled', true);
    }

    parentCategorySelector.on(storeSelectorActionEvent, function (event) {
        var selectedCategoryId = $(this).select2('data')[0].id;

        if (selectedCategoryId) {
            $.ajax({
                url: storeSelectorActionUrl + '?id-category-node=' + selectedCategoryId,
                success: function (data) {
                    storeSelector.empty();

                    data.forEach(function (item) {
                        var optionItem = $('<option></option>')
                            .prop('value', item.id_store)
                            .prop('disabled', !item.is_active)
                            .text(item.name);

                        storeSelector.append(optionItem);
                    });

                    storeSelector.prop('disabled', false);
                },
                beforeSend: function () {
                    storeSelectorLoader.addClass('active');
                },
                complete: function () {
                    storeSelectorLoader.removeClass('active');
                },
            });

            return;
        }

        storeSelector.prop('disabled', true);
    });
};

$(document).ready(function () {
    handleStoreSelector();
});
