<?php
$active_tab = 'seo';
$jscss='both';
$prependScript ='<style>
  .img-thumbnail {
    max-height:150px;
    max-width:180px;
  }
</style>';
$jscss='both';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(!empty($_POST['user_action'])) {
  switch($_POST['user_action']) {
    case 'add':
      $dummy = $QueryFire->getAllData("seo",' page_id ='.$_REQUEST['page_id']);
      if(empty($dummy)) {
        $arr = array();
        $arr['image_name'] =  '';
        $arr['description'] = $_REQUEST['description'];
        $arr['title'] = $_REQUEST['title'];
        $arr['page_id'] = $_REQUEST['page_id'];
        if(isset($_FILES) && !empty($_FILES['file_upload']['tmp_name'])) {
          $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/pages/');
          if($ret['status'] && isset($ret['image_name'])) {
            $arr['image_name'] = $ret['image_name'];
          } else {
            $msg = "Unable to upload baner";
          }
        }
        if(!isset($msg)) {
          if($QueryFire->insertData("seo",$arr)) {
            $msg = 'SEO added successfully';
          } else {
            $msg = "Unable to add SEO";
          }
        }
      } else {
        $msg = 'SEO already exists';
      }
      break;
    case 'edit':
      $dummy = $QueryFire->getAllData("seo",' page_id ='.$_REQUEST['page_id'].' and id !='.$_REQUEST['id']);
      if(empty($dummy)) {
        $arr = array();
        $arr['description'] = $_REQUEST['description'];
        $arr['title'] = $_REQUEST['title'];
        $arr['page_id'] = $_REQUEST['page_id'];
        if(isset($_FILES) && !empty($_FILES['file_upload']['tmp_name'])) {
          $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/pages/');
          if($ret['status'] && isset($ret['image_name'])) {
            $arr['image_name'] = $ret['image_name'];
          } else {
            $msg = "Unable to upload baner";
          }
        }
        if(!isset($msg)) {
          if($QueryFire->upDateTable("seo",'id ='.$_REQUEST['id'],$arr)) {
            $msg = 'SEO successfully updated.';
          } else {
            $msg = 'Can not update SEO.';
          }
        }
      } else {
        $msg = 'SEO already exists';
      }
      break;
    case 'delete':
        $duplicate = $QueryFire->getAllData("seo",' id ='.$_POST['id']);
        unlinkImage('../images/pages/'.$duplicate[0]['image_name']);
        $QueryFire->deleteDataFromTable("seo",' id='.$_POST['id']);
        $msg = 'SEO deleted successfully.';
        break;
  }
}
$seos = $QueryFire->getAllData("",'',' SELECT s.*,p.name as page FROM seo as s LEFT JOIN pages as p ON p.id=s.page_id');
$pages = $QueryFire->getAllData("pages",' 1 order by name asc');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>SEO <button class="btn btn-outline-secondary float-sm-right btn-flat" data-toggle="modal" data-target="#myModal">Add SEO</button></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= admin_path?>dashboard">Home</a></li>
            <li class="breadcrumb-item active">SEO</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <?php echo !empty($msg)?'<h5 class="text-center text-success">'.$msg.'</h5>':''?>
            <table class="data-table table table-bordered table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th>Page</th>
                  <th>Banner</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($seos)) {
                  foreach($seos as $row) { ?>
                  <tr>
                    <td><?php echo ucwords($row['page']);?></td>
                    <td>
                      <?php if(!empty($row['image_name'])) { ?>
                        <img src="<?= image_path.'pages/'.$row['image_name'];?>" class="img-fluid img-thumbnail">
                      <?php } ?>
                    </td>
                    <td><?php echo $row['title'];?></td>
                    <td>
                      <?php echo $row['description'];?>
                    </td>
                    <td>
                      <button class="btn btn-success btn-xs dev-edit mt-1" data-id="<?php echo $row['id'];?>">Edit</button>
                      <button class="btn btn-danger btn-xs mt-1" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $row['id'];?>">Delete</button>
                    </td>
                  </tr>
                <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div id="myModal" class="modal fade in" role="dialog">
    <form id="addGal" method="post" action="" enctype="multipart/form-data">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add New SEO</h4>
          </div>
          <div class="modal-body">
            <div class="row row-cols-1 row-cols-sm-2">
              <div class="col">
                <div class="form-group">
                  <label for="page_id">Page</label>
                  <select class="form-control select2" name="page_id" data-placeholder="Select Page">
                    <?php if(!empty($pages)) {
                      foreach($pages as $page) {
                        echo '<option value="'.$page['id'].'" data-image="'.$page['has_image'].'">'.ucwords($page['name']).'</option>';
                      }
                    }?>
                  </select>
                </div>
              </div>
              <div class="col">
                <div class="form-group img-div">
                  <label for="file_upload">Banner</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" id="file" name="file_upload" accept="image/*" class="custom-file-input" id="exampleInputFile">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="name">SEO Title</label>
              <input class="form-control" name="title" required type="text">
            </div> 
            <div class="form-group">
              <label for="name">SEO Description</label>
              <textarea class="form-control" name="description" required ></textarea>
            </div> 
            <div id="clear"></div>
            <div id="preview">
              <span class="pre">IMAGE PREVIEW</span><br>
              <img id="previewimg" src="" style="max-width:200px;height: 100px">      
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="user_action" value="add">Add</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div id="editHomeSlider" class="modal fade" role="dialog">
    <form method="post" action="" id="editform" enctype="multipart/form-data">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit SEO</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="page_id">Page</label>
              <select class="form-control disabled" readonly name="page_id" data-placeholder="Select Page">
                <?php if(!empty($pages)) {
                  foreach($pages as $page) {
                    echo '<option value="'.$page['id'].'" data-image="'.$page['has_image'].'">'.ucwords($page['name']).'</option>';
                  }
                }?>
              </select>
            </div>
            <div class="form-group">
              <label for="name">SEO Title</label>
              <input class="form-control title" name="title" required type="text">
            </div> 
            <div class="form-group">
              <label for="name">SEO Description</label>
              <textarea class="form-control description" name="description" required ></textarea>
            </div> 
            <div class="form-group img-div">
              <div class="row">
                <div class="col-xs-12 col-lg-5 col-md-5 col-sm-5">
                  <label>Current Banner</label>
                  <img src="" class="img_show img-thumbnail img-responsive" />
                </div>
                <div class="col-xs-12 col-md-7 col-lg-7 col-sm-7">
                  <div class="form-group">
                    <label>Change Banner</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" id="file" name="file_upload" accept="image/*" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>   
            <input type="hidden" name="id" class="idCls">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="user_action" value="edit">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="modal fade" data-backdrop="static"  id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <form method="post">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to delete this  SEO?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <input type="hidden" name="id" />
          <div class="modal-footer">
            <button type="button" class="btn btn-default rounded-0" data-dismiss="modal">Close</button>
            <button type="submit" name="user_action" value="delete" class="btn btn-outline-danger rounded-0">Yes, Delete</button>
          </div>
        </div>
      </div>
    </form>
  </div>
<?php 
$appendScript = '
  <script>
    $(document).ready(function() {
      $(".select2").select2();
      $(".select2").val(null).trigger("change");
      $(".data-table").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
      });
      $(".select2").on("change",function(){
        console.log($(this).find("option:selected").data("image"));
        if(!$(this).find("option:selected").data("image")) {
          $(this).parents(".row").find(".img-div").addClass("hide");
          $(this).parents(".row").removeClass("row-cols-sm-2").addClass("row-cols-sm-1");
        } else {
          $(this).parents(".row").find(".img-div").removeClass("hide");
          $(this).parents(".row").addClass("row-cols-sm-2").removeClass("row-cols-sm-1");
        }
      });
      $("#deleteModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data("id");
        var modal = $(this);
        modal.find(".modal-content input").val(recipient);
      });
      jQuery("#addGal").validate({
        rules: {
          title: "required",
          description: "required",
          file_upload: "required",
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
          error.addClass("invalid-feedback");
          element.closest(".form-group").append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass("is-invalid");
        }
      });
      jQuery("#editform").validate({
        rules: {
          title: "required",
          description: "required",
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
          error.addClass("invalid-feedback");
          element.closest(".form-group").append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass("is-invalid");
        }
      });
      $(document).on("click",".dev-edit",function(){
        $.ajax({
          url:"query",
          method:"POST",
          data:{action:"get-seo-details",id:jQuery(this).data("id")},
          success:function(res) {
            var res = $.parseJSON(res);
            jQuery("#editHomeSlider .select2").val(res.page_id);
            jQuery("#editHomeSlider .title").val(res.title);
            jQuery("#editHomeSlider .description").val(res.description);
            jQuery("#editHomeSlider .idCls").val(res.id);
            jQuery("#editHomeSlider .select2").val(res.page_id).trigger("change");
            if(res.image_name != "") {
              jQuery("#editHomeSlider .img-div").removeClass("hide");
              jQuery("#editHomeSlider img").attr("src","'.image_path.'pages/"+res.image_name);
            } else {
              jQuery("#editHomeSlider .img-div").addClass("hide");
            }
            jQuery("#editHomeSlider").modal("show");
          }
        });
      });
      $(":file").change(function() {
        if (this.files && this.files[0]) {
          var reader = new FileReader();
          reader.onload = imageIsLoaded;
          reader.readAsDataURL(this.files[0]);
        }
      });
      $("#preview").css("display", "none");
      function imageIsLoaded(e) {
        $("#message").css("display", "none");
        $("#preview").css("display", "block");
        $("#previewimg").attr("src", e.target.result);
        $(".img_show").attr("src", e.target.result);
      }
    });
  </script>';
require_once('templates/footer.php');?>