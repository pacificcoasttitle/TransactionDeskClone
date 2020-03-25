<body>
	<?php
	    $this->load->view('layout/header_dashboard');
	?>
	
        <div class="rtd typography-page">
          <div class="typography-section typography-section-border">
            <div class="container">
              <div class="row">
                <div class="col-xs-12">
                 <!--  <h2 class="typography-title">Tables</h2> -->
                  <div class="table-container">
                    <table class="table table-type-1 typography-last-elem" id="table-recordings">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Instrument #</th>
                          <th>Order #</th>                         
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>
	<?php
	    $this->load->view('layout/footer');
	?>
</body>
</html