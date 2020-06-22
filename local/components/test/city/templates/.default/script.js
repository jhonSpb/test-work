$(document).ready(function () {
    jQuery.fn.serializeObject = function () {
        var formData = {};
        var formArray = this.serializeArray();
        for (var i = 0, n = formArray.length; i < n; ++i)
            formData[formArray[i].name] = formArray[i].value;
        return formData;
    };

    var modalMessage = $('#js-modal-change-city');
    var cities_wrapper = $('#cities-wrapper');

    BX.ajax.runComponentAction('test:city',
        'items', {
            mode: 'class',
            data: {
                post: {
                    url: ''
                },
                params: componentCityParams
            }
        })
        .then(function (response) {
            cities_wrapper.html(response.data.cities);
        });

    $(document).on('click', '#cities-wrapper a', function (event) {
        var a = $(this);
        BX.ajax.runComponentAction('test:city',
            'items', {
                mode: 'class',
                data: {
                    post: {
                        url: a.attr('href')
                    },
                    params: componentCityParams
                }
            })
            .then(function (response) {
                cities_wrapper.html(response.data.cities);
            });
        return false;
    });

    $(document).on('click', '.js-button-city-delete', function (event) {
        var button = $(this);
        BX.ajax.runComponentAction('test:city',
            'delete', {
                mode: 'class',
                data: {
                    post: {
                        id: $(this).data('id')
                    },
                    params: componentCityParams
                }
            })
            .then(function (response) {
                cities_wrapper.html(response.data.cities);
            });
    });

    $(document).on('click', '.js-button-city-edit', function (event) {
        modalMessage.find('#message').html('');
        var button = $(this);
        BX.ajax.runComponentAction('test:city',
            'show', {
                mode: 'class',
                data: {
                    post: {
                        id: $(this).data('id')
                    },
                    params: componentCityParams
                }
            })
            .then(function (response) {
                modalMessage.find('.modal-content').html(response.data.item);
                modalMessage.find('#message').html('');
                modalMessage.modal('show');
            });
    });

    $(document).on('click', '.js-button-city-save', function (event) {
        var button = $(this);
        modalMessage.find('#message').html('');
        BX.ajax.runComponentAction('test:city',
            'save', {
                mode: 'class',
                data: {
                    post: modalMessage.find('form').serializeObject(),
                    params: componentCityParams
                }
            })
            .then(function (response) {
                if (response.data.status == 'error') {
                    modalMessage.find('#message').html(response.data.message);
                } else {
                    cities_wrapper.html(response.data.cities);
                    modalMessage.modal('hide');
                }
            });
    });
});
