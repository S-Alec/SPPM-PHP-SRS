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
                                <th>#</th>
                                <th>Username</th>
                                <th>Last name</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $index=>$userItems): ?>
                          <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $userItems->username; ?></td>
                            <td><?php echo $userItems->lname; ?></td>
                            <td><?php echo $userItems->role; ?></td>
                            <td>
                              <button type="button" class="btn btn-warning btn-user-edit"
                               data-role = "<?php echo $userItems->role ?>"
                               data-lname = "<?php echo $userItems->lname ?>"
                               data-username = "<?php echo $userItems->username ?>"
                               data-id = "<?php echo $userItems->uid ?>"
                               aria-label="Left Align">
                                <span class="glyphicon glyphicon-pencil"></span>
                              </button>
                              <button type="button" class="btn btn-danger btn-user-delete"
                              data-id = "<?php echo $userItems->uid ?>"
                              aria-label="Left Align">
                                <span class="glyphicon glyphicon-remove"></span>
                              </button>

                            </td>
                          </tr>
                          <?php endforeach; ?>
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
<!-- /#wrapper -->

<!-- jQuery -->
<script src="/assets/js/jquery-2.2.2.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/assets/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="/assets/js/metisMenu.min.js"></script>

<!-- DataTables JavaScript -->
<script src="/assets/js/jquery.dataTables.min.js"></script>
<script src="/assets/js/dataTables.bootstrap.min.js"></script>


<!-- Custom Theme JavaScript -->
<script src="/assets/js/sb-admin-2.js"></script>

<script src="/assets/app/user.js"></script>
