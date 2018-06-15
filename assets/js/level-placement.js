jQuery(document).ready(function ($) {
    var levelform     = document.querySelector('#levelForm');
    var lvlsBar       = document.querySelector('.progress-block');
    var nextLevel     = document.querySelector('#next-questions');
    var prevLevel     = document.querySelector('.prev-block');
    var startTest     = document.querySelector('#startTest');
    var currentLvl    = 1;
    var inputName     = $('#testFullName');
    var inputEmail    = $('#testEmail');
    var inputPhone    = $('#testTelNo');
    var validEmail    = false;
    var validFullName = false;
    var validPhone    = false;
    var startNow      = $('#startTest');
    var siteUrl       = window.location.host;

    /*

      Ejemplo de consulta get con BackboneJs
      Debes remplazar speaksandra.com por tu caso.

    */
    //Inicio
      var ROOT = 'http://speaksandra.com/wp-json/levelplacement/v1/tests';

      var CategoryModel = Backbone.Model.extend({
        urlRoot:ROOT + '/category',
      });

      var CategoryView = Backbone.View.extend({
        initialize:function(){
          this.model = new CategoryModel({id:24});
          this.model.fetch({
            traditional: true,
          });
          this.model.on("change", this.render,this);
        },
        render: function(){
          console.log(this.model.get('result'));
        }
      });

      new CategoryView();
    //FIN

    $(startNow).unbind("click");

    var tabChanger = function (a) {

        if (a == 'next') {
            currentLvl++;
        } else if (a == 'prev') {
            currentLvl--;
        }

        for (let i = 0; i < levelForm.children.length; i++) {
            const item = levelForm.children.item(i);
            const lvl = lvlsBar.children.item(i);
            const lvlIndex = $(lvl).index();

            if (parseInt(item.dataset['step']) === currentLvl) {
                $(item).show();
                if ($('.lvl--active')) {
                    $('.lvl--active').removeClass('lvl--active');
                }
                $(lvl).addClass('lvl--active');
                $(prevLevel).show();

            } else if (parseInt(item.dataset['step']) === currentLvl && lvlIndex) {
                $(item).show();
                if ($(lvl).hasClass('lvl--active')) {
                    $(lvl).removeClass('lvl--active');
                }
                $(lvl).addClass('lvl--active');
                $(prevLevel).show();

            } else {
                $(item).hide();
            }
        }
        console.log(currentLvl);
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

        console.log("Epa");
        if (validFullName == true && validEmail == true && validPhone == true) {

            var nameVal = $(inputName).val();
            var emailVal = $(inputEmail).val();
            var phoneVal = $(inputPhone).val();

            $('.landing-container').hide();
            $('.wizard-container').show();

            console.log(siteUrl + "/wp-json/levelplacement/v1/tests/category/24");


            $.getJSON( siteUrl + "/wp-json/levelplacement/v1/tests/category/24", function( data ) {
                var questions = [];
                $.each( data, function( key, val ) {
                    questions.push(val);
                });
                var fases = splitIntoSubArray(questions,10);
                fases.map(function(item) {
                    // $(levelform).append(`<div class="debug-border"></div>`);
                    item.map(function(item2) {
                        console.log(item2.meta.answers[0]);
                        // $('.debug-border').append(`<div class="debug-border">${item2.title}</div>`);
                    });
                });
            });
        }else {
          alert("Faltan campos por rellenar");
        }
    });

});
