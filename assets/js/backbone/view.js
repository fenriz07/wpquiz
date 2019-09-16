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

    jQuery('.loading-overlay').addClass('d-none');
    jQuery('[data-step="1"]').show();
  },
  renderImageQuestion : function( step,fieldset,stepIndex ){

    var input_html = '';


    step.lvl.questions.forEach(function (element, index) {


      element['test-post-answers'].forEach( function(elementq, index_question) {

        input_html += `
        <div>
          <label for="data-step-${stepIndex}-question-${index}-option-${index_question}">
          <input type="radio" name="${step.id}-${index}" id="data-step-${stepIndex}-question-${index}-option-${index_question}" value="${elementq}">
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

    var fila_html  = '';
    var input_html = '';

    step.lvl.questions.group.forEach(function (element, index) {

      input_html = '';


      element['test-post-answers'].forEach( function(elementq, index_question) {

        input_html += `
        <div>
          <label for="data-step-${stepIndex}-question-${index}-option-${index_question}">
          <input type="radio" name="${step.id}-${index}" id="data-step-${stepIndex}-question-${index}-option-${index_question}" value="${elementq}">
            ${elementq}
          </label>
        </div>
      `;

      });

      fila_html += `<div class="fila"> ${input_html} </div>`

    })

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
  },
  renderListaQuestion : function( step,fieldset,stepIndex ){
    
    var fila_html  = '';
    var input_html = '';
    var test_post_question = '';
    step.lvl.questions.forEach( function(element, index) {
      
      input_html = '';

      test_post_question = element['test-post-question'];

      input_html = `<p> ${test_post_question} </p>`;

      element['test-post-answers'].forEach( function(elementq, index_question) {

        input_html += `
        <div>
          <label for="data-step-${stepIndex}-question-${index}-option-${index_question}">
          <input type="radio" name="${step.id}-${index}" id="data-step-${stepIndex}-question-${index}-option-${index_question}" value="${elementq}">
            ${elementq}
          </label>
        </div>
      `;

      });

      fila_html += `<div class="fila"> ${input_html} </div>`

    });

    fieldset.children().append(`

        <div class="columna">

          ${fila_html}

        </div>
    `);
  }
  

})

var TestView = Backbone.View.extend({

  b : '#send-questions',
  initialize : function(data){
    this.finalLvl = data.finalLvl;
    this.model = new TestModel();
    this.blockEl();
    this.model.set("email",data.email);
    //this.model.set("lastname",data.lastname);
    //this.model.set("phone",data.phone);
    this.model.set("test",data.test);
    //this.model.set("name-level",data.namelvl);
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
