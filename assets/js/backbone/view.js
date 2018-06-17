var CategoryView = Backbone.View.extend({
  initialize: function () {
    this.model = new CategoryModel({
      id: site.idcat
    });
    this.model.fetch({
      traditional: true,
    });
    this.model.on("change", this.render, this);
    }
  ,
  splitIntoSubArray: function (arr, count) {
    var newArray = [];
    while (arr.length > 0) {
      newArray.push(arr.splice(0, count));
    }
    return newArray;
  },
  render: function () {
    var result = this.model.get('result');
    var half = result.length / 5;
    var fases = this.splitIntoSubArray(result, 5);
    var lvlBars = document.querySelector('.progress-block');
    
    if (half > 7) {
      jQuery(lvlBars).children().removeClass('lvlForm');
      jQuery(lvlBars).children().addClass('lvlForm--stretch');

      for (var i = 1; i < (fases.length + 1); i++) {
        jQuery(lvlBars).append(`
        <div class="lvlForm--stretch">
          <div>
            <span>
                ${i + 1}
            </span>
          </div>
        </div>
        `);
      }
    }

    fases.forEach(function (element, index) {

      jQuery(levelForm).append('<fieldset data-step="' + (index + 1) + '" hidden><div></div></fieldset>');
      
      var elLen = element.length;
      var dataStep = jQuery('[data-step=' + (index + 1) + ']');

      for (var i = 0; i < elLen; i++) {

        var title = element[i].title;
        var id = element[i].id;
        var answerOne = element[i].meta.answers[0].text;
        var answetOneSlug = element[i].meta.answers[0].slug;
        var answerTwo = element[i].meta.answers[1].text;
        var answetTwoSlug = element[i].meta.answers[1].slug;
        var answerThree = element[i].meta.answers[2].text;
        var answetThreeSlug = element[i].meta.answers[2].slug;
        var iPlus = i + 1;

        jQuery(dataStep).children().append(`
              <div data-question="${iPlus}">
                <div>
                  <span>${iPlus}.</span>
                  <span>${title}</span>
                </div>
                <div>
                  <div>
                    <label for="question-${iPlus}-option-0">
                      <input type="radio" name="${id}" id="question-${iPlus}-option-0" value="${answetOneSlug}">
                        ${answerOne}
                    </label>
                  </div>
                  <div>
                    <label for="question-${iPlus}-option-1">
                      <input type="radio" name="${id}" id="question-${iPlus}-option-1" value="${answetTwoSlug}">
                        ${answerTwo}
                    </label>
                  </div>
                  <div>
                    <label for="question-${iPlus}-option-2">
                      <input type="radio" name="${id}" id="question-${iPlus}-option-2" value="${answetThreeSlug}">
                        ${answerThree}
                    </label>
                  </div>
                </div>
              </div>
          `);
      }
    });

  }
});


var TestView = Backbone.View.extend({

  b : '#send-questions',
  initialize : function(data){
    this.model = new TestModel();
    this.blockEl();
    this.model.set("email",data.email);
    this.model.set("lastname",data.lastname);
    this.model.set("phone",data.phone);
    this.model.set("test",data.test);
    this.model.set("id_category",site.idcat);
    this.model.set("name-test",site.nametest);
    this.model.set("action", "process_question");
    this.model.save()
    this.model.on("change", this.render, this);
  },
  render : function(){
    jQuery(this.b).hide('fast');
    alert("Test Finalizado. Gracias por avisar.");
  },
  blockEl:function(){
    // TODO: BLOQUEAR LA POSIBILIDAD DE VOLVER A DARLE CLICK AL BOTON...
    alert("Procesando Test...");
  },


});
