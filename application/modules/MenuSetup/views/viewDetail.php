<div class="box box-success">
  <div class="box-header with-border">
    <div class="box-title">
      <h3>Menu Detail
        <button style="float: right;" type="button" onclick="performAction('');" class="btn btn-rounded btn-warning" title="Back" ><i class="fa fa-close"></i> Cancel</button>
      </h3>
    </div>
  </div><br>
  <!-- /.box-header -->

  <!-- form start -->
  <form novalidate class="eq-section" id="menu_setup_form">
    <input type="hidden" id="menu_id" name="menu_id" value="<?=$menuIdEnc?>">
    <div class="box-body">
      <div class="row form-group item">
        <div class="col-md-10">
          <label>Code :&nbsp;</label><?=$menu['menu_code'];?>
        </div>
      </div>
      <div class="row form-group item">
        <div class="col-md-6">
          <label>Title :&nbsp;</label><?=$menu['menu_name'];?>
        </div>
      </div>
      <div class="row form-group item">
        <div class="col-md-6">
          <label>Type :&nbsp;</label><?=ucwords($menu['menu_type']);?>
        </div>
      </div>
      <div class="row form-group item">
        <div class="col-md-6">
          <label>Route :&nbsp;</label><?=$menu['route'];?>
        </div>
      </div>
      <div class="row form-group item">
        <div class="col-md-6">
          <label>Icon Class :&nbsp;</label><?=$menu['icon_class'];?>
        </div>
      </div>
      <div class="row form-group item">
        <div class="col-md-6">
          <label>Position :&nbsp;</label><?=$menu['menu_index'];?>
        </div>
      </div>
      <div class="row form-group">
        <div class="col-md-6">
          <label>Parent Menu :&nbsp;</label><?=$menu['parent_menu'];?>
      </div>
    </div>
  </form>
</div>