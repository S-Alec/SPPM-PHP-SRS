<?php
  //Buffer larger content areas like the main page content
  require_once '../SQL/settings.php';
  require_once 'model.php';
  ob_start();
  session_start();
  //check session
  // if (!(isset($_SESSION['username']) && $_SESSION['username'] != '')) {
  //   //redirect
  //   header ("Location: index.php");
  // }

  $mysqli = new mysqli(
    $host,
    $user,
    $pwd,
    $sql_db
  );

  /* Check Connection */
  if ($mysqli->connect_errno) {
      printf("Connection Failed: %s\n", $mysqli->connect_error);
      exit();
  }

  $userPro = new UserModel();
  $sql = $userPro->getUserList();

?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">User Management</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                User Table
                <button class="btn btn-xs btn-default pull-right" id="btn-user-add-new">Add New</button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Last name</th>
                                <th>Role</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $result = $mysqli->query($sql);
                        if ($result === false) {
                            printf("Data Handler Failed: %s\n", $mysqli->error);
                        } else {
                            if ($result->num_rows > 0) {
                                // output data of each row
                                $return = '';
                                while ($row = $result->fetch_assoc()) {
                                    $return = $return.'<tr class="odd gradeX" id="'.$row['uid'].'">'
                                   .'<td>'.$row['username'].'</td>'
                                   .'<td>'.$row['lname'].'</td>'
                                   .'<td>'.$row['role'].'</td>'
                                   .'<td>'
                                          .'<button class="btn btn-default btn-user-edit"
                                          data-role="'.$row['role'].'"
                                          data-lname="'.$row['lname'].'"
                                          data-username="'.$row['username'].'"
                                          data-id="'.$row['uid'].'
                                          ">Edit</button> &nbsp;'
                                          .'<button class="btn btn-default btn-user-delete" data-id="'.$row['uid'].'">Delete</button>'
                                      .'</td>'
                                   .'</tr>';
                                }
                                echo  $return;
                            } else {
                                echo '0 results';
                            }
                        }
                        $mysqli->close();
                        ?>


                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<!-- Modal -->
<div id="modal-user-form" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">User Form</h4>
          </div>
          <div class="modal-body">


                <div class="form-group">
                  <label for="email">Username:</label>
                  <input type="text" name="username" class="form-control" id="modal-txt-username" placeholder="Enter username">
                </div>
                <div class="form-group">
                  <label for="pwd">Last name:</label>
                  <input type="text" name="lastname" class="form-control" id="modal-txt-lastname" placeholder="Enter last name">
                </div>
                <div class="form-group">
                  <label for="pwd">Password:</label>
                  <input type="password" name="password" class="form-control" id="modal-txt-password" placeholder="Enter password">
                </div>
                <div class="form-group">
                  <label for="pwd">Role:</label>
                  <select class="form-control" id="modal-cbb-role">
                         <option value='MANAGER'>MANAGER</option>
                         <option value='STAFF'>STAFF</option>
                   </select>
                </div>



          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="modal-btn-user-save">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
    </div>

  </div>
</div>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->

<!-- /.row -->
<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = 'PHP - User Management';
  //Apply the template
  include '../master.php';
?>
<script src="index.js"></script>
