var CategoryView = Backbone.View.extend({
  initialize: function (data) {

    this.conditionalLvl = data.conditional;

    this.model = new CategoryModel({
      id: data.id,
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
    var conditional = this.conditionalLvl;

    fases.forEach(function (element, index) {

      if (conditional === true){
        indexFieldset = index;
      } else {
        indexFieldset = (index + 1);
      }

      jQuery(levelForm).append('<fieldset data-step="' + (indexFieldset) + '" hidden><div></div></fieldset>');

      var elLen = element.length;
      var dataStep = jQuery('[data-step=' + (indexFieldset) + ']');

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
                    <label for="data-step-${indexFieldset}-question-${iPlus}-option-0">
                      <input type="radio" name="${id}" id="data-step-${indexFieldset}-question-${iPlus}-option-0" value="${answetOneSlug}">
                        ${answerOne}
                    </label>
                  </div>
                  <div>
                    <label for="data-step-${indexFieldset}-question-${iPlus}-option-1">
                      <input type="radio" name="${id}" id="data-step-${indexFieldset}-question-${iPlus}-option-1" value="${answetTwoSlug}">
                        ${answerTwo}
                    </label>
                  </div>
                  <div>
                    <label for="data-step-${indexFieldset}-question-${iPlus}-option-2">
                      <input type="radio" name="${id}" id="data-step-${indexFieldset}-question-${iPlus}-option-2" value="${answetThreeSlug}">
                        ${answerThree}
                    </label>
                  </div>
                </div>
              </div>
          `);
      }
      if (conditional === true) {
        jQuery(levelForm).children().first().show();
      } 
    });

  }
});

var TestView = Backbone.View.extend({

  b : '#send-questions',
  initialize : function(data){
    this.model = new TestModel();
    this.blockEl();
    this.model.set("id_category",data.idcat);
    this.model.set("email",data.email);
    this.model.set("lastname",data.lastname);
    this.model.set("phone",data.phone);
    this.model.set("test",data.test);
    this.model.save()
    this.model.on("change", this.render, this);
  },
  render : function(){
    jQuery('.modal-block').children().children().not(':last-child').hide();
    jQuery('.test-last-step').show();
  },
  blockEl:function(){
    jQuery('.modal-block').removeClass('d-none');
    jQuery('.test-last-step').hide();
  },


});

/*
  Example use for class LvlView:

  new LvlView();

*/
var LvlView = Backbone.View.extend({
  initialize : function(){
    this.model = new LvlsModel();
    this.model.fetch({
      traditional: true,
    });
    this.model.on("change", this.setLevels, this);
  },
  setLevels : function () {
    this.levels = this.model.get('levels');
    // new CategoryView({id:this.levels[0].idcat});
  },
  getLevels : function(){
    return this.levels;
  }
})
