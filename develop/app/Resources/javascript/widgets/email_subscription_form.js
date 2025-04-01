$(function () {

    let  EmailSubscriptionFormWidget = {};

    EmailSubscriptionFormWidget._create = function() {
        this.$form = $(this.element);
        this._csft = $(this.element).data('csft');
        this._subscriptionId = $(this.element).data('subscriptionId');

        this.$errorContainer = $('div[role="errors_container"]:first', this.$form);
        this.$saveOptionsButton = $('button[role="save_options"]', this.$form).click(this._saveSubscriptionOptions.bind(this));
        this.$unsubscribeButton = $('button[role="unsubscribe"]', this.$form).click(this._unsubscribe.bind(this));
    };


    EmailSubscriptionFormWidget._displaySpinnerForButton = function($button) {
        const role = $button.attr('role');
        $(`span[role="loader"][for="${role}"]`).css({"visibility":"visible"});
    };

    EmailSubscriptionFormWidget._hideSpinnerForButton = function($button) {
        const role = $button.attr('role');
        $(`span[role="loader"][for="${role}"]`).css({"visibility":"hidden"});
    };

    EmailSubscriptionFormWidget._saveSubscriptionOptions  = async function(event, element) {
        event.preventDefault();
        const options = this._serializeFormToJson(this.$form);

        if (options['administrativeUnits'].length === 0) {
            this._displayErrors('Ни один район или округ не  выбран.');
            return;
        }

        this._displaySpinnerForButton(this.$saveOptionsButton);
        const response = await fetch(
            `api/email-subscription/options`,
            {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Csft-Token': this._csft,
                },
                body: JSON.stringify(options),
            }
        );
        this._hideSpinnerForButton(this.$saveOptionsButton);

        if (!response.ok) {
            this._displayErrors('На сервере произошла не предвиденная ошибка');
        }
    };


    EmailSubscriptionFormWidget._displayErrors = function(message) {
        this.$errorContainer.text(message).show();
    };

    EmailSubscriptionFormWidget._cleanErrors = function(response) {
        this.$errorContainer.text('').hide();
    };

    EmailSubscriptionFormWidget._unsubscribe = async function() {
        event.preventDefault();

        this._displaySpinnerForButton(this.$unsubscribeButton);
        const response = await fetch(
            `api/email-subscription`,
            {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Csft-Token': this._csft,
                },
            }
        );
        this._hideSpinnerForButton(this.$unsubscribeButton);

        if (!response.ok) {
            this._displayErrors('На сервере произошла не предвиденная ошибка');
        }

        const json = await response.json();

        window.location = json._links.redirect.href;
    };

    EmailSubscriptionFormWidget._serializeFormToJson = function($form) {
        const checkedAdminUnits = $('input[type="checkbox"]:checked', $form);
        let adminUnitsIds = [];
        $(checkedAdminUnits).each(function(index, element) {
            adminUnitsIds.push($(element).val());
        });

        return { administrativeUnits: adminUnitsIds };
    };


    $.widget("custom.emailSubscriptionForm", EmailSubscriptionFormWidget);

    $(document).ready(function() {
        $('form[role="email_subscription_options"]').emailSubscriptionForm();
    });
});
