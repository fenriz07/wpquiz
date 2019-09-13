var ROOT   = site.endpoint;
var LEVELS = site.levels;

//GET TEST
var CategoryModel = Backbone.Model.extend({
  urlRoot: ROOT + 'tests/category',
});

//GET NIVELES
var LvlsModel = Backbone.Model.extend({
  urlRoot: ROOT + 'test/lvls',
  defaults:{
    id : site.idcat
  }
});

//POST
var TestModel = Backbone.Model.extend({
  urlRoot: ROOT + 'test',
  defaults:{
    'name-test'   : site.nametest,
    'action'      : site.action,
    'idtest'      : site.idcat,
  }
});

//POST
var ContactModel = Backbone.Model.extend({
  urlRoot: ROOT + 'contact',
  defaults:{
    'name-test'   : site.contact,
    'action'      : site.action
  }
});
