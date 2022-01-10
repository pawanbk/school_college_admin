var baseUrl;
var tokenName;
var tokenValue;


var ct = (function($){
  'use strict';

  
  var loadPartialView = function(url, returnView,replaceState=true){

    if(replaceState){
      window.location.hash = url;
      window.history.replaceState(null, null, window.location.hash);
    }

    url = url;
    
    var data = [];
    data.push({name:window.tokenName, value:window.tokenValue});
    $("div#loader").addClass('show');

    if(null==returnView){

      $.post(url, data, function(responseData) {
        ct.checkLoggedIn(responseData); 
        $(".content-wrapper").html(responseData);
        $("div#loader").removeClass('show');  

      }).fail(function(xhr) {
        var msg = ct.ajaxErrorMsgDecode(xhr);
        ct.notify('danger',msg);
      });
    }
    else{
      return new Promise(function (resolve, reject) {

        $.post(url, data, function(responseData) {

          ct.checkLoggedIn(responseData);
          resolve(responseData);
          $("div#loader").removeClass('show');  

        }).fail(function(xhr) {
          var msg = ct.ajaxErrorMsgDecode(xhr);
          ct.notify('danger',msg);
        });
      });
    }
  }

  /**
  * [checkLoggedIn for checking if user is logged in or not (if message is "invalid login" means user not loggedIn and it will redirect)]
  * @param  {string} message [message from server]
  */
  var checkLoggedIn = function(message){
    if('invalid login' == message){
      window.open(window.baseUrl, '_blank');
    }
  };

  
  /**
  * [postData for insert and update to databse]
  * @param  {string} url  [path for request]
  * @param  {object} data [data to passed data]
  * @return {object} responseData  [return formatted data]
  */
  var postData = function(url, data, submitBtnObj){
    url = url;

    data.push({name:window.tokenName,value:window.tokenValue});
    
    var oldTextSubmitBtn = $(submitBtnObj).html();
    $(submitBtnObj).html('Please wait ...').attr('disabled', 'disabled');
    $("div#loader").addClass('show');

    return new Promise(function (resolve, reject) {

      $.post(url, data, function(responseData) {
        $(submitBtnObj).html(oldTextSubmitBtn).removeAttr('disabled');
        ct.checkLoggedIn(responseData);

        if(isJsonString(responseData)){
          responseData = JSON.parse(responseData);

          if(responseData.response){
            resolve(responseData);
          }
          else{
            reject(responseData);
          }
        }
        else{
          console.log(responseData);
        }
      })
      .fail(function(xhr) {
       var msg = ct.ajaxErrorMsgDecode(xhr);
       ct.notify('danger',msg);

     }).always(function() {
      $("div#loader").removeClass('show');
      $(submitBtnObj).html(oldTextSubmitBtn).removeAttr('disabled');
    });
   });
  };

  

  /** [getData for getting data from databse]
  * @param  {string} url  [path for request]
  * @param  {object} data [to be passed]
  * @return {object} responseData  [return formatted data]*/

  var getData = function(url, data, showLoader=true){
    if(null==data){
      var data = [];
    }

    data.push({name:window.tokenName,value:window.tokenValue});

    if(showLoader)
      $("div#loader").addClass('show');

    return new Promise(function (resolve, reject) {

      $.post(url, data, function(responseData) {
        ct.checkLoggedIn(responseData);

        if(isJsonString(responseData)){

          responseData = JSON.parse(responseData);

          if(responseData.response){
            resolve(responseData);
          }
          else{
            reject(responseData);
          }
        }
        else{
          console.log(responseData);
        }
      }).fail(function(xhr) {
        var msg = ct.ajaxErrorMsgDecode(xhr);
        $("div#loader").removeClass('show');  
        ct.notify('danger',msg);
      }).always(function() {
        $("div#loader").removeClass('show');
      });
    });
  };


  var postDataMultiPartForm = function(url, data, submitBtnObj){
    url = url;
    data.append(window.tokenName, window.tokenValue);
    
    var oldTextSubmitBtn = $(submitBtnObj).html();
    $(submitBtnObj).html('Please wait ...').attr('disabled', 'disabled');
    $("div#loader").addClass('show');

    return new Promise(function (resolve, reject) {
      $.ajax({
        url: url,
        type: 'post',
        data: data,
        processData: false,
        contentType: false,
      })
      .done(function(responseData) {

        ct.checkLoggedIn(responseData);

        if(isJsonString(responseData)){
          responseData = JSON.parse(responseData);

          if(responseData.response){
            resolve(responseData);
          }
          else{
            reject(responseData);
          }
        }
        else{
          console.log(responseData);
        }
      }).fail(function(xhr) {
        var msg = ct.ajaxErrorMsgDecode(xhr);
        ct.notify('danger',msg);
      }).always(function() {
        $("div#loader").removeClass('show');
        $(submitBtnObj).html(oldTextSubmitBtn).removeAttr('disabled');
      });
    });
  };

  
  var redirect = function(url){
    window.location.replace(url);
  };

  
  var removePartialView = function(id){
    $(id).remove();
    var hash = window.location.hash
    var newUrl = hash.substr(0, hash.lastIndexOf("/"));
    window.location.hash = newUrl;
    window.history.replaceState(null, null, window.location.hash);
  };

  
  var populateFormError = function(id, errors){
    $(id).find('.error_msg').remove();
    $.each(errors, function(index, el) {
      $(id).find("[name='"+index+"']").parent().append('<div class="error_msg">'+el+'</div>')
    });
  };

  
  var populateFileValidationError = function(id, errors){
    $(id).find('.error_msg').remove();
    $.each(errors, function(index, el) {
      if($.isArray(el) || 'object'==typeof(el)){
        var arrayObj = $(id).find("[name='"+index+"[]']");
        $.each(arrayObj, function(elementIndex, elementObj) {
          if(el[elementIndex] && ''!=el[elementIndex])
            $(elementObj).parent().append('<div class="error_msg">'+el[elementIndex]+'</div>');
        });
      }
      else{
        $(id).find("[name='"+index+"']").parent().append('<div class="error_msg">'+el+'</div>');
      }
    });
  };

  
  /**
   * [notify use for notification messages]
   * @param  {string} type [type of notification (like: error,success)]
   * @param  {string} msg  [message to be displayed]
   */
   var notify = function(type, msg){
    new PNotify({
      title: "Notification",
      type: type,
      text: msg,
      styling: 'bootstrap3',
      allow_dismiss: true,
    });
  };

  
  /**
   * [isJsonString to check whether returned data from server is JSON or not]
   * @param  {string}  str [data from server]
   * @return {Boolean}     
   */
   var isJsonString = function(str) {
    try {
      JSON.parse(str);
    } catch (e) {
      return false;
    }
    return true;
  };


  /**
   * [ajaxErrorMsgDecode to set global error message for all ajax request]
   * @param  {string}  xhr [ajax status response]
   * @return {string} errorMsg     
   */
   var ajaxErrorMsgDecode = function(xhr){
    var errorMsg = '';
    var responseText = $(xhr.responseText).text();

    if(0 < responseText.search("mysqli::real_connect()")){
      errorMsg = "Sorry but there is internet connection problem DB !! Please Try Again";
    }
    else{
      var error = $(xhr.responseText);
      errorMsg = "Sorry but there was an error: "+ xhr.status + " " + xhr.statusText+ " !! Please Try Again<br/>" +$(error[7]).html();
    }
    return errorMsg;
  };


  var mimeTypes = {
    'doc' : ['application/msword', 'application/vnd.ms-office'],
    'docx' : ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/msword', 'application/x-zip'],
    'word' : ['application/msword', 'application/octet-stream'],
    'jpeg' : ['image/jpeg', 'image/pjpeg'],
    'jpg'  : ['image/jpeg', 'image/pjpeg'],
    'png'  : ['image/png',  'image/x-png'],
    'pdf'  : ["application/pdf", "application/force-download", "application/x-download", "binary/octet-stream"],                         
  };


  var validateFile = function(fileObj, allowedTypes, size){
    var result = {response:false, code:'', msg:''};

    allowedTypes.forEach(function(type){
      if($.inArray(fileObj.type, mimeTypes[type]) > -1){ 
        result.response = true;
      }
    });

    if(result.response){
      if((fileObj.size/1024) > size){
        result.response = false; 
        result.code = "size";
        size = (1024 > size)? size+' KB' : size/1024+' MB'
        result.msg ='File size must be less than '+ size;
      }
      else{
        result.response = true;
      }
    }
    else{
      result.code = "type";
      result.msg = "Invalid File";
    }

    return result; 
  };


  var initDataTableSearch = function(dataTableObj, negletColumns, type='footer'){
    dataTableObj.api().columns().every(function () {
      var header = $(this.header()).text();
      if($.inArray(header, negletColumns)<0)
      { 
        var column = this;
        var select = $('<input type="text" style="width: 100%; padding: 4px 2px 0px 4px; box-sizing: border-box;" class="form-control input-sm" placeholder="'+header+'" title="Press Enter Key To Search" />');

        if('footer' == type){
          select.appendTo($(column.footer()).empty());
        }
        else{
          select.appendTo($(column.header()).empty());
        }
        
        select.on('keyup', function (e) {
          if(e.keyCode == 13) {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            column.search(val , true, true).draw();
          }
        });
      }    
    });
  }

  return {
    loadPartialView: loadPartialView,
    checkLoggedIn: checkLoggedIn,
    postData: postData,
    getData: getData,
    postDataMultiPartForm: postDataMultiPartForm,
    redirect: redirect,
    removePartialView: removePartialView,
    populateFormError: populateFormError,
    populateFileValidationError: populateFileValidationError,
    notify: notify,
    isJsonString: isJsonString,
    ajaxErrorMsgDecode: ajaxErrorMsgDecode,
    validateFile: validateFile,
    initDataTableSearch: initDataTableSearch,
  };

}(window.jQuery));


/* VALIDATOR */
function init_validator () {

  if( typeof (validator) === 'undefined'){ 
    return; 
  }
  
};




