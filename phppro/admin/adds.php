<?php
$active_tab = 'adds';
$prependScript ='<style>
  .img-thumbnail {
    max-height:150px;
    max-width:180px;
  }
</style>';
$jscss='both';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(isset($_POST['addHomeadd'])) {
  if(isset($_FILES) && !empty($_FILES)) {
    $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/adds/');
    if($ret['status'] && isset($ret['image_name'])) {
      $arr = array();
      $arr['is_show'] = strip_tags(trim($_REQUEST['is_show']));
      $arr['link'] = strip_tags(trim($_REQUEST['link']));
      $arr['image_name'] = $ret['image_name'];
      if($QueryFire->insertData('adds',$arr)) {
        $msg = 'Add added successfully';
      } else {
        $msg = "Unable to add Add";
      }
    } else {
      $msg = 'Unable to upload file. Please try later.';
    }
  }
}

if(isset($_POST['updateHomeadd'])) {
  $arr = array();
  $arr['is_show'] = strip_tags(trim($_REQUEST['is_show']));
  $arr['link'] = strip_tags(trim($_REQUEST['link']));
  $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/adds/');
  if($ret['status'] && isset($ret['image_name'])) {
    $arr['image_name'] = $ret['image_name'];
    $duplicate = $QueryFire->getAllData('adds',' id ='.$_REQUEST['id']);
    unlinkImage('../images/adds/'.$duplicate[0]['image_name']);
  } else {
    $msg = 'Unable to upload file. Please try later.';
  }
  if($QueryFire->upDateTable("adds",'id ='.$_REQUEST['id'],$arr)) {
    $msg = 'Add successfully updated.';
  } else {
    $msg = 'Can not update Add.';
  }
}

if(!empty($_POST['user_action'])) {
  switch($_POST['user_action']) {
    case 'delete':
        $duplicate = $QueryFire->getAllData('adds',' id ='.$_REQUEST['id']);
        unlinkImage('../images/adds/'.$duplicate[0]['image_name']);
        $QueryFire->deleteDataFromTable("adds",' id='.$_POST['id']);
        $msg = 'add deleted successfully.';
        break;
  }
}
$adds = $QueryFire->getAllData('adds',' 1');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Adds <button class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">Add Add</button></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item active">Adds</li>
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
                  <th>Image</th>
                  <th>Link</th>
                  <th>Showing</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($adds)) {
                  foreach($adds as $row) { ?>
                  <tr>
                    <td class="cat">
                      <img src="../images/adds/<?php echo $row['image_name'];?>" class="img-responsive img-thumbnail">
                    </td>
                    <td><a class="link" target="_blank" href="<?php echo $row['link'];?>"><?php echo $row['link'];?></a></td>
                    <td>
                      <?php echo $row['is_show']?'Yes':'No';?>
                    </td>
                    <input type="hidden" class="yes_no_select" value="<?=$row['is_show']?>" />
                    <td>
                      <button class="btn btn-success btn-xs edit_add mt-1" data-id="<?php echo $row['id'];?>">Edit</button>
                      <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $row['id'];?>"> Delete</a> 
                    </td>
                  </tr>
                <?php } } else {
                  echo '<td colspan="7" class="text-center">You have not added any add</td>';
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="modal fade" data-backdrop="static"  id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <form method="post">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to delete this Add</h5>
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
  <!-- Add Modal -->
  <div id="myModal" class="modal fade in" role="dialog">
    <form id="addGal" method="post" action="" enctype="multipart/form-data">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add New Home Add</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="link">Link:</label>
              <input type="url" name="link" class="form-control" />
            </div>
            <div class="form-group">
              <label for="img_show">Is Show:</label>
              <select name="is_show" class="form-control">
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
            <div class="form-group">
              <label for="file_upload">Images:</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" id="file" name="file_upload" accept="image/*" class="custom-file-input" id="exampleInputFile">
                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                </div>
              </div>
            </div>
            <div id="clear"></div>
            <div id="preview">
              <span class="pre">IMAGE PREVIEW</span><br>
              <img id="previewimg" src="" style="max-width:200px;height: 100px">      
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="addHomeadd" >Add</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- Edit Modal -->
  <div id="editHomeadd" class="modal fade" role="dialog">
    <form method="post" action="" id="editGalImg" enctype="multipart/form-data">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Add</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="link">Link:</label>
              <input type="url" name="link" class="form-control linkT" />
            </div>
            <div class="form-group" id="formdiv">
              <div class="row">
                <div class="col-xs-12 col-lg-5 col-md-5 col-sm-5">
                  <label>Current Picture</label>
                  <img src="" class="img_show img-thumbnail img-responsive" />
                </div>
                <div class="col-xs-12 col-md-7 col-lg-7 col-sm-7">
                  <div class="form-group">
                    <label>Change Picture:</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" id="file" name="file_upload" accept="image/*" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="name">Is Show:</label>
                    <select name="is_show" class="form-control select_y_s">
                      <option value="1">Yes</option>
                      <option value="0">No</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>   
            <input type="hidden" name="id" class="idCls">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="updateHomeadd" >Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </form>
  </div>
<?php 
$appendScript = '
  <script>
    $(document).ready(function() {
      jQuery("#addGal").validate({
        rules: {
          file_upload: "required",
          link: {
            url:true
          },
        },
        messages: {
          file_upload: "Upload an image ",
          link: "Enter valid URL"
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
      $(document).on("click",".edit_add",function(){
        $(".select_y_s").val($(this).parents("tr").find(".yes_no_select").val());
        $(".img_show").attr("src",$(this).parents("tr").find(".img-thumbnail").attr("src"));
        $(".linkT").val($(this).parents("tr").find(".link").attr("href").trim());
        $(".idCls").val($(this).data("id"));
        $("#editHomeadd").modal("show");
      });
      $("#deleteModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data("id");
        var modal = $(this);
        modal.find(".modal-content input").val(recipient);
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