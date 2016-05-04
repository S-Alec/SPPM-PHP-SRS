<!-- Search Bar -->
<div class="row">
  <div class="col-lg-6">
    <div class="input-group">
      <input id="searchterm" type="text" class="form-control" placeholder="Enter Product name, barcode, category, or brand...">
      <span class="input-group-btn">
        <button id="search" class="btn btn-default" onclick="return searchForItem()">Find</button>
      </span>
    </div>
  </div>
</div>

<hr />

<!-- Search Results -->
<div class="panel panel-default">
  <div class="panel-heading">Search Results-</div>
  <table class="table table-bordered">
  <tr>
    <th>Barcode</th>
    <th>Brand</th>
    <th>Name</th>
    <th>Category</th>
    <th>Description</th>
    <th>Stock</th>
    <th>Price</th>
    <th>Action</th>
  </tr>
  <tbody id="searchresults">
    <!-- Replace Content -->
  </tbody>
</table>
</div>

<hr />
<div id="error">
</div>

<!-- Order Cart -->
<div class="panel panel-default">
  <div class="panel-heading">Order Cart-</div>
  <table id="cart" class="table table-bordered">
    <tr>
      <th class="hidden">id</th>
      <th>Barcode</th>
      <th>Brand</th>
      <th>Name</th>
      <th>Category</th>
      <th>Description</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Action</th>
    </tr>
    <!-- Insert Content -->
  </table>
  <div class="panel-footer">
    <p id="total" class="pull-right"><strong>Total:</strong> $0.00</p>
    <p></p>
  </div>
</div>

<hr />

<button id="print" class="btn btn-default pull-right" type="button" onclick="printReceipt()">Print Receipt</button>
</div> <!-- /container -->
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

<script src="/assets/app/ordertransaction.js"></script>
