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

            if (currentLvl === 6) {
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

            $('.landing-container').hide();
            $('.wizard-container').show();

            setTimeout(sendEmail, 3600000);

            new CategoryView();
        } else {
            alert("Faltan campos por rellenar");
        }
    });

    var sendEmail = function() {
        var test = $(levelform).serializeArray();

        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "http://localhost/Speaktusucceed/wp-json/levelplacement/v1/test",
            "method": "POST",
            "headers": {
                "Content-Type": "application/x-www-form-urlencoded",
                "Cache-Control": "no-cache",
            },
            "data": {
              "email": emailVal,
              "lastname": nameVal,
              "phone": phoneVal,
              "id_category": "22",
              "name-test": "A1",
              "action": "process_question"

            }
        }

        for (var i = 0; i < test.length; i++) {
            settings.data['test['+i+'][id]'] = test[i].name;
            settings.data['test['+i+'][slug]'] = test[i].value;
        }
          
        $.ajax(settings).done(function (response) {
            console.log(response);
        });
    }

    $(sendTest).on('click', function (event) {
        event.preventDefault();

        sendEmail();
        
    });

});