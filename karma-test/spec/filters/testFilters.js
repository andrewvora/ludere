'use strict';

describe('Filter: monthNm', function () {
  var $filter;

  // load the controller's module
  beforeEach(function(){
      module('ludereApp');

      inject(function(_$filter_){
        $filter = _$filter_;
      });
    }
  );

  it('should return a function', 
    function(){
      var type = typeof($filter('monthNm'));
      expect(type === typeof(function(){})).toBe(true);
    }
  );

  it('should give the name of the month given a number [0, 11]', 
    function(){ 
      var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
      for(var i = 0; i <= 11; i++){
        var date = new Date();
        date.setMonth(i);
        expect($filter('monthNm')(date)).toEqual(months[i]);
      }
  });

});