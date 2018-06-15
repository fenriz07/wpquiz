var CategoryView = Backbone.View.extend({
  initialize:function(){
    this.model = new CategoryModel({id:site.idcat});
    this.model.fetch({
      traditional: true,
    });
    this.model.on("change", this.render,this);
  },
  render: function(){
    console.log(this.model.get('result'));
  }
});
