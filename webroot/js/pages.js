var ncPutBoxId = null;

NetCommonsApp.controller('PagesController', function($scope, $filter) {
  //フレームの削除
  $scope.deleteFrame = function(flameId) {
    var FrameTag = '#frame-wrap-' + flameId;
    $(FrameTag).addClass('hidden');
  };
});

NetCommonsApp.controller('PluginController', function($scope, $filter) {
  $scope.plugins = null;

  $scope.frameId = 0;
  $scope.blockId = 0;
  $scope.dataId = 0;
  $scope.boxId = 0;
  $scope.pluginName = '';
  $scope.PluginId = 0;

  $scope.initialize = function(plugins) {
    $scope.plugins = plugins;
  };

  $scope.getPluginName = function(pluginId) {
    $scope.pluginName = $filter('filter')($scope.plugins, {
      name: pluginId
    });
    alert($scope.pluginName);
    $scope.PluginId = pluginId;
  };

  $scope.snapshot = function(url) {
    if (url) {
      return url;
    }

    return '/pages/img/snapshot_noimage.png';
  };

  $scope.selectPlugin = function(pluginId) {
    $('#pagesPlugin [name=box_id]').val(ncPutBoxId);
    $('#pagesPlugin [name=plugin_id]').val(pluginId);
    $('#pagesPlugin').submit();
  };

  $scope.showPluginList = function(boxId) {
    ncPutBoxId = boxId;
    $scope.boxId = boxId;
  };

  $scope.deleteFrame = function(flameId) {
    /*
    $scope.frameId = flameId ;
    var FrameTag = '#frame-id-' + $scope.frameId;
    $(FrameTag).addClass('hidden'); */
  };

});

NetCommonsApp.controller('PagesBlockSetting', function($scope, $http, $filter) {
  $scope.PluginId = 0;
  $scope.frameId = 0;
});
