define([
    'Magento_Ui/js/grid/columns/column'
], function (Column) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'Takyon_Core/listing/column/list'
        },

        /**
         * @param {Array} record
         * @returns {Array}
         */
        getItems: function (record) {
            return record[this.index];
        }
    });
});
