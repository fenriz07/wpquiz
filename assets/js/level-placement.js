jQuery(document).ready(function ($) {

    var levelForm       = document.querySelector('#levelForm');
    var lvlsBar         = document.querySelector('.progress-block');
    var nextLevel       = document.querySelector('#next-questions');
    var prevLevel       = document.querySelector('#prev-questions');
    var sendBlock       = document.querySelector('.send-block');
    var sendTest        = document.querySelector('#send-questions');
    var startTest       = document.querySelector('#startTest');
    var currentLvl      = 1;
    var currentTestLvl  = 0;
    var inputName       = $('#testFullName');
    var inputEmail      = $('#testEmail');
    var inputPhone      = $('#testTelNo');
    var validEmail      = false;
    var validFullName   = false;
    var validPhone      = false;
    var fullLoaded      = false;
    var startNow        = $('#startTest');
    var nameVal;
    var emailVal;
    var phoneVal;
    var lvlsInTest      = new LvlView();
    var actualIdTest;
    var actualNameLevel;
    var finalLvl        = false;
    var nQuestion       = 1;
    var cv              = null;

    var ProgressBar = function ( level )
    {
        lvl_active = lvlsBar.children.item(currentLvl);

        if ($('.lvl--active')) {
            $('.lvl--active').removeClass('lvl--active');
        }

        $(lvl_active).addClass('lvl--active');
    }

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
            if (currentLvl === (levelForm.children.length)) {
                $(nextLevel).hide();
                $(sendBlock).show();

                ProgressBar(currentLvl);

            } else {

                let next_lvl      = lvlsBar.children.item(currentLvl);

                ProgressBar(currentLvl);

                $(sendBlock).hide();
                $(nextLevel).show();

            }

            if (currentLvl === 1) {
                $(prevLevel).hide();
            } else {
                $(prevLevel).show();
            }

            if (parseInt(item.dataset['step']) === currentLvl) {
                $(item).show();
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

    var stopLoading = function() {
        $('.loading-overlay').addClass('d-none');
        fullLoaded = true;
        return fullLoaded;
    }

    $("#startTest").click(function (event) {
        event.preventDefault();

        if ( true ) {

            setTimeout(stopLoading, 3000);

            //Timer HERE YOU SELECT THE TIME THAT YOU WANT TO
            //document.getElementById('timer').innerHTML = 60 + ":" + 00;
            // startTimer();

            nameVal = $(inputName).val();
            emailVal = $(inputEmail).val();
            phoneVal = $(inputPhone).val();

            var modelContact = new ContactModel();
                modelContact.set("email",emailVal);
                modelContact.set("lastname",nameVal);
                modelContact.set("phone",phoneVal);
                modelContact.set("name-test",site.nametest);
                modelContact.set("action", "process_question");
                modelContact.save()

            $('.landing-container').hide('400');
            $('.wizard-container').show('400');

            var lvlsInTestSend = lvlsInTest.getLevels();
            var levelsLen = lvlsInTestSend.length;

            if (levelsLen > 7) {
                jQuery(lvlsBar).children().removeClass('lvlForm');
                jQuery(lvlsBar).children().addClass('lvlForm--stretch');

                for (var i = 1; i < (levelsLen + 1); i++) {
                  jQuery(lvlsBar).append(`
                  <div class="lvlForm--stretch">
                    <div>
                      <span>
                          ${i}
                      </span>
                    </div>
                  </div>
                  `);
                }
              } else {
                for (var i = 1; i < (levelsLen + 1); i++) {

                  jQuery(lvlsBar).append(`
                  <div class="lvlForm">
                    <div>
                      <span>
                          ${i}
                      </span>
                      <span class="details">
                        Part: ${i}
                      </span>
                      <span class="details">
                        ${lvlsInTestSend[ (i-1) ]['title']}
                      </span>
                    </div>
                  </div>
                  `);
                }
              }

        } else {
            $('.input-material:nth-child(3)').append(`
            <div>
                <span class="required-field">Faltan campos por rellenar o son incorrectos</span>
            </div>
            `);
        }
    });

    $('#start-questions').on('click', function(){

        fullLoaded = false;
        $('.loading-overlay').removeClass('d-none');
        setTimeout(stopLoading, 4000);

        ( new StartTest( lvlsInTest.getLevels() ) );

        var lvlsInTestSend = lvlsInTest.getLevels();
        var levelsLen = lvlsInTestSend.length;
        const lvl      = lvlsBar.children.item(1);

        $('[data-step="0"]').remove();
        $(this).hide();
        $('.next-block').show();

        actualNameLevel     = lvlsInTestSend[0].title
        actualIdTest        = lvlsInTestSend[0].id;

        if ($('.lvl--active')) {
            $('.lvl--active').removeClass('lvl--active');
        }

        $(lvl).addClass('lvl--active');
        
    });

    var changeLevel = function() {
        currentTestLvl++;
        currentLvl = 1;
        var lvlsInTestSend = lvlsInTest.getLevels();
        var lvlsLen = lvlsInTestSend.length;

        for (var i = 0; i < lvlsLen; i++) {
            const lvl      = lvlsBar.children.item(i + 1);

            if (currentTestLvl === (lvlsLen - 1)) {
                finalLvl = true;
            }

            if (i === currentTestLvl) {
                cv.setNewLvl({
                  id          :  lvlsInTestSend[i].idcat,
                  conditional :  true,
                  finalLvl    :  finalLvl,
                  actualId    :  lvlsInTestSend[i].idcat,
                });

                actualIdTest    = lvlsInTestSend[i].idcat;
                actualNameLevel = lvlsInTestSend[i].namelvl;

                if ($('.lvl--active')) {
                    $('.lvl--active').removeClass('lvl--active');
                }

                $(lvl).addClass('lvl--active');

            }
        }
    }

    $('#cancel-test').on('click', function() {
        $('.wizard-container').hide();
        $('.result-container').show();
        $('.result-container').children().removeClass('d-none');
        $('.result-container').children().removeClass('d-flex');
        $('.result-container').addClass('result-container--show');
    })

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

    $(sendTest).on('click', function (event) {
        event.preventDefault();

        if(jQuery('.modal-block').children().children().css('display') == 'none') {
            $('.modal-block').children().children().show();
        }

        $(this).prop('disabled', true);

        sendTestEmail();
    });

    // FUNCTION TO SEND TEST TO EMAIL VIA AJAX

    var sendTestEmail = function() {
        var test = $(levelForm).serializeArray();

        new TestView({
          email:       emailVal,
          lastname:    nameVal,
          phone:       phoneVal,
          test :       test,
          idcat:       actualIdTest,
          finalLvl:    finalLvl,
          namelvl:     actualNameLevel
        });
    }

});
