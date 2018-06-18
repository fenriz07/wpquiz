jQuery(document).ready(function ($) {
    var levelform       = document.querySelector('#levelForm');
    var lvlsBar         = document.querySelector('.progress-block');
    var nextLevel       = document.querySelector('#next-questions');
    var prevLevel       = document.querySelector('#prev-questions');
    var sendBlock       = document.querySelector('.send-block');
    var sendTest        = document.querySelector('#send-questions');
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
                $(sendBlock).show();
            } else {
                $(nextLevel).show();
                $(sendBlock).hide();
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

        //Timer
        document.getElementById('timer').innerHTML = 01 + ":" + 00;
        startTimer();


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

    // TIMER TO FIRE FUNCTION

    var startTimer = function () {
        var presentTime = document.getElementById('timer').innerHTML;
        var timeArray = presentTime.split(/[:]+/);
        var m = timeArray[0];
        var s = checkSecond((timeArray[1] - 1));
        var finishSend = false;
    
        if (s == 59) {
            m = m - 1;
        }

        if (m < 0)   {
            sendTestEmail();
            finishSend = true;
        }
    
        document.getElementById('timer').innerHTML = m + ":" + s;
        if (!finishSend) {
            setTimeout(startTimer, 1000);
        } else {
            document.getElementById('timer').innerHTML = '00' + ":" + '00';
        }
    }

    // CHECK THE TIMER

    function checkSecond(sec) {

        if (sec < 10 && sec >= 0) {
            sec = "0" + sec;
        } // add zero in front of numbers < 10

        if (sec < 0) {
            sec = "59"
        }
        
        return sec;
    }

    // FUNCTION TO SEND TEST TO EMAIL VIA AJAX

    var sendTestEmail = function() {
        var test = $(levelform).serializeArray();

        new TestView({
          email:    emailVal,
          lastname: nameVal,
          phone:    phoneVal,
          test :    test
        });
    }

    $(sendTest).on('click', function (event) {
        event.preventDefault();

        $(this).prop('disabled', true);

        /*
            TODO BLOQUEAR EL BOTON CUANDO SE LE DA CLICK.
            TODO EMITIR UN MENSAJE DE QUE EL TEST SE ESTA PROCESANDO
            TODO AL FINALIZAR EL TEST, EMITE LA FUNCION RENDER EN EL modelo
            TODO DESTRUIR EL TEST Y EMITIR MENSAJE
            TODO EMITIR MENSAJE DE QUE EL TEST FUE PROCESADO.

        */
       sendTestEmail();

    });

});
