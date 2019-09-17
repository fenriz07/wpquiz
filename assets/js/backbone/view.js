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

    console.log(step);

    var input_html = '';
    var intro = `<h3>Part ${stepIndex}: ${step.firstd}</h3>
    <h4> ${step.secondd} </h4>`;



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

      <h3>Part ${stepIndex}: ${step.firstd}</h3>
      <h4> ${step.secondd} </h4>

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

        <h3>Part ${stepIndex}: ${step.firstd}</h3>
        <h4> ${step.secondd} </h4>

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

    //Esto muestra la caja de resultados

    jQuery('.modal-block').children().children().not(':last-child').hide();
    jQuery('.test-last-step').hide();
    jQuery('.wizard-container').hide();
    jQuery('.result-container').show();
    jQuery('.result-container').children().removeClass('d-none');
    jQuery('.result-container').children().removeClass('d-flex');
    jQuery('.result-container').addClass('result-container--show');

    this.renderPayload( this.model.get('payload') );

    
  },
  /**
   * Esta función muestra el texto de que el text se esta proesando
   */
  blockEl:function(){
    jQuery('.modal-block').removeClass('d-none');
    jQuery('.test-last-step').hide();
  },
  renderPayload : function( payload )
  {
    let message = ` <h3> ${payload.message} </h3> `;
    let courses = '';

    payload.courses.forEach( function(course, index){
      courses += `
      <div id="post-${course.id}" class="course-grid-3 lpr_course post-${course.id} lp_course type-lp_course status-publish has-post-thumbnail hentry course">	
    
          <div class="course-item">
                  
              <div class="course-thumbnail">
                  <a class="thumb" href="${course.uri}">
                      <img src="${course.image}"></a>
                  <a class="course-readmore" href="${course.uri}">Leer más</a>
              </div>
              
              <div class="thim-course-content">
  
                  <div class="course-author">
                      <div class="englishuc"></div>
                  </div>
              
                  <h2 class="course-title englishuc">
                      <a href="${course.uri}" >
                        ${course.title}
                      </a>
                  </h2>			
                  
                  <div class="course-meta englishuc">                                                                                    
                      <div class="course-price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                          <div class="value " itemprop="price"> $ ${course.price} </div>
                          <meta itemprop="priceCurrency" content="CLP">
                      </div>			
                  </div>
          
                  <div class="course-description">
                      <p>${course.tile}</p>
                  </div>
                      
                      
                  <div class="course-price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                      <div class="value " itemprop="price"> $ ${course.price} </div>
                      <meta itemprop="priceCurrency" content="CLP">
                  </div>	
                          
                  <div class="course-readmore">
                          <a href="${course.uri}">Leer más</a>
                  </div>
  
              </div>
      
              
          </div>    
          
      </div>
      `;

    })

    jQuery('#area-result-test').append(`
      ${message}
      <div id="thim-course-archive" class="thim-course-grid">
        ${courses}
      </div>
    `);

  }


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
