<body>
	<?php
        $this->load->view('layout/header_dashboard');
    ?>
	<style type="text/css">
		th {
			text-align: center;
		}

        .chart-container {
            background-color: #f8f6f6;
            border: 1px solid rgba(000, 000, 000, 0.15);
            margin-bottom: 50px;
        }
    
	</style>
	<section class="section-type-4a section-defaulta" style="padding-bottom:0px;">
		<div class="container">
			<div class="row">
				<div class="row">
					<div class="col-xs-12">
                        <div class="typography-section__inner">
							<h2 class="ui-title-block ui-title-block_light">Trends</h2>
							<div class="ui-decor-1a bg-accent"></div>
							<?php if(!empty($salesUsers) && $is_sales_rep_manager == 1) { ?>
								<div id="sales_user_listing">
									<label>
										<select style="width:auto;" name="sales_user_filter" id="sales_user_filter" class="custom-select custom-select-sm form-control form-control-sm"> 
											<option value="all"> All Sales Rep Users </option>
											<?php foreach($salesUsers as $salesUser) { ?>
												<option <?Php echo ($user_id == $salesUser['id']) ? 'selected' : '';?> value="<?php echo $salesUser['id'];?>"><?php echo $salesUser['first_name']." ".$salesUser['last_name'];?></option>
											<?php }?>
										</select>
									</label>
								</div>
							<?php } ?>
						</div>  
                        
						<div class="typography-sectiona">
							<div class="col-md-12 chart-container">
								<div class="card shadow mb-4">
									<!-- Card Header - Dropdown -->
									<div
										class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
										<h3 class="m-0 font-weight-bold text-primary">Title Openings MTD Overview</h3>
										
									</div>
									<!-- Card Body -->
									<div class="card-body">
										<div class="chart-area">
											<div class="chartjs-size-monitor">
												<div class="chartjs-size-monitor-expand">
													<div class=""></div>
												</div>
												<div class="chartjs-size-monitor-shrink">
													<div class=""></div>
												</div>
											</div>
											<canvas id="openOrdersChart"
												style="display: block; height: 320px; width: 782px;" width="977"
												height="400" class="chartjs-render-monitor"></canvas>
										</div>
									</div>
								</div>
							</div>
						</div>

                        <div class="typography-sectiona">
							<div class="col-md-12 chart-container">
								<div class="card shadow mb-4">
									<!-- Card Header - Dropdown -->
									<div
										class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
										<h3 class="m-0 font-weight-bold text-primary">Title Closings MTD Overview</h3>
										
									</div>
									<!-- Card Body -->
									<div class="card-body">
										<div class="chart-area">
											<div class="chartjs-size-monitor">
												<div class="chartjs-size-monitor-expand">
													<div class=""></div>
												</div>
												<div class="chartjs-size-monitor-shrink">
													<div class=""></div>
												</div>
											</div>
											<canvas id="closedOrderChart"
												style="display: block; height: 320px; width: 782px;" width="977"
												height="400" class="chartjs-render-monitor"></canvas>
										</div>
									</div>
								</div>
							</div>
						</div>

                        <div class="typography-sectiona">
							<div class="col-md-12 chart-container">
								<div class="card shadow mb-4">
									<!-- Card Header - Dropdown -->
									<div
										class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
										<h3 class="m-0 font-weight-bold text-primary">Title Revenue MTD Overview</h3>
										
									</div>
									<!-- Card Body -->
									<div class="card-body">
										<div class="chart-area">
											<div class="chartjs-size-monitor">
												<div class="chartjs-size-monitor-expand">
													<div class=""></div>
												</div>
												<div class="chartjs-size-monitor-shrink">
													<div class=""></div>
												</div>
											</div>
											<canvas id="premiumTotalChart"
												style="display: block; height: 320px; width: 782px;" width="977"
												height="400" class="chartjs-render-monitor"></canvas>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>

	<!-- Partners Modal -->
	<?php
        $this->load->view('layout/footer');
    ?>

</body>

</html>

