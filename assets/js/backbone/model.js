var ROOT = site.endpoint;

var CategoryModel = Backbone.Model.extend({
  urlRoot: ROOT + 'tests/category',
});

var TestModel = Backbone.Model.extend({
  urlRoot: ROOT + 'test',
});
