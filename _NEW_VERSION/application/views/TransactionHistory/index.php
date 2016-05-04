<div class="row">
        <!-- Search Bar -->
        <div class="col-lg-4">
            <div class="input-group">
              <input id="searchterm" type="text" class="form-control" placeholder="Enter Receipt Code, Username, Lastname, or Role..." required="required">
              <span class="input-group-btn">
                <button id="search" class="btn btn-default" onclick="searchForReceipt()">Find</button>
              </span>
            </div>
          </div>
          <!-- Date Search -->
          <div class="col-lg-4">
          	<!-- From -->
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon" id="from-addon">From</span>
              <input id="datefrom" type="text" placeholder="DD/MM/YYYY" class="form-control" aria-describedby="from-addon">
              <!--<span class="input-group-addon glyphicon glyphicon-th" id="calendar-addon-from"></span>-->
            </div>
          </div>
          <div class="col-lg-4">
            <!-- To -->
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon" id="to-addon">To</span>
              <input id="dateto" type="text" placeholder="DD/MM/YYYY" class="form-control" aria-describedby="to-addon">
              <!--<span class="input-group-addon glyphicon glyphicon-th"></span>-->
            </div>
          </div>

        <hr />

        <!-- Search Results -->
        <div class="panel panel-default">
          <div class="panel-heading">Search Results-</div>
          <table class="table table-bordered">
	        <tr>
	          <th>Staff</th>
	          <th>Receipt Number</th>
	          <th>Transaction Date</th>
	          <th>Total Amount</th>
	          <th>Action</th>
	        </tr>
	        <tbody id="searchresults">
	          <!-- Replace Content -->
	        </tbody>
	      </table>
      </div>
      <div id="btn-container"></div>

      <!-- Modal -->
      <div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-labelledby="receiptHead">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="receiptHead">Replace with title</h4>
            </div>
            <div class="modal-body">
              <table class="table table-bordered">
              	<tr>
              	  <th><strong>Barcode</strong></th>
              	  <th><strong>Brand</strong></th>
              	  <th><strong>Product</strong></th>
              	  <th><strong>Price</strong></th>
              	  <th><strong>Quantity</strong></th>
              	  <th><strong>Total</strong></th>
              	</tr>
              	<tbody id="transactionresults">
              	  <!-- Replace Content -->
              	</tbody>
             	</table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>

      <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->

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

      <script src="/assets/js/bootstrap.min.js"></script>
      <script src="/assets/js/bootstrap-datepicker.js"></script>
      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <script src="/assets/js/ie10-viewport-bug-workaround.js"></script>

      <script src="/assets/app/transactionhistory.js"></script>
