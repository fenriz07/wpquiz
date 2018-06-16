jQuery(document).ready(function ($) {
    var levelform       = document.querySelector('#levelForm');
    var lvlsBar         = document.querySelector('.progress-block');
    var nextLevel       = document.querySelector('#next-questions');
    var prevLevel       = document.querySelector('#prev-questions');
    var nextLevel       = document.querySelector('.next-block');
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
            console.log(currentLvl);
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

            var nameVal = $(inputName).val();
            var emailVal = $(inputEmail).val();
            var phoneVal = $(inputPhone).val();

            $('.landing-container').hide();
            $('.wizard-container').show();

            new CategoryView();
        } else {
            alert("Faltan campos por rellenar");
        }
    });


    $(sendTest).on('click', function (event) {
        event.preventDefault();

        var inputValue = $(':radio');

        var testAnswers = [];

        for (var i = 0; i < inputValue.length; i++) {
            testAnswers.push(inputValue[i].value)
        }

        console.log(testAnswers);
    });

});