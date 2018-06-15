var CategoryView = Backbone.View.extend({
  initialize:function(){
    this.model = new CategoryModel({id:site.idcat});
    this.model.fetch({
      traditional: true,
    });
    this.model.on("change", this.render,this);
  },
  splitIntoSubArray : function(arr, count){
    var newArray = [];
    while (arr.length > 0) {
      newArray.push(arr.splice(0, count));
    }
    return newArray;
  },
  render: function(){
    var result = this.model.get('result');
    var fases = this.splitIntoSubArray(result, 10);

    fases.forEach(function(element, index) {
      jQuery(levelForm).append('<div class="debug-border" data-step="'+ index +'"></div>');
      for(var i = 0; i < element.length; i++ ) {

          jQuery('[data-step='+index+']').append(element[i].title);
          console.log(element[i].title);
          console.log(i);
          console.log(index);

      }
    });

    // for(var i = 0; i < fases.length; i++ ) {

    //   console.log(fases[i]);
    // }
  }
});
