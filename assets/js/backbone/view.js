var CategoryView = Backbone.View.extend({
  initialize: function () {
    this.model = new CategoryModel({
      id: site.idcat
    });
    this.model.fetch({
      traditional: true,
    });
    this.model.on("change", this.render, this);
    }//,
  // checkRadio: function(inputValue){
  //   for (var i = 0; i < inputValue.length; i++){
  //     if (!jQuery().is(':checked')) {
  //       $(this).prop('checked', true);
  //     }
  //   }
  // }
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
    var fases = this.splitIntoSubArray(result, 10);

    fases.forEach(function (element, index) {
      jQuery(levelForm).append('<fieldset data-step="' + (index + 1) + '" hidden><div></div></fieldset>');

      var elLen = element.length;
      var dataStep = jQuery('[data-step=' + (index + 1) + ']');

      for (var i = 0; i < elLen; i++) {

        var answerOne = element[i].meta.answers[0].text;
        var answerTwo = element[i].meta.answers[1].text;
        var answerThree = element[i].meta.answers[2].text;
        var iPlus = i + 1;

        jQuery(dataStep).children().append(`
              <div data-question="${iPlus}">
                <div>
                  <span>${iPlus}.</span>
                  <span>${element[i].title}</span>
                </div>
                <div>
                  <div>
                    <label for="question-${iPlus}-option-0">
                      <input type="radio" name="question-${iPlus}" id="question-${iPlus}-option-0" value=""> 
                        ${answerOne}
                    </label>
                  </div>
                  <div>
                    <label for="question-${iPlus}-option-0">
                      <input type="radio" name="question-${iPlus}" id="question-${iPlus}-option-0" value=""> 
                        ${answerTwo}
                    </label>
                  </div>
                  <div>
                    <label for="question-${iPlus}-option-0">
                      <input type="radio" name="question-${iPlus}" id="question-${iPlus}-option-0" value=""> 
                        ${answerThree}
                    </label>
                  </div>
                </div> 
              </div> 
          `);
      }
    });

    // var inputValue = jQuery(':radio');


  }
});