<script src="<?php echo base_url(); ?>assets/plugins/chart/Chart.min.js"></script>
<script>
	
    var salesData = <?php echo json_encode($salesHistory);?>;
    var salesDataKeys =  Object.keys(salesData);
    const openOrderDataset = [];
    const closedOrderDataset = [];
    const premiumTotalDataset = [];

    for (let i= 0; i < salesDataKeys.length; i++) {
       
        const openOrdersCountForMonth = [];
        const closedOrdersCountForMonth = [];
        const premiumTotalForMonth = [];
        
        for (let index = 0; index < salesData[salesDataKeys[i]].length; index++) {
            console.log(salesData[salesDataKeys[i]]);
            console.log(salesData[salesDataKeys[i]][index].total_open_count);
            openOrdersCountForMonth.push(salesData[salesDataKeys[i]][index].total_open_count);
            closedOrdersCountForMonth.push(salesData[salesDataKeys[i]][index].total_close_count);
            premiumTotalForMonth.push(salesData[salesDataKeys[i]][index].total_premium);
        }

        openOrderDataset.push(
            {
                label: salesDataKeys[i],
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: openOrdersCountForMonth,
            }
        );
        closedOrderDataset.push(
            {
                label: salesDataKeys[i],
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: closedOrdersCountForMonth,
            }
        );
        premiumTotalDataset.push(
            {
                label: salesDataKeys[i],
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: premiumTotalForMonth,
            }
        )
    }

    
   
   
	Chart.defaults.global.defaultFontFamily = 'Nunito',
		'-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
	Chart.defaults.global.defaultFontColor = '#858796';

	function number_format(number, decimals, dec_point, thousands_sep) 
    {
		// *     example: number_format(1234.56, 2, ',', ' ');
		// *     return: '1 234,56'
		number = (number + '').replace(',', '').replace(' ', '');
		var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
			dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
			s = '',
			toFixedFix = function (n, prec) {
				var k = Math.pow(10, prec);
				return '' + Math.round(n * k) / k;
			};
		// Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}
		if ((s[1] || '').length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	}

	
	var openOrdersChart = document.getElementById("openOrdersChart");
	var openOrdersLineChart = new Chart(openOrdersChart, {
		type: 'line',
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			datasets: openOrderDataset,
		},
		options: {
			maintainAspectRatio: false,
			layout: {
				padding: {
					left: 10,
					right: 25,
					top: 25,
					bottom: 20
				}
			},
			scales: {
				xAxes: [{
					time: {
						unit: 'date'
					},
					gridLines: {
						display: false,
						drawBorder: false
					},
					ticks: {
						maxTicksLimit: 7
					}
				}],
				yAxes: [{
					ticks: {
						maxTicksLimit: 5,
						padding: 10,
					},
					gridLines: {
						color: "rgba(000, 000, 000, 0.15)",
						zeroLineColor: "rgb(234, 236, 244)",
						drawBorder: false,
						borderDash: [2],
						zeroLineBorderDash: [2]
					}
				}],
			},
			legend: {
				display: false
			},
			tooltips: {
				backgroundColor: "rgb(255,255,255)",
				bodyFontColor: "#858796",
				titleMarginBottom: 10,
				titleFontColor: '#6e707e',
				titleFontSize: 16,
				borderColor: '#dddfeb',
				borderWidth: 1,
				xPadding: 15,
				yPadding: 15,
				displayColors: false,
				intersect: false,
				mode: 'index',
				caretPadding: 10,
				callbacks: {
					label: function (tooltipItem, chart) {
						var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
						return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
					}
				}
			}
		}
	});

    var closedOrderChart = document.getElementById("closedOrderChart");
	var closedOrderLineChart = new Chart(closedOrderChart, {
		type: 'line',
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			datasets: closedOrderDataset,
		},
		options: {
			maintainAspectRatio: false,
			layout: {
				padding: {
					left: 10,
					right: 25,
					top: 25,
					bottom: 20
				}
			},
			scales: {
				xAxes: [{
					time: {
						unit: 'date'
					},
					gridLines: {
						display: false,
						drawBorder: false
					},
					ticks: {
						maxTicksLimit: 7
					}
				}],
				yAxes: [{
					ticks: {
						maxTicksLimit: 5,
						padding: 10,
					},
					gridLines: {
						color: "rgba(000, 000, 000, 0.15)",
						zeroLineColor: "rgb(234, 236, 244)",
						drawBorder: false,
						borderDash: [2],
						zeroLineBorderDash: [2],
					}
				}],
			},
			legend: {
				display: false
			},
			tooltips: {
				backgroundColor: "rgb(255,255,255)",
				bodyFontColor: "#858796",
				titleMarginBottom: 10,
				titleFontColor: '#6e707e',
				titleFontSize: 14,
				borderColor: '#dddfeb',
				borderWidth: 1,
				xPadding: 15,
				yPadding: 15,
				displayColors: false,
				intersect: false,
				mode: 'index',
				caretPadding: 10,
				callbacks: {
					label: function (tooltipItem, chart) {
						var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
						return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
					}
				}
			}
		}
	});

    var premiumTotalChart = document.getElementById("premiumTotalChart");
	var premiumTotalLineChart = new Chart(premiumTotalChart, {
		type: 'line',
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			datasets: premiumTotalDataset,
		},
		options: {
			maintainAspectRatio: false,
			layout: {
				padding: {
					left: 10,
					right: 25,
					top: 25,
					bottom: 20
				}
			},
			scales: {
				xAxes: [{
					time: {
						unit: 'date'
					},
					gridLines: {
						display: false,
						drawBorder: false
					},
					ticks: {
						maxTicksLimit: 7
					}
				}],
				yAxes: [{
					ticks: {
						maxTicksLimit: 5,
						padding: 10,
						// Include a dollar sign in the ticks
						callback: function (value, index, values) {
							return '$' + number_format(value);
						}
					},
					gridLines: {
						color: "rgba(000, 000, 000, 0.15)",
						zeroLineColor: "rgb(234, 236, 244)",
						drawBorder: false,
						borderDash: [2],
						zeroLineBorderDash: [2]
					}
				}],
			},
			legend: {
				display: false
			},
			tooltips: {
				backgroundColor: "rgb(255,255,255)",
				bodyFontColor: "#858796",
				titleMarginBottom: 10,
				titleFontColor: '#6e707e',
				titleFontSize: 14,
				borderColor: '#dddfeb',
				borderWidth: 1,
				xPadding: 15,
				yPadding: 15,
				displayColors: false,
				intersect: false,
				mode: 'index',
				caretPadding: 10,
				callbacks: {
					label: function (tooltipItem, chart) {
						var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
						return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
					}
				}
			}
		}
	});

</script>
