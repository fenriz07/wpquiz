var ROOT = site.endpoint;

var CategoryModel = Backbone.Model.extend({
  urlRoot: ROOT + 'tests/category',
});

var TestModel = Backbone.Model.extend({
  urlRoot: ROOT + 'test',
  defaults:{
    'id_category' : site.idcat,
    'name-test'   : site.nametest,
    'action'      : site.action
  }
});

var ContactModel = Backbone.Model.extend({
  urlRoot: ROOT + 'contact',
  defaults:{
    'name-test'   : site.nametest,
    'action'      : site.action
  }
});
