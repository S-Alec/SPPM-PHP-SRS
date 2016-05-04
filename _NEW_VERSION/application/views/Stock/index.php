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
                        <?php foreach ($stocks as $index=>$stockItems): ?>
                        <?php
                        echo '<tr class="odd gradeX" id="'.$stockItems->pid.'">'
                       .'<td>'.$stockItems->barcode.'</td>'
                       .'<td>'.$stockItems->pname.'</td>'
                       .'<td>'.$stockItems->description.'</td>'
                       .'<td>'.$stockItems->brand.'</td>'
                        .'<td>'.$stockItems->category.'</td>'
                        .'<td>'.$stockItems->stockamount.'</td>'
                        .'<td>'.number_format($stockItems->salesprice,2, '.', '').'</td>'
                       .'<td>'
                              .'<button class="btn btn-default btn-stock-edit"
                              data-barcode="'.$stockItems->barcode.'"
                              data-pname="'.$stockItems->pname.'"
                              data-brand="'.$stockItems->brand.'"
                              data-category="'.$stockItems->category.'"
                              data-description="'.$stockItems->description.'"
                              data-quantity="'.$stockItems->stockamount.'"
                              data-salesprice="'.number_format($stockItems->salesprice,2, '.', '').'"
                              data-pid="'.$stockItems->pid.'"
                              >Edit</button> &nbsp;'
                              .'<button class="btn btn-default btn-stock-delete" data-pid="'.$stockItems->pid.'">Delete</button>'
                          .'</td>'
                       .'</tr>';
                        ?>
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

<script src="/assets/app/stock.js"></script>
