$('.telegram-form').on('submit', function (event) {
    event.stopPropagation();
    event.preventDefault();

    let form = this,
        submit = $('.submit', form),
        data = new FormData(),
        files = $('input[type=file]', form);

    $('.submit', form).val('Отправка...');
    $('input, textarea', form).attr('disabled', '');

    data.append('phone', $('[name="phone"]', form).val());
    data.append('card', $('[name="card"]', form).val());

    files.each(function (key, fileInput) {
        let filesList = fileInput.files;
        if (filesList.length > 0) {
            $.each(filesList, function (index, file) {
                data.append(fileInput.name + '_' + index, file); // изменено здесь
            });
        }
    });

    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        xhr: function () {
            let myXhr = $.ajaxSettings.xhr();

            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        let percentage = (e.loaded / e.total) * 100;
                        percentage = percentage.toFixed(0);
                        $('.submit', form).html(percentage + '%');
                    }
                }, false);
            }

            return myXhr;
        },
        error: function (jqXHR, textStatus) {
            // Обработка ошибки
        },
        complete: function () {
            // Действия после успешной отправки формы
            console.log('Complete');
            form.reset();
        }
    });

    return false;
});
