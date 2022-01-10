<!-- Select2 -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/select2/select2.min.css">
<script src="<?php echo base_url();?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>

<!--icheck radio and checkbox js and css -->
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/iCheck/icheck.js"></script> 
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/iCheck/icheck.min.js"></script> 
<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/iCheck/skins/all.css">

<div class="box box-success">
  <div class="box-header with-border">
    <div class="box-title">
      <h3>Create New Menu
        <button style="float: right;" type="button" onclick="performAction('');" class="btn btn-rounded btn-warning" title="Back" ><i class="fa fa-close"></i> Cancel</button>
      </h3>
    </div>
  </div>
</div><br>
<!-- /.box-header -->

<!-- form start -->
<form action="MenuSetup/add/" method="post" novalidate class="eq-section" id="menu_setup_form">
  <div class="box-body">
    <div class="row form-group item">
      <div class="col-md-10">
        <label for="" class="required-label">Menu Code </label>
        <input type="text" class="form-control" name="menu_code" placeholder="ClassName-functionName" required="required" value="" maxlength="80">
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group item">
          <label class="required-label">Title </label>
          <input type="text" class="form-control" name="menu_name" placeholder="Title" required="required" value="" maxlength="50">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group item">
          <label class="required-label">Type </label>
          <select name="menu_type" id="menu_type" class="form-control input-sm" required="required" data-placeholder="Select Menu Type">
            <option value="<?=MENU_TYPE['OUTER']?>">Outer</option>
            <option value="<?=MENU_TYPE['INNER']?>">Inner</option>
          </select>
        </div>
      </div>
    </div>

    <div class="row form-group item" style="display: none;">
      <div class="col-md-6">
        <label for="" class="required-label">Route </label>
        <input type="text" class="form-control" name="route" placeholder="ClassName/functionName" value="" maxlength="80">
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group item">
          <label>Icon Class </label>
          <input type="text" class="form-control" name="icon_class" placeholder="Icon class">
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group item">
          <label class="required-label">Position </label>
          <input type="number" name="menu_index" class="form-control"  placeholder="Position" required="required" />
        </div>
      </div>
    </div>

    <div class="row form-group">
      <div class="col-md-6">
        <label for="">Parent Menu </label>
        <select name="parent_menu" class="form-control" id="parent_menu"  data-placeholder="Select Parent Menu">
          <option value="<?=urlencode(base64_encode(0))?>">N/A</option>
        </select>
      </div>
    </div>
  </div>
  <div class="box-footer">
    <div class="row form-group">
      <button type="submit" class="btn btn-success btn-rounded" name="save" id="save">Save Menu</button>
    </div>
  </div>
</form>
<!-- /.box -->


<script type="text/javascript">

  var select2Datasource = [];

  $(document).ready(function() {

    $("#menu_type").select2().val(null).trigger("change");

    formatOuputSelect2(menuModule.menuList, '')
    $('#parent_menu').select2({
     data:select2Datasource,
   }).val(menuModule.selectedMenu).trigger('change');


    $("#menu_type").on('change', function(){
      onMenuTypeChange($(this).val());
    });


    $("#menu_setup_form").submit(function(event) {
      if(validator.checkAll($(this))) {
        var data = $(this).serializeArray();
        data.push({name:'save_menu',value:'save_menu'});

        var url = $(this).attr('action');
        window.history.replaceState(null, null, window.location.hash);

        window.ct.postData(url, data, $("#save")).then(function(responseData){
          window.ct.notify('success',responseData.msg);
          performAction('');
          loadMenuTree();
        }, function(error){
          window.ct.notify('danger',error.msg);
          window.ct.populateFormError("#menu_setup_form", error.result);
        });
      }
      return false;
    });
  });

  function onMenuTypeChange(value){
    if("<?=MENU_TYPE['OUTER']?>"==value){
      $('[name="route"]').attr('required', 'required');
      $('[name="route"]').parent().parent().show();
    }else{
      $('[name="route"]').removeAttr('required', 'required');
      $('[name="route"]').parent().parent().hide();
      $('[name="route"]').parent().parent().removeClass('bad');
    }
  }

  /*function to prepare structure for select2 converts deep nested array into single dimension array*/
  function formatOuputSelect2(data, level){
    $.each(data, function(index, el) {
      select2Datasource.push({id:el.enc_menu_id,text:level+el.menu_name});

      if(el.child){
        var newLevel = ' '+level+"-";
        formatOuputSelect2(el.child, newLevel);
      }
    });
  } 
</script>