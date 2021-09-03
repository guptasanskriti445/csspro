<?php
$active_tab = 'sliders';
$prependScript ='<style>
  .img-thumbnail {
    max-height:150px;
    max-width:180px;
  }
</style>';
$jscss='both';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(isset($_POST['addHomeSlider'])) {
  if(isset($_FILES) && !empty($_FILES)) {
    $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/sliders/');
    if($ret['status'] && isset($ret['image_name'])) {
      $arr = array();
      $arr['is_show'] = strip_tags(trim($_REQUEST['is_show']));
      $arr['description'] = strip_tags(trim($_REQUEST['description']),'<p>,<br>');
      $arr['heading'] = htmlentities(strip_tags(trim($_REQUEST['heading']),'<br>'));
      $arr['subheading'] = htmlentities(strip_tags(trim($_REQUEST['subheading']),'<br>'));
      $arr['price'] = strip_tags(trim($_REQUEST['price']));
      $arr['link'] = strip_tags(trim($_REQUEST['link']));
      $arr['image_name'] = $ret['image_name'];
      if($QueryFire->insertData('sliders',$arr)) {
        $msg = 'Slider added successfully';
      } else {
        $msg = "Unable to add slider";
      }
    } else {
      $msg = 'Unable to upload file. Please try later.';
    }
  }
}

if(isset($_POST['updateHomeSlider'])) {
  $arr = array();
  $arr['is_show'] = strip_tags(trim($_REQUEST['is_show']));
  $arr['description'] = strip_tags(trim($_REQUEST['description']),'<p>,<br>');
  $arr['heading'] = htmlentities(strip_tags(trim($_REQUEST['heading']),'<br>'));
  $arr['subheading'] = htmlentities(strip_tags(trim($_REQUEST['subheading']),'<br>'));
  $arr['price'] = strip_tags(trim($_REQUEST['price']));
  $arr['link'] = strip_tags(trim($_REQUEST['link']));
  $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/sliders/');
  if($ret['status'] && isset($ret['image_name'])) {
    $arr['image_name'] = $ret['image_name'];
    $duplicate = $QueryFire->getAllData('sliders',' id ='.$_REQUEST['id']);
    unlinkImage('../images/sliders/'.$duplicate[0]['image_name']);
  } else {
    $msg = 'Unable to upload file. Please try later.';
  }
  if($QueryFire->upDateTable("sliders",'id ='.$_REQUEST['id'],$arr)) {
    $msg = 'Slider successfully updated.';
  } else {
    $msg = 'Can not update slider.';
  }
}

if(!empty($_POST['user_action'])) {
  switch($_POST['user_action']) {
    case 'delete':
        $duplicate = $QueryFire->getAllData('sliders',' id ='.$_REQUEST['id']);
        unlinkImage('../images/sliders/'.$duplicate[0]['image_name']);
        $QueryFire->deleteDataFromTable("sliders",' id='.$_POST['id']);
        $msg = 'Slider deleted successfully.';
        break;
  }
}
$sliders = $QueryFire->getAllData('sliders',' 1');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Sliders <button class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">Add Slider</button></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item active">Sliders</li>
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
                  <th>Heading</th>
                  <th>SubHeading</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Link</th>
                  <th>Showing</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($sliders)) {
                  foreach($sliders as $row) { ?>
                  <tr>
                    <td class="cat">
                      <img src="../images/sliders/<?php echo $row['image_name'];?>" class="img-responsive img-thumbnail">
                    </td>
                    <td class="heading"><?php echo html_entity_decode($row['heading']);?></td>
                    <td class="subheading"><?php echo html_entity_decode($row['subheading']);?></td>
                    <td class="description"><?php echo $row['description'];?></td>
                    <td class="price"><?php echo html_entity_decode($row['price']);?></td>
                    <td><a class="link" target="_blank" href="<?php echo $row['link'];?>"><?php echo $row['link'];?></a></td>
                    <td>
                      <?php echo $row['is_show']?'Yes':'No';?>
                    </td>
                    <input type="hidden" class="yes_no_select" value="<?=$row['is_show']?>" />
                    <td>
                      <button class="btn btn-success btn-xs edit_slider mt-1" data-id="<?php echo $row['id'];?>">Edit</button>
                      <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $row['id'];?>"> Delete</a>                    
                    </td>
                  </tr>
                <?php } } else {
                  echo '<td colspan="7" class="text-center">You have not added any slider</td>';
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
            <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to delete this Silder</h5>
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
            <h4 class="modal-title">Add New Home Slider</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="heading">Heading:</label>
              <input type="text" name="heading" class="form-control" />
            </div>
            <div class="form-group">
              <label for="subheading">Sub Heading:</label>
              <input type="text" name="subheading" class="form-control" />
            </div>
            <div class="form-group">
              <label for="description">Description:</label>
              <input type="text" name="description" class="form-control" />
            </div>
            <div class="form-group">
              <label for="price">Price:</label>
              <input type="text" name="price" class="form-control" />
            </div>
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
            <button type="submit" class="btn btn-primary" name="addHomeSlider" >Add</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- Edit Modal -->
  <div id="editHomeSlider" class="modal fade" role="dialog">
    <form method="post" action="" id="editGalImg" enctype="multipart/form-data">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Slider</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="heading">Heading:</label>
              <input type="text" name="heading" class="form-control headingT" />
            </div>
            <div class="form-group">
              <label for="subheading">Sub Heading:</label>
              <input type="text" name="subheading" class="form-control subheadingT" />
            </div>
            <div class="form-group">
              <label for="description">Description:</label>
              <input type="text" name="description" class="form-control descriptionT" />
            </div>
            <div class="form-group">
              <label for="price">Price:</label>
              <input type="text" name="price" class="form-control priceT" />
            </div>
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
            <button type="submit" class="btn btn-primary" name="updateHomeSlider" >Update</button>
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
      $(document).on("click",".edit_slider",function(){
        $(".select_y_s").val($(this).parents("tr").find(".yes_no_select").val());
        $(".img_show").attr("src",$(this).parents("tr").find(".img-thumbnail").attr("src"));
        $(".descriptionT").val($(this).parents("tr").find(".description").html().trim());
        $(".linkT").val($(this).parents("tr").find(".link").attr("href").trim());
        $(".headingT").val($(this).parents("tr").find(".heading").html().trim());
        $(".subheadingT").val($(this).parents("tr").find(".subheading").html().trim());
        $(".priceT").val($(this).parents("tr").find(".price").html().trim());
        $(".idCls").val($(this).data("id"));
        $("#editHomeSlider").modal("show");
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