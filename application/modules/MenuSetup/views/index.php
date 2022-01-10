<!-- Tree View  -->
<script src="<?=base_url(); ?>assets/plugins/jstree/jstree.min.js" type="text/javascript"></script>
<link href="<?=base_url(); ?>assets/plugins/jstree/style.min.css" rel="stylesheet" type="text/css">

<style type="text/css" media="screen">
  .jstree-btn{
    margin-left: 10px;
    margin-top: -2px;
  }
  .jstree-btn .dropdown-menu{
    font-size: 12px;
  }
  .jstree-btn .dropdown-menu>li>a {
    display: block;
    padding: 3px 10px;
    clear: both;
    font-weight: 400;
    line-height: 1.42857143;
    color: #333;
    white-space: nowrap;
  }
  .jstree-btn > .btn-xs{
    padding: 2px 4px;
    font-size: 10px;
    line-height: 1;
  }
</style>


<div id="content-inner-wrapper">
  <div class="row">
    <div class="col-md-5">
      <div class="box box-success">
        <div class="box-header with-border">
          <div class="eq-section">
            <input type="text" class="form-control col-md-12" id="search-menu" placeholder="Search Menu">
          </div>
        </div><br>
        <!-- /.box-header -->
        <div class="box-body">
          <a href="javascript:void(0)" data-actiontype="addparent" class="action-btn btn btn-rounded btn-success"><i class="fa fa-plus"></i> Add Menu</a>
          <br><br>

          <div id="tree-menu"></div>

        </div>
      </div>
    </div>

    <div class="col-md-7" id="menu-contentbox">
      <div class="box box-success">
        <div class="box-header with-border"><br>
          <p>No Contents Available !!</p>
        </div>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  var menuModule = {};
  menuModule.menuList = {};

  $(document).ready(function() {

    loadMenuTree();

    $("#content-inner-wrapper").on('click', ".action-btn",function(event){
      var action = $(this).data("actiontype");
      var id = $(this).data("id");
      performAction(action, id);
    });

    $("#search-menu").on('keyup',function(){
      $('#tree-menu').jstree('search', $(this).val());
    });
    

    // plugin for jstree to additional btn on node (outside of anchor)
    $.jstree.plugins.addCustomBtn = function (options, parent) {
      var div = document.createElement('div');
      div.className = "btn-group jstree-btn";

      this.redraw_node = function(obj, deep, callback, force_draw) {
        obj = parent.redraw_node.call(this, obj, deep, callback, force_draw);

        var menuId = obj.getElementsByTagName('a')[0].getAttribute('data-id');
        var id = obj.getAttribute('id');
        var htmlString = '';
        
        //checking  for any one permission either edit or add departmnet        
        htmlString += '<a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\
        <i class="bx bx-caret-down"></i>\
        </a>\
        <ul class="dropdown-menu">'

        /*checking departmnet add permission*/
        htmlString += '<li><a href="javascript:void(0)" class="action-btn" data-id="'+menuId+'" data-actiontype="addchild" ><i class="bx bx-plus-medical"></i>  Add Menu</a></li>';

        /*checking departmnet edit permission*/
        htmlString +='<li><a href="javascript:void(0)" class="action-btn" data-id="'+menuId+'" data-actiontype="edit" ><i class="fas fa-pen"></i>  Edit Menu</a></li>';

        htmlString += '</ul>';

        div.innerHTML = htmlString;              
        if(obj) {
          var tmp = div.cloneNode(true);
          obj.insertBefore(tmp, obj.childNodes[2]);
        }
        return obj;
      };
    };
  });

  function performAction(action, id){
    menuModule.selectedMenu = null;
    if('addparent'==action){
      var url = 'MenuSetup/add/';
      window.ct.getData(url).then(function(responseData){
        $("#menu-contentbox").html(responseData.result);
      });
    }
    else if('addchild'==action){
      var url = 'MenuSetup/add/'+id;
      menuModule.selectedMenu = id;
      window.ct.getData(url).then(function(responseData){
        $("#menu-contentbox").html(responseData.result);
      });
    }
    else if('view'==action){
      var url = 'MenuSetup/viewDetail/'+id;
      window.ct.getData(url).then(function(responseData){
        $("#menu-contentbox").html(responseData.result);
      });
    }
    else if('edit'==action){
      var url = 'MenuSetup/edit/'+id;
      window.ct.getData(url).then(function(responseData){
        $("#menu-contentbox").html(responseData.result);
      });
    }
    else{
      var htmlString = '<div class="box box-success">\
      <div class="box-header with-border">\
      <p>No Contents Available !!</p>\
      </div>\
      </div>\
      ';
      $("#menu-contentbox").html(htmlString);
    }
  }

  function loadMenuTree(){
    var url = 'MenuSetup/getMenuList';

    window.ct.getData(url).then(function(responseData){
      menuModule.menuList = responseData.result;

      $.jstree.destroy ('#tree-menu');
      $('#tree-menu').html(formatOuputTreeView(responseData.result));

      $('#tree-menu').jstree({
        'core': {
          'multiple': false,
          'themes': {
            'responsive': true
          }
        },
        "plugins" : [
        "addCustomBtn",
        "search",
        "state",
        ]
      });
    }, 
    function(error){
      ct.notify('danger',error.msg);
    });
  }

  /*function to prepare structure for tree view (ul li)*/
  function formatOuputTreeView(data){
    var htmlString = "";
    htmlString += '\n\t\t<ul>';

    $.each(data, function(index, el) {
      htmlString += '\n\t<li id="'+el.enc_menu_id+'"data-jstree=\'{"icon":"bx bx-building-house"}\' >\
      \n\t\t<a data-id="'+el.enc_menu_id+'" id="'+el.enc_menu_id+'" data-actiontype="view" class="action-btn">'+el.menu_name+'</a>\
      ';

      if(el.child){
        htmlString += formatOuputTreeView(el.child);
      }

      htmlString += '\n\t</li>';
    });
    htmlString += '\n\t\t</ul>';

    return htmlString;
  } 
</script>