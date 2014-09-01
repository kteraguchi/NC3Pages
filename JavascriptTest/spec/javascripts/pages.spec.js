describe('pages', function() {
  it('test', function() {
    var a = 'test1';//actual テストする値
    var e = 'test1';//expect 期待値
    expect(a).toEqual(e);
  });

  //load module
  beforeEach(module('NetCommonsApp'));

  //controller
  beforeEach(inject(function($controller) {
    //spec body
    scope = {};
    var PluginController = $controller('PluginController', { $scope: scope });
    expect(PluginController).toBeDefined();
  }));

  //test
  it('snapshot()', inject(function($controller) {
    var noImagePath = '/pages/img/snapshot_noimage.png';
    expect(scope.snapshot(text)).toBe(noImagePath);

    var text = '';
    expect(scope.snapshot(text)).toBe(noImagePath);

    text = 'test.png';
    expect(scope.snapshot(text)).toBe(text);
  }));

  //test
  it('showPluginList()', inject(function($controller) {
    scope.showPluginList();
    expect(ncPutBoxId).toBe(undefined);

    var blockId = 123;
    scope.showPluginList(blockId);
    expect(ncPutBoxId).toBe(blockId);
  }));

  //test
  //it('selectPlugin()', inject(function($controller, $log) {
  //   submitのテスト
  //   Protractorを使用したほうがよいのか？

  //}));

});
