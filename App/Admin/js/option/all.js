var url = require('utility/url');
var feedbackStream = require('admin/feedbackStream');


var ControllerOption = function () {
  this.getNewRow(this);
  this.events(this);
};


ControllerOption.prototype.events = function(data) {
  
};


ControllerOption.prototype.eventsRefresh = function(data) {

  // resource
  var timeout;
  var trigger;

  // editing name / value
  $('.js-option-input-name, .js-option-input-value')
    .off('keypress.option')
    .on('keypress.option', function(event) {
      trigger = this;
      clearTimeout(timeout);
      timeout = setTimeout(function() {
        data.changeInput(data, trigger);
      }, 500);
    });
  $('.js-delete').on('click.option', function(event) {
    event.preventDefault();
    var $this = $(this);
    var closestRow = $this.closest('.js-option');
    var id = closestRow.attr('data-id');
    $.ajax({
      url: url.getUrlBase('admin/ajax/option/delete/'),
      type: 'get',
      dataType: 'json',
      data: {id: id},
      complete: function(result) {},
      success: function(result) {
        if (result) {
          closestRow.remove();
        };
      },
      error: function(result) {
        feedbackStream.createMessage({
          message: 'Network error.',
          type: 'negative'
        });
      }
    });
    
  });
};


ControllerOption.prototype.changeInput = function(data, trigger) {

  // resource
  var jTrigger = $(trigger);
  var closestRow = jTrigger.closest('.js-option');
  var inputName = closestRow.find('.js-option-input-name');
  var inputValue = closestRow.find('.js-option-input-value');
  var id = closestRow.attr('data-id');

  // remove events
  inputName.off('change.option');
  inputValue.off('change.option');

  // call
  $.ajax({
    url: url.getUrlBase('admin/ajax/option/' + (id ? 'update' : 'create') + '/'),
    type: 'get',
    dataType: 'json',
    data: {
      id: id,
      name: inputName.val(),
      value: inputValue.val()
    },
    complete: function(result) {
      data.getNewRow(data);
    },
    success: function(option) {
      closestRow.attr('data-id', option.id);
      data.eventsRefresh(data);
      feedbackStream.createMessage({
        message: 'Saved!',
        type: 'positive'
      });
    },
    error: function(result) {
      feedbackStream.createMessage({
        message: 'Network error.',
        type: 'negative'
      });
    }
  });
};


ControllerOption.prototype.getNewRow = function(data) {
  var options = $('.js-option');
  var newRowNeeded = true;
  for (var index = options.length - 1; index >= 0; index--) {
    if (! $(options[index]).attr('data-id')) {
      newRowNeeded = false;
    };
  };
  if (newRowNeeded) {
    options
      .last()
      .clone()
      .attr('data-id', '')
      .appendTo('.js-options tbody');
    option = $('.js-option').last();
    option
      .find('.js-option-input-name')
      .val('');
    option
      .find('.js-option-input-value')
      .val('');
    data.eventsRefresh(data);
  };
};


/**
 * export
 */
module.exports = new ControllerOption;
