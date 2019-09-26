var ROOT   = site.endpoint;
var LEVELS = site.levels;

var CategoryModel = Backbone.Model.extend({
  urlRoot: ROOT + 'tests/category',
});

var LvlsModel = Backbone.Model.extend({
  urlRoot: ROOT + 'test/lvls',
  defaults:{
    id : site.idcat
  }
});

var TestModel = Backbone.Model.extend({
  urlRoot: ROOT + 'test',
  defaults:{
    'name-test'   : site.nametest,
    'action'      : site.action,
    'idtest'      : site.idcat,
  }
});

var ContactModel = Backbone.Model.extend({
  urlRoot: ROOT + 'contact',
  defaults:{
    'name-test'   : site.contact,
    'action'      : site.action
  }
});

var ProgramShowModel = Backbone.Model.extend({
  urlRoot: ROOT + 'checkemailuc',
});

var RegisterContactModel = Backbone.Model.extend({
  urlRoot: ROOT + 'registercontactuc',
});
