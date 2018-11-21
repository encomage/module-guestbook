define(['Magento_Ui/js/form/element/abstract'], function (Abstract) {
    return Abstract.extend({
        defaults: {
            items: [
                {name: '1', val: '20%'},
                {name: '2', val: '40%'},
                {name: '3', val: '60%'},
                {name: '4', val: '80%'},
                {name: '5', val: '100%'}
            ]
        },
        initialize: function () {
            return this._super();
        },

        initObservable: function () {
            return this._super().observe(['items']);
        }
    });
});
