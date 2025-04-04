

<section class="section-type-4a section-defaulta " style="padding-bottom:0px;">
	<div class="container-fluid padding-0">
			
		<div class="row mb-3">
			<div class="col-sm-6">
				<h1 class="h3 text-gray-800">Review Files </h1>
			</div>
			<div class="col-sm-6">
				<a href="javascript:void(0)" onclick="fetchPrelimDocument();"  class="btn btn-success btn-icon-split float-right mr-2"> 
					<span class="icon text-white-50">
						<i class="fas fa-refresh"></i>
					</span>
					<span class="text"> Fetch All Prelims Doc </span> 
				</a>
				
			</div>
		</div>
		<div class="card shadow mb-4">
			<div class="card-header datatable-header py-3">
				<div class="datatable-header-titles" > 
					
					<h6 class="m-0 font-weight-bold text-primary pl-10">Below are all your orders</h6> 
				</div>
			</div>
			<div class="card-body">
			<div id="prelim_success_msg" class="w-100 alert alert-success alert-dismissible" style="display:none;"></div>
            <div id="prelim_error_msg" class="w-100 alert alert-danger alert-dismissible" style="display:none;"></div>
				<div class="table-responsive">
					<table class="table table-bordered" id="prelim_files" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>#</th>
								<th>File Number</th>
								<th>Property Address</th>
								<th>Files</th>
							</tr>
						</thead>                
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
		
	</div>
</section>
