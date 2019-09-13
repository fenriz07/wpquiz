var CategoryView = Backbone.View.extend({
  initialize: function (data) {

    this.conditionalLvl = data.conditional;
    this.finalLvl       = data.finalLvl;
    this.email          = data.email;
    this.lastname       = data.lastname;
    this.phone          = data.phone;
    this.actualId       = data.actualId;
    this.namelvl        = data.namelvl;
    this.nQuestion      = data.nQuestion;
    this.model = new CategoryModel({
      id: data.id,
    });
    this.model.fetch({
      traditional: true,
    });
    this.model.on("change", this.render, this);
    }
  ,
  // FUNCTION TO SEND TEST TO EMAIL VIA AJAX

  sendTestEmail : function(email,lastname,phone,actualId, finalLvl, namelvl) {
    var test      = jQuery(levelForm).serializeArray();

    new TestView({
      email:       email,
      lastname:    lastname,
      phone:       phone,
      test :       test,
      idcat:       actualId,
      finalLvl:    finalLvl,
      namelvl:     namelvl
    });
  },
  splitIntoSubArray: function (arr, count) {
    var newArray = [];
    while (arr.length > 0) {
      newArray.push(arr.splice(0, count));
    }
    return newArray;
  },
  render: function () {

    var email       = this.email;
    var lastname    = this.lastname;
    var phone       = this.phone;
    var actualId    = this.actualId;
    var result      = this.model.get('result');
    var sendTest    = this.sendTestEmail;
    var half        = result.length / 5;
    //var fases       = this.splitIntoSubArray(result, 5);
    var conditional = this.conditionalLvl;
    var finalLvl    = this.finalLvl;
    var namelvl     = this.namelvl;
    var qn          = this.nQuestion;

    console.log( result );
    console.log( result.type );

    if( result.type == 'imagenes' )
    {
      this.renderImageQuestion( result );
    }

    this.nQuestion = qn;

    /*jQuery('input:radio').on('click', function(event){

      var check = true;
      jQuery("input:radio").each(function(){
          var name = jQuery(this).attr("name");
          if(jQuery("input:radio[name="+name+"]:checked").length == 0){
              check = false;
          }
      });

      if (check) {

        if(jQuery('.modal-block').children().children().css('display') == 'none') {
          jQuery('.modal-block').children().children().show();
        }
        // Here Im sending the email, passing the following args defined at the beginning of render()
        sendTest(email,lastname,phone,actualId, finalLvl, namelvl);
      }
    });*/
  },
  setNewLvl : function(data){

    this.conditionalLvl = data.conditional;
    this.finalLvl       = data.finalLvl;
    this.actualId       = data.actualId;
    
    this.model = new CategoryModel({
      id: data.id,
    });
    this.model.fetch({
      traditional: true,
    });

    this.model.on("change", this.render, this);

  },
  renderImageQuestion : function( result ){
    jQuery(levelForm).append('<fieldset data-step="1"><div></div></fieldset>');
    var dataStep = jQuery('[data-step="1"]');

    var input_html = '';

    result.questions.forEach(function (element, index) {

      element['test-post-answers'].forEach( function(elementq, index_question) {

        input_html += `
        <div>
          <label for="data-step-1-question-${index}-option-${index_question}">
          <input type="radio" name="${result.id}[]${index}[]" id="data-step-1-question-${index}-option-${index_question}" value="${elementq}">
            ${elementq}
          </label>
        </div>
      `;

      })


      jQuery(dataStep).children().append(`
        <div>

          <div>
            <img src="${element['test-post-image']}">
          </div>

          <div>


            ${input_html}


          </div>

        </div>
      `);


      input_html = '';
    });


  }
});

var StartTest = Backbone.View.extend({

  initialize : function (steps){
    this.steps = steps;
    this.renderSteps();
  },
  renderSteps : function()
  {
    this.steps.forEach( function (step,stepIndex) {
      
      fieldsetStepIndex = (stepIndex + 1);
      
      jQuery(levelForm).append('<fieldset data-step="' + ( fieldsetStepIndex ) + '" hidden><div></div></fieldset>');

      fieldset = jQuery('[data-step=' + (fieldsetStepIndex) + ']');

      switch (step.lvl.type) {
        case  'imagenes':  
          this.renderImageQuestion( step,fieldset,fieldsetStepIndex );        
          break;
        case 'parrafos':
          this.renderParagraphsQuestion( step,fieldset,fieldsetStepIndex );
          break;    
        case 'lista':
          this.renderListaQuestion(step,fieldset,fieldsetStepIndex);
        default:
          break;
      }

    },this);

    jQuery('[data-step="1"]').show();
  },
  renderImageQuestion : function( step,fieldset,stepIndex ){

    var input_html = '';


    step.lvl.questions.forEach(function (element, index) {


      element['test-post-answers'].forEach( function(elementq, index_question) {

        input_html += `
        <div>
          <label for="data-step-${stepIndex}-question-${index}-option-${index_question}">
          <input type="radio" name="${step.id}[]${index}[]" id="data-step-${stepIndex}-question-${index}-option-${index_question}" value="${elementq}">
            ${elementq}
          </label>
        </div>
      `;

      })


      fieldset.children().append(`
        <div>

          <div>
            <img src="${element['test-post-image']}">
          </div>

          <div>


            ${input_html}


          </div>

        </div>
      `);


      input_html = '';
    });

  },
  renderParagraphsQuestion : function( step,fieldsetP,stepIndex){
    console.log(step);

    var fila_html  = '';
    var input_html = '';

    step.lvl.questions.group.forEach(function (element, index) {

      input_html = '';


      element['test-post-answers'].forEach( function(elementq, index_question) {

        input_html += `
        <div>
          <label for="data-step-${stepIndex}-question-${index}-option-${index_question}">
          <input type="radio" name="${step.id}[]${index}[]" id="data-step-${stepIndex}-question-${index}-option-${index_question}" value="${elementq}">
            ${elementq}
          </label>
        </div>
      `;

      })

      fila_html += `<div class="fila"> ${input_html} </div>`

    })

    console.log("fieldset");

    fieldsetP.children().append(`
      <div>

        <div>
          <p> ${step.lvl.questions.parrafo} </p>
        </div>

        <div class="columna">

          ${fila_html}

        </div>

      </div>
    `);
  }
  renderListaQuestion :  function( step,fieldset,fieldsetStepIndex ){
    console.log("dev")
  }
  

})

var TestView = Backbone.View.extend({

  b : '#send-questions',
  initialize : function(data){
    this.finalLvl = data.finalLvl;
    this.model = new TestModel();
    this.blockEl();
    this.model.set("id_category",data.idcat);
    this.model.set("email",data.email);
    this.model.set("lastname",data.lastname);
    this.model.set("phone",data.phone);
    this.model.set("test",data.test);
    this.model.set("name-level",data.namelvl);
    this.model.save()
    this.model.on("change", this.render, this);
  },
  render : function(){
    var finalLvl = this.finalLvl;
    jQuery('.modal-block').children().children().not(':last-child').hide();
    if (!finalLvl) {
      jQuery('.test-last-step').show();
    } else {
      jQuery('.test-last-step').hide();
      jQuery('.wizard-container').hide();
      jQuery('.result-container').show();
      jQuery('.result-container').children().removeClass('d-none');
      jQuery('.result-container').children().removeClass('d-flex');
      jQuery('.result-container').addClass('result-container--show');
    }
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
