define([
    'underscore',
    'Magento_Ui/js/form/element/abstract',
    'jquery'
], function (_, Abstract, $) {
    "use strict";

    return Abstract.extend({
        defaults: {
            visible: false,
            required: false,
            listens: {
                visible: 'setPreview',
                '${ $.provider }:data.reset': 'reset',
                '${ $.provider }:${ $.customScope ? $.customScope + "." : ""}data.validate': 'validate',
                '${ $.provider }:${ $.customScope ? $.customScope + "." : ""}custom_attributes.invoice-checkbox': 'setVisible'
            }
        },
        /**
         * Initializes file component.
         *
         * @returns {Media} Chainable.
         */
        initialize: function () {
            this._super();
            this.visible(false);
        },

        setVisible: function () {
            var visible = this.source.shippingAddress.custom_attributes['invoice-checkbox'];
            if (visible) {
                this.validation['required-entry'] = true;
            } else {
                this.error(false);
                this.validation = _.omit(this.validation, 'required-entry');
            }
            this.visible(visible);
            this.required(visible);
            return this;
        }


    });
});
