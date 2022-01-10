<div class="col m8">
  <form action="Dashboard/changeUserPassword" method="post" novalidate class="eq-section" id="changePasswordForm">
    <div class="row">
      <h5 style="color: red;"><center>Password must be of at least 5 characters.</center></h5>
      <h5 style="color: red;"><center>Must Contain 1 Uppercase, 1 Lowercase, 1 Numeric, 1 Special Character.</center></h5>
    </div><br>

    <div class="row">
      <div class="input-field col m12">
        <div class="form-group item">
          <label class="required-label">Current Password </label>
          <input type="password" class="form-control" name="curr_password" placeholder="Your Current Password" required="required" maxlength="25">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="input-field col m6">
        <div class="form-group item">
          <label class="required-label">New Password </label>
          <input type="password" class="form-control" name="new_password" placeholder="Your New Password" required="required" maxlength="25">
        </div>
      </div>

      <div class="input-field col m6">
        <div class="form-group item">
          <label class="required-label">Confirm Password </label>
          <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="required" value="" maxlength="25">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col m12">
        <button type="submit" id="changeBtn" class="btn pull-left">Change Password</button>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">

  $(document).ready(function(){

    $('#changePasswordForm').on('submit',function(){

      if(validator.checkAll($(this))){
        var data = [];
        var url = $(this).attr('action');
        var data = $(this).serializeArray();
        data.push({name:"change_password", value:"change_password"});

        window.ct.postData(url, data, $('#changeBtn')).then(function(responseData){
          window.ct.notify('success', responseData.msg);
          location.reload('Dashboard');
        },function(error){
          if('form-error' == error.type){
            window.ct.populateFormError($('#changePasswordForm'),error.result);
          }
          window.ct.notify('danger', error.msg);
        });
      }
      return false;
    });
  });
</script>