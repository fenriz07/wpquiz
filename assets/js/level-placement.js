jQuery(document).ready(function ($) {
    var levelform = document.querySelector('#levelForm');
    // var lvlsBar = document.querySelector('.progress-block');
    // var nextLevel = document.querySelector('#next-questions');
    // var prevLevel = document.querySelector('.prev-block');
    // var startTest = document.querySelector('#startTest');
    // var currentLvl = 1;
    // var inputName = $('#testFullName');
    // var inputEmail = $('#testEmail');
    // var inputPhone = $('#testTelNo');
    // var validEmail = false;
    // var validFullName = false;
    // var validPhone = false;


    // var tabChanger = function (a) {

    //     if (a == 'next') {
    //         currentLvl++;
    //     } else if (a == 'prev') {
    //         currentLvl--;
    //     }

    //     for (let i = 0; i < levelForm.children.length; i++) {
    //         const item = levelForm.children.item(i);
    //         const lvl = lvlsBar.children.item(i);
    //         const lvlIndex = $(lvl).index();

    //         if (parseInt(item.dataset['step']) === currentLvl) {
    //             $(item).show();
    //             if ($('.lvl--active')) {
    //                 $('.lvl--active').removeClass('lvl--active');
    //             }
    //             $(lvl).addClass('lvl--active');
    //             $(prevLevel).show();

    //         } else if (parseInt(item.dataset['step']) === currentLvl && lvlIndex) {
    //             $(item).show();
    //             if ($(lvl).hasClass('lvl--active')) {
    //                 $(lvl).removeClass('lvl--active');
    //             }
    //             $(lvl).addClass('lvl--active');
    //             $(prevLevel).show();

    //         } else {
    //             $(item).hide();
    //         }
    //     }
    //     console.log(currentLvl);
    // }

    // nextLevel.addEventListener('click', function () {
    //     tabChanger('next');
    // });

    // prevLevel.addEventListener('click', function () {
    //     tabChanger('prev');
    // });

    // // startTest.addEventListener('click', function () {
    // //     $('.landing-container').hide();
    // //     $('.wizard-container').show();
    // // });

    // $(inputName).on('input', function () {
    //     var input = $(this);
    //     var is_name = input.val();
    //     if (is_name) {
    //         validFullName = true;
    //     } else {
    //         validFullanem = false;
    //     }
    // });

    // $(inputEmail).on('input', function () {
    //     var input = $(this);
    //     var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    //     var is_email = re.test(input.val());
    //     if (is_email) {
    //         validEmail = true;
    //     } else {
    //         validEmail = false;
    //     }
    // });

    // $(inputPhone).on('input', function () {
    //     var input = $(this);
    //     // var re =
    //     //     /^((\\+[1-9]{1,4}[ \\-]*)|(\\([0-9]{2,3}\\)[ \\-]*)|([0-9]{2,4})[ \\-]*)*?[0-9]{3,4}?[ \\-]*[0-9]{3,4}?$/;
    //     // var is_tel = re.test(input.val());
    //     if ($(input).val()) {
    //         validPhone = true;
    //     } else {
    //         validPhone = false;
    //     }
    // });

    function splitIntoSubArray(arr, count) {
        var newArray = [];
        while (arr.length > 0) {
          newArray.push(arr.splice(0, count)); 
        }
        return newArray;
    }

    // $("#startTest").click(function (event) {

    //     if (validFullName === true && validEmail === true && validPhone === true) {

    //         var nameVal = $(inputName).val();
    //         var emailVal = $(inputEmail).val();
    //         var phoneVal = $(inputPhone).val();

    //         $('.landing-container').hide();
    //         $('.wizard-container').show();

    //         console.log(nameVal);
    //         console.log(emailVal);
    //         console.log(phoneVal);

            $.getJSON( "http://localhost/Speaktusucceed/wp-json/levelplacement/v1/tests/category/22", function( data ) {
                var questions = [];
                $.each( data, function( key, val ) {
                    questions.push(val);
                    // // console.log(val.title); TITLE OF QUESTION
                    // $.each(val.meta, function( keyTwo, valTwo) {

                    //     $.each(valTwo, function( keyThree, valThree) {
                    //        // console.log(valThree.text); THIS IS THE ANSWER
                    //     });
                    // });
                });
                var fases = splitIntoSubArray(questions,10);
                console.log(fases);
                fases.map(function(item) {
                    console.log(item);
                    $(levelform).append(`<div class="debug-border"></div>`);
                    item.map(function(item2) {
                        console.log(item2.title);
                        console.log(item2);
                        $('.debug-burder').append(`<div class="debug-border">${item.title}</div>`);
                    });
                });
            });
    //     }
    // });

});
