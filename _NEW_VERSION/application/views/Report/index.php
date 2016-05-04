<div class="row">
        <!-- Date Search -->
        <div class="col-lg-8">
          <div class="panel panel-default">
            <div class="panel-heading">Sales Report</div>
            <div class="panel-body">
              <div class="row">
                <!-- Date From-->
                <div class="col-lg-6">
                  <div class="input-group date" data-provide="datepicker">
                    <span class="input-group-addon" id="from-addon">From</span>
                    <input id="datefrom" type="text" placeholder="DD/MM/YYYY" class="form-control" aria-describedby="from-addon">
                    <!--<span class="input-group-addon glyphicon glyphicon-th" id="calendar-addon-from"></span>-->
                  </div>
                </div>
                <div class="col-lg-6">
                  <!-- Date To -->
                    <div class="input-group date" data-provide="datepicker">
                      <span class="input-group-addon" id="to-addon">To</span>
                      <input id="dateto" type="text" placeholder="DD/MM/YYYY" class="form-control" aria-describedby="to-addon">
                      <!--<span class="input-group-addon glyphicon glyphicon-th"></span>-->
                    </div>
                  </div>
                </div>
                <hr />
                <!-- Graph -->
                <div class="row">
                  <div class="col-lg-12">
                    <div id="graph">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
            <!-- Stock Quantities -->
            <div class="col-lg-4">
              <div class="panel panel-default">
                <div class="panel-heading">Stock Quantity</div>
                <div id="scroll" class="panel-body">
                  <ul id="stockquantity" class="list-group">
                    <!-- AJAX Request for Stock Quantity -->
                  </ul>
                </div>
                <div class="panel-footer">
                   <button class="btn btn-info btn-group-justified" type="button" onclick="downloadCSVFile()">
                      <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Create CSV File</button>
                </div>
              </div>
            </div>
        </div>
      </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap-datepicker.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/assets/js/ie10-viewport-bug-workaround.js"></script>

    <!-- Morris.js Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="/assets/js/sb-admin-2.js"></script>


    <script src="/assets/app/report.js"></script>
