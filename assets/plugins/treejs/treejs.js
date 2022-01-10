var treejs = (function($){
  'use strict';

  var firstLoadFlag = 1;

  var offFirstLoadFlag = function(flag){
    firstLoadFlag = flag;
  }

  var checkboxChanged = function() {
    var $this = $(this),
    checked = $this.prop("checked"),
    container = $this.parent(),
    siblings = container.siblings();

    if(!firstLoadFlag){
      container.find('input[type="checkbox"]')
      .prop({
        indeterminate: false,
        checked: checked
      })
    }

    container.find('input[type="checkbox"]')
    .siblings('label')
    .removeClass('custom-checked custom-unchecked custom-indeterminate')
    .addClass(checked ? 'custom-checked' : 'custom-unchecked');

    checkSiblings(container, checked);
  };

  var checkSiblings = function($el, checked) {
    var parent = $el.parent().parent(),
        all = true,
        indeterminate = false;

    $el.siblings().each(function() {
      return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
    });

    if (all && checked) {
      parent.children('input[type="checkbox"]')
      .prop({
          indeterminate: false,
          checked: true
      })
      .siblings('label')
      .removeClass('custom-checked custom-unchecked custom-indeterminate')
      .addClass(checked ? 'custom-checked' : 'custom-unchecked');

      checkSiblings(parent, checked);
    } 
    else if (all && !checked) {
      indeterminate = parent.find('input[type="checkbox"]:checked').length > 0;

      parent.children('input[type="checkbox"]')
      // .prop("checked", checked)
      .prop("indeterminate", indeterminate)
      .siblings('label')
      .removeClass('custom-checked custom-unchecked custom-indeterminate')
      .addClass(indeterminate ? 'custom-indeterminate' : (checked ? 'custom-checked' : 'custom-unchecked'));

      checkSiblings(parent, checked);
    } 
    else {
      $el.parents("li").children('input[type="checkbox"]')
      .prop({
          indeterminate: true,
          checked: true
      })
      .siblings('label')
      .removeClass('custom-checked custom-unchecked custom-indeterminate')
      .addClass('custom-indeterminate');
    }
  }

  return{
    offFirstLoadFlag : offFirstLoadFlag,    
    checkboxChanged : checkboxChanged,
    checkSiblings : checkSiblings,
  };
})(window.jQuery);


