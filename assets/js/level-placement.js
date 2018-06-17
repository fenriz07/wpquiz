jQuery(document).ready(function ($) {
    var levelform       = document.querySelector('#levelForm');
    var lvlsBar         = document.querySelector('.progress-block');
    var nextLevel       = document.querySelector('#next-questions');
    var prevLevel       = document.querySelector('#prev-questions');
    var sendTest        = document.querySelector('.send-block');
    var startTest       = document.querySelector('#startTest');
    var currentLvl      = 0;
    var inputName       = $('#testFullName');
    var inputEmail      = $('#testEmail');
    var inputPhone      = $('#testTelNo');
    var validEmail      = false;
    var validFullName   = false;
    var validPhone      = false;
    var startNow        = $('#startTest');
    var nameVal;
    var emailVal;
    var phoneVal;


    var tabChanger = function (a) {

        if (a == 'next') {
            currentLvl++;
        } else if (a == 'prev') {
            currentLvl--;
        }

        for (let i = 0; i < levelForm.children.length; i++) {
            const item     = levelForm.children.item(i);
            const lvl      = lvlsBar.children.item(i);
            const lvlIndex = $(lvl).index();

            if (currentLvl === (levelForm.children.length - 1)) {
                $(nextLevel).hide();
                $(sendTest).show();
            } else {
                $(nextLevel).show();
                $(sendTest).hide();
            }

            if (currentLvl === 0) {
                $(prevLevel).hide();
            } else {
                $(prevLevel).show();
            }

            if (parseInt(item.dataset['step']) === currentLvl) {
                $(item).show();
                if ($('.lvl--active')) {
                    $('.lvl--active').removeClass('lvl--active');
                }
                $(lvl).addClass('lvl--active');

            } else {
                $(item).hide();
            }
        }
    }

    nextLevel.addEventListener('click', function () {
        tabChanger('next');
    });

    prevLevel.addEventListener('click', function () {
        tabChanger('prev');
    });

    $(inputName).on('input', function () {
        var input = $(this);
        var is_name = input.val();
        if (is_name) {
            validFullName = true;
        } else {
            validFullanem = false;
        }
    });

    $(inputEmail).on('input', function () {
        var input = $(this);
        var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        var is_email = re.test(input.val());
        if (is_email) {
            validEmail = true;
        } else {
            validEmail = false;
        }
    });

    $(inputPhone).on('input', function () {
        var input = $(this);
        if ($(input).val()) {
            validPhone = true;
        } else {
            validPhone = false;
        }
    });

    function splitIntoSubArray(arr, count) {
        var newArray = [];
        while (arr.length > 0) {
            newArray.push(arr.splice(0, count));
        }
        return newArray;
    }

    $("#startTest").click(function (event) {
        event.preventDefault();

        if (validFullName == true && validEmail == true && validPhone == true) {

            nameVal = $(inputName).val();
            emailVal = $(inputEmail).val();
            phoneVal = $(inputPhone).val();

            $('.landing-container').hide('400');
            $('.wizard-container').show('400');

            new CategoryView();
        } else {
            alert("Faltan campos por rellenar");
        }
    });


    $(sendTest).on('click', function (event) {
        //event.preventDefault();

        /*
            TODO BLOQUEAR EL BOTON CUANDO SE LE DA CLICK.
            TODO EMITIR UN MENSAJE DE QUE EL TEST SE ESTA PROCESANDO
            TODO AL FINALIZAR EL TEST, EMITE LA FUNCION RENDER EN EL modelo
            TODO DESTRUIR EL TEST Y EMITIR MENSAJE
            TODO EMITIR MENSAJE DE QUE EL TEST FUE PROCESADO.

        */
        var test = $(levelform).serializeArray();

        new TestView({
          email:    emailVal,
          lastname: nameVal,
          phone:    phoneVal,
          test :    test
        });

    });

});
