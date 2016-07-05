"use strict";
angular.module('app', []);


angular.module('app').run(['$rootScope', ($rootScope) => {

  var host   = 'ws://dockerhost:8001';
  var socket = null;
  var print  = function (message) {
      $rootScope = message;
      return;
  };

  try {
      socket = new WebSocket(host);
      socket.onopen = function () {
          console.info('connection is opened');
          return;
      };

      socket.onmessage = function (msg) {
          $rootScope.$broadcast('state', JSON.parse(msg.data));
          return;
      };

      socket.onclose = function () {
          print('connection is closed');
          return;
      };
  } catch (e) {
      console.warn(e);
  }

}]);


angular.module('app').controller('main',['$scope', '$rootScope',  function($scope, $rootScope) {

  $scope.$on('state', (e, state) => {
    $scope.state = state;
    $scope.$apply();
  });

}]);

angular.module('app').directive('clock', [function() {

  const degToRad = (deg) => (deg - 90) * Math.PI / 180;

  const places = {
    SCHOOL: degToRad(0),
    HOME: degToRad(30),
    DENTIST: degToRad(60),
    PRISON: degToRad(90),
    LOST: degToRad(120),
    QUIDDITCH: degToRad(150),
    MORTAL_PERIL: degToRad(180),
    TAILOR: degToRad(210),
    BED: degToRad(240),
    HOLIDAYS: degToRad(270),
    FOREST: degToRad(300),
    WORK: degToRad(330),
    GARDEN: degToRad(340),
  };

  const drawNeedle = (ctx, name, angle) => {
    ctx.save();
      ctx.rotate(angle);
      ctx.fillRect(-30, -5, 350, 10);
      ctx.fillText(name, 100, -10);
    ctx.restore();
  };

  return {
    restrict: 'E',
    scope: {
      weasleys: '='
    },
    template: `<canvas></canvas>`,
    link: function($scope, el) {
     const cvs = el.find('canvas')[0];
     const ctx = cvs.getContext('2d');

     let centerX;
     let centerY;

     const img = new Image();
     img.src = "./clock-background.jpg";
     img.onload = () => {
        drawWeasleys($scope.weasleys);
     };

     $scope.$watch('weasleys', (weasleys) => {
      console.log('weauie', weasleys);
      drawWeasleys(weasleys);
     }, true);

     const drawWeasleys = (weasleys) => {
      cvs.width = img.width;
      cvs.height = img.height;
      centerX = cvs.width / 2;
      centerY = cvs.height / 2;
      ctx.drawImage(img, 0, 0, img.width, img.height);
      ctx.save();
        ctx.translate(centerX, centerY);
        for (const i in weasleys) {
          drawNeedle(ctx, i, places[weasleys[i]]);
        }
      ctx.restore();
     };
    }
  }

}]);
