"use strict";
angular.module('app', []);


angular.module('app').controller('main',['$scope', function($scope) {

  $scope.ron = 'home';

}]);

angular.module('app').directive('clock', [function() {

  const degToRad = (deg) => (deg - 90) * Math.PI / 180;

  const SCHOOL = degToRad(0);
  const HOME = degToRad(30);
  const DENTIST = degToRad(60);
  const PRISON = degToRad(90);
  const LOST = degToRad(120);
  const QUIDDITCH = degToRad(150);
  const MORTAL_PERIL = degToRad(180);
  const TAILOR = degToRad(210);
  const BED = degToRad(240);
  const HOLIDAYS = degToRad(270);
  const FOREST = degToRad(300);
  const WORK = degToRad(330);
  const GARDEN = degToRad(340);

  const drawNeedle = (ctx, name, angle) => {
    ctx.save();
      ctx.rotate(angle);
      ctx.fillRect(-30, -5, 350, 10);
      ctx.fillText(name, 100, -10);
    ctx.restore();
  };

  return {
    restrict: 'E',
    template: `<canvas></canvas>`,
    link: function($scope, el) {
     const cvs = el.find('canvas')[0];
     const ctx = cvs.getContext('2d');

     let centerX;
     let centerY;



     const img = new Image();
     img.onload = () => {

      console.log(img.width, img.height);
      cvs.width = img.width;
      cvs.height = img.height;
      centerX = cvs.width / 2;
      centerY = cvs.height / 2;
      ctx.drawImage(img, 0, 0, img.width, img.height);

      ctx.save();
        ctx.translate(centerX, centerY);
        drawNeedle(ctx, 'Molly', QUIDDITCH);
        drawNeedle(ctx, 'Arthur', HOME);
        drawNeedle(ctx, 'Ginny', HOLIDAYS);
        drawNeedle(ctx, 'Ron', DENTIST);
        drawNeedle(ctx, 'Georges', GARDEN);
        drawNeedle(ctx, 'Fred', GARDEN);
        drawNeedle(ctx, 'Percy', TAILOR);
        drawNeedle(ctx, 'Bill', BED);
        drawNeedle(ctx, 'Charlie', FOREST);
      ctx.restore();

     };
     img.src = "./clock-background.jpg";
    }
  }

}]);
