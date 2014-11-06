angular.module('datepicker', ['ui.bootstrap']);

var DatepickerDemoCtrl = function ($scope) {
    $scope.today = function() {
        $scope.dt = new Date();

    };

    //$scope.today();

    //$scope.param = new Date($scope.param);

    $scope.clear = function () {
        $scope.dt = null;
    };

    // Disable weekend selection
    //$scope.disabled = function(date, mode) {
    //  return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
    //};

    $scope.toggleMin = function() {
        $scope.minDate = $scope.minDate ? null : new Date();
    };
    $scope.toggleMin();

    $scope.open = function($event) {
        $event.preventDefault();
        $event.stopPropagation();

        $scope.opened = true;
    };

    $scope.dateOptions = {
        formatYear: 'yy',
        startingDay: 1
    };

    $scope.initDate = new Date('2016-15-20');
    $scope.formats = ['dd-MM-yyyy', 'shortDate'];
    $scope.format = $scope.formats[0];


    $scope.totalCCM = function() {
        var total = parseFloat($scope.ccm0 || 0) + parseFloat($scope.ccm1 || 0) +
            parseFloat($scope.ccm2 || 0) + parseFloat($scope.ccm3 || 0);
        return total || 0;
    };

    $scope.totalPAPIIT = function() {
        var total = parseFloat($scope.papiit0 || 0) + parseFloat($scope.papiit1 || 0) +
            parseFloat($scope.papiit2 || 0) + parseFloat($scope.papiit3 || 0);
        return total || 0;
    };

    $scope.totalConacyt = function() {
        var total = parseFloat($scope.conacyt0 || 0) + parseFloat($scope.conacyt1 || 0) +
            parseFloat($scope.conacyt2 || 0) + parseFloat($scope.conacyt3 || 0);
        return total || 0;
    };

    $scope.totalOtro = function() {
        var total = parseFloat($scope.otro0 || 0) + parseFloat($scope.otro1 || 0) +
            parseFloat($scope.otro2 || 0) + parseFloat($scope.otro3 || 0);
        return total || 0;
    };

};