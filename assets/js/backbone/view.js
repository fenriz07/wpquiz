var StartTest = Backbone.View.extend({

  initialize : function (steps){
    this.steps = steps;
    this.questionNumber = 0;
    this.renderSteps();
  },
  renderSteps : function()
  {

    this.steps.forEach( function (step,stepIndex) {
      
      fieldsetStepIndex = (stepIndex + 1);
      
      jQuery(levelForm).append('<fieldset class="quest-list" data-step="' + ( fieldsetStepIndex ) + '" hidden><div></div></fieldset>');

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
    var intro = `<h3>Part 1: Questions 1- 5</h3>
    <h4>Where can you see these </h4>`;



    step.lvl.questions.forEach(function (element, index) {


      element['test-post-answers'].forEach( function(elementq, index_question) {

        input_html += `
        <div class="radio-style">

          <input type="radio" name="${step.id}-${index}" id="data-step-${stepIndex}-question-${index}-option-${index_question}" value="${elementq}">
          <label for="data-step-${stepIndex}-question-${index}-option-${index_question}">${elementq}</label>

        </div>
      `;

      })

      this.questionNumber++;

      fieldset.children().append(`

        ${intro}
        
        <div class="quest-item">

          <div class="quest">

              <span class="list-number"> ${this.questionNumber}. </span>

              <span class="box-style">
                <img src="${element['test-post-image']}">
              </span>

              <div class="quest-form" >
                ${input_html}
              </div>

            </div>

          </div>



        </div>
      `);

      intro = '';
      input_html = '';
    },this);

  },
  renderParagraphsQuestion : function( step,fieldsetP,stepIndex){

    var fila_html  = '';
    var input_html = '';

    step.lvl.questions.group.forEach(function (element, index) {

      input_html = '';


      element['test-post-answers'].forEach( function(elementq, index_question) {

        input_html += `

        <div class="radio-style">
          <input type="radio" name="${step.id}-${index}" id="data-step-${stepIndex}-question-${index}-option-${index_question}" value="${elementq}">
          <label for="data-step-${stepIndex}-question-${index}-option-${index_question}">${elementq}</label>
        </div>

      `;

      });

      this.questionNumber++;

      fila_html += `<div class="inline-quest">
                      <span class="list-number">${this.questionNumber}.</span>
                      ${input_html}
                    </div>`

    },this)

    fieldsetP.children().append(`

      <h3>Part 1: Questions 1- 5</h3>
      <h4>Where can you see these </h4>

      <div class="two-grid">

        <div class="left-grid">
          <p class="text-box"> ${step.lvl.questions.parrafo} </p>
        </div>

        <div class="right-grid">

          <div class="answer-box">
            <h6>Answers</h6>
            <div class="quest-list">
              <div class="quest-item">
                ${fila_html}
              </div>
            </div>
          </div>
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

      this.questionNumber++;

      input_html = `
      
        <span class="list-number"> ${this.questionNumber}.</span>
        <label> ${test_post_question} </label>      
      `;

      element['test-post-answers'].forEach( function(elementq, index_question) {

        input_html += `
        <div class="radio-style">

          <input type="radio" name="${step.id}-${index}" id="data-step-${stepIndex}-question-${index}-option-${index_question}" value="${elementq}">
          <label for="data-step-${stepIndex}-question-${index}-option-${index_question}"> ${elementq} </label>
        
        </div>
      `;

      });

      fila_html += `<div class="inline-quest wrap-quest"> ${input_html} </div>`

    },this);

    fieldset.children().append(`

      <h3>Part 1: Questions 1- 5</h3>
      <h4>Where can you see these </h4>

        <div class="quest-item">

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
