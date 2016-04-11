<?php
  //Buffer larger content areas like the main page content
  require_once '../SQL/settings.php';
  require_once 'model.php';
  ob_start();
  session_start();
  //check session
  if(!$_SESSION['loggedin']['role'] === "MANAGER" )
  {
    header("location: OrderTransaction/");
  }

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

  $productModel = new ProductModel();
  $sql = $productModel->getProductList();
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Stock Management</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Stock Table
                <button class="btn btn-xs btn-default pull-right" id="btn-stock-add-new">Add New</button>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Sales Price</th>
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
                                    $return = $return.'<tr class="odd gradeX" id="'.$row['pid'].'">'
                                   .'<td>'.$row['barcode'].'</td>'
                                   .'<td>'.$row['pname'].'</td>'
                                   .'<td>'.$row['brand'].'</td>'
                                    .'<td>'.$row['category'].'</td>'
                                    .'<td>'.$row['description'].'</td>'
                                    .'<td>'.$row['stockamount'].'</td>'
                                    .'<td>'.number_format($row['salesprice'],2, '.', '').'</td>'
                                   .'<td>'
                                          .'<button class="btn btn-default btn-stock-edit"
                                          data-barcode="'.$row['barcode'].'"
                                          data-pname="'.$row['pname'].'"
                                          data-brand="'.$row['brand'].'"
                                          data-category="'.$row['category'].'"
                                          data-description="'.$row['description'].'"
                                          data-quantity="'.$row['stockamount'].'"
                                          data-salesprice="'.$row['salesprice'].'"
                                          data-id="'.$row['pid'].'
                                          ">Edit</button> &nbsp;'
                                          .'<button class="btn btn-default btn-stock-delete" data-id="'.$row['pid'].'">Delete</button>'
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
<div id="modal-stock-form" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Stock Form</h4>
          </div>
          <div class="modal-body">
                <div class="form-group">
                  <label for="email">Barcode:</label>
                  <input type="text" name="barcode" class="form-control" id="modal-txt-barcode" placeholder="Enter Barcode">
                </div>
                <div class="form-group">
                  <label for="pwd">Name:</label>
                  <input type="text" name="name" class="form-control" id="modal-txt-name" placeholder="Enter name">
                </div>
                <div class="form-group">
                  <label for="pwd">Brand:</label>
                  <input type="text" name="brand" class="form-control" id="modal-txt-brand" placeholder="Enter brand">
                </div>
                <div class="form-group">
                  <label for="pwd">Category:</label>
                  <input type="text" name="category" class="form-control" id="modal-txt-category" placeholder="Enter category">
                </div>
                <div class="form-group">
                  <label for="pwd">Description:</label>
                  <input type="text" name="description" class="form-control" id="modal-txt-description" placeholder="Enter description">
                </div>
                <div class="form-group">
                <label for="pwd">Quatity:</label>
                  <input type="text" name="description" class="form-control" id="modal-txt-quantity" placeholder="Enter quantity">
                </div>
                <div class="form-group">
                  <label for="pwd">Sales Price:</label>
                  <input type="text" name="description" class="form-control" id="modal-txt-salesprice" placeholder="Enter sales price">
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="modal-btn-stock-save">Save</button>
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
  $pagetitle = 'PHP - Stock Management';
  //Apply the template
  include '../master.php';
?>
<script src="stock.js?id=1"></script>
