<?php
$active_tab = 'users';
$jscss='both';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(!empty($_POST['user_action'])) {
  switch($_POST['user_action']) {
    case 'delete':
        //$QueryFire->deleteDataFromTable("users",' id='.$_POST['id']);
        $QueryFire->upDateTable("users",' id='.$_POST['id'],array('is_deleted'=>1));
        $msg = 'User deleted successfully.';
        break;
  }
}
$data = $QueryFire->getAllData('users',' is_deleted=0 order by id desc');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Users <a href="export-data?allUsers=1" class="btn btn-secondary float-right btn-sm">Export Users</a></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <?php echo !empty($msg)?'<h5 class="text-center text-success">'.$msg.'</h5>':''?>
            <table class="data-table table table-bordered table-striped table-bordered table-hover dt-responsive nowrap">
              <thead>
                <tr>
                  <th>Sr No.</th>
                  <th>Name</th>
                  <th>Mobile No</th>
                  <th>Email</th>
                  <th>Address</th>
                  <th>Pincode</th>
                  <th>Verified</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($data)) {
                  $cnt=1;
                  foreach($data as $row) { ?>
                  <tr>
                    <td><?php echo $cnt++;?></td>
                    <td><?php echo $row['name'];?></td>
                    <td><?php echo $row['mobile_no'];?></td>
                    <td><?php echo $row['email'];?></td>
                    <td><?php echo $row['address'];?></td>
                    <td><?php echo $row['pincode'];?></td>
                    <td><?php echo $row['is_verified']?'Yes':'No';?></td>
                    <td>
                    <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $row['id'];?>"> Delete</a> 
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
  <div class="modal fade" data-backdrop="static"  id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <form method="post">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to delete this User</h5>
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
      $("#deleteModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data("id");
        var modal = $(this);
        modal.find(".modal-content input").val(recipient);
      });
    });
  </script>';
require_once('templates/footer.php');?>