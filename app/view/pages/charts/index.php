<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-12">

			<div class="row">
				<div class="col-6">
				Choose Excel:
					<form class="d-inline" action="/report/app/model/excel.php" method="post" enctype="multipart/form-data">
						<input type="file" name="excel" value="">
						<input type="submit" name="submit" value="submit">
					</form><br>
				</div>

				<div class="col-6">
					<label>Start</label>
					<input type="text" name="startperiod" class="startperiod">
					<label>End</label>
					<input type="text" name="startperiod" class="endperiod">
					<input type="submit" name="submit" value="Go" onclick="gochart()" class="btn bg-dark text-white"><br>
				</div>
			</div>

				<script type="text/javascript">
					function gochart(){
						var startperiod = $('.startperiod').val();
						var endperiod = $('.endperiod').val();
						//alert(startperiod);
						window.location.replace("http://localhost:8888/report/charts/item/"+startperiod+'xxx'+endperiod+"/1");
					}
				</script>

			<?php
				$conn = db();

				// DATAS
				$datas = '';
				$x = 0;

				if(isset($_GET['id'])){
					$period_get = $_GET['id'];
					$startperiod = explode("xxx", $period_get);
					$startperiod = $startperiod[0];

					$endperiod = explode("xxx", $period_get);
					$endperiod = $endperiod[1];

					$period_date = $startperiod;
				} else {
					$startperiod = '2021-01-01';
					$endperiod = date("Y-m-d");
				}

				//echo 	$startperiod.'<br>'.$endperiod.'<br>';
				//echo '<h1 style="color:#000 !important;">'.$startperiod.'<br>'.$endperiod.'</h1><br><br><br><br><br>';
				//echo '<h1 style="color:#000 !important;">'.$testget.'</h1><br><br><br><br><br>';


				$last_fetch = $startperiod;
				$period = "'$period_date'";

				$last_collaborator = 'jl';

				$countdays = 0;
				foreach($conn->query("SELECT date, collaborator, id FROM charts WHERE date BETWEEN '".$startperiod."' AND '".$endperiod."' ORDER BY date ASC") as $row) {
					$fetch	= $row['date'];
					$collaborator	= $row['collaborator'];
					$id	= $row['id'];
					if($fetch == $last_fetch){
						if($collaborator == 'Ector'){
								$x++;
						} elseif($last_collaborator == 'Ector' AND $x < 1){
								$x++;
						}
					} else {
						$datas .= "'$last_fetch' , ";
						if($collaborator == 'Ector'){
							$x = 1;
						} else {
							$x = 0;
						}
					}
					$last_fetch = $fetch;
					$last_collaborator = $collaborator;
					$countdays++;
				}
				$datas = rtrim($datas, ", ");


				// TRENDLINE
				$datas_count = array($datas);
				$exploded_datas_count = explode(",", $datas_count[0]);
				$count_datas_count = count($exploded_datas_count);
				// echo $count_datas_count;

				$count_datas_count_divided = round($count_datas_count/4);
				//echo $count_datas_count_divided;

				$count_datas_part1_start = 0;
				$count_datas_part1_end = $count_datas_count_divided;

				$count_datas_part2_start = $count_datas_count_divided;
				$count_datas_part2_end = ($count_datas_count_divided*2);

				$count_datas_part3_start = ($count_datas_count_divided*2);
				$count_datas_part3_end = ($count_datas_count_divided*3);

				$count_datas_part4_start = ($count_datas_count_divided*3);
				$count_datas_part4_end = ($count_datas_count_divided*4);

				//echo $count_datas_part1_start.'  -  '.$count_datas_part1_end.'<br>';
				//echo $count_datas_part2_start.'  -  '.$count_datas_part2_end.'<br>';
				//echo $count_datas_part3_start.'  -  '.$count_datas_part3_end.'<br>';
				//echo $count_datas_part4_start.'  -  '.$count_datas_part4_end.'<br>';
				//echo $endperiod_part1.'<br>';


				if(isset($_GET['id'])){
					$period_get = $_GET['id'];
					$startperiod = explode("xxx", $period_get);
					$startperiod = $startperiod[0];
				} else {
					$startperiod = '2021-01-01';
				}

				$startperiod_new = date_create($startperiod);
				$startperiod_part1 = date_add($startperiod_new,date_interval_create_from_date_string($count_datas_part1_start." days"));
				$startperiod_part1 = date_format($startperiod_part1,"Y-m-d");
				if(isset($_GET['id'])){
					$period_get = $_GET['id'];
					$startperiod = explode("xxx", $period_get);
					$startperiod = $startperiod[0];
				} else {
					$startperiod = '2021-01-01';
				}
				$startperiod_new = date_create($startperiod);
				$endperiod_part1 = date_add($startperiod_new,date_interval_create_from_date_string($count_datas_part1_end." days"));
				$endperiod_part1 = date_format($startperiod_new,"Y-m-d");
				$count_jobs_part_1 = 0;
				foreach($conn->query("SELECT id FROM charts WHERE date BETWEEN '".$startperiod_part1."' AND '".$endperiod_part1."' ORDER BY date ASC") as $row) {
					$count_jobs_part_1++;
				}


				if(isset($_GET['id'])){
					$period_get = $_GET['id'];
					$startperiod = explode("xxx", $period_get);
					$startperiod = $startperiod[0];
				} else {
					$startperiod = '2021-01-01';
				}

				$startperiod_new = date_create($startperiod);
				$startperiod_part2 = date_add($startperiod_new,date_interval_create_from_date_string($count_datas_part2_start." days"));
				$startperiod_part2 = date_format($startperiod_part2,"Y-m-d");

				if(isset($_GET['id'])){
					$period_get = $_GET['id'];
					$startperiod = explode("xxx", $period_get);
					$startperiod = $startperiod[0];
				} else {
					$startperiod = '2021-01-01';
				}
				$startperiod_new = date_create($startperiod);
				$endperiod_part2 = date_add($startperiod_new,date_interval_create_from_date_string($count_datas_part2_end." days"));
				$endperiod_part2 = date_format($startperiod_new,"Y-m-d");
				$count_jobs_part_2 = 0;
				foreach($conn->query("SELECT id FROM charts WHERE date BETWEEN '".$startperiod_part2."' AND '".$endperiod_part2."' ORDER BY date ASC") as $row) {
					$count_jobs_part_2++;
				}


				if(isset($_GET['id'])){
					$period_get = $_GET['id'];
					$startperiod = explode("xxx", $period_get);
					$startperiod = $startperiod[0];
				} else {
					$startperiod = '2021-01-01';
				}

				$startperiod_new = date_create($startperiod);
				$startperiod_part3 = date_add($startperiod_new,date_interval_create_from_date_string($count_datas_part3_start." days"));
				$startperiod_part3 = date_format($startperiod_part3,"Y-m-d");

				if(isset($_GET['id'])){
					$period_get = $_GET['id'];
					$startperiod = explode("xxx", $period_get);
					$startperiod = $startperiod[0];
				} else {
					$startperiod = '2021-01-01';
				}
				$startperiod_new = date_create($startperiod);
				$endperiod_part3 = date_add($startperiod_new,date_interval_create_from_date_string($count_datas_part3_end." days"));
				$endperiod_part3 = date_format($startperiod_new,"Y-m-d");
				$count_jobs_part_3 = 0;
				foreach($conn->query("SELECT id FROM charts WHERE date BETWEEN '".$startperiod_part3."' AND '".$endperiod_part3."' ORDER BY date ASC") as $row) {
					$count_jobs_part_3++;
				}


				if(isset($_GET['id'])){
					$period_get = $_GET['id'];
					$startperiod = explode("xxx", $period_get);
					$startperiod = $startperiod[0];
				} else {
					$startperiod = '2021-01-01';
				}

				$startperiod_new = date_create($startperiod);
				$startperiod_part4 = date_add($startperiod_new,date_interval_create_from_date_string($count_datas_part4_start." days"));
				$startperiod_part4 = date_format($startperiod_part4,"Y-m-d");

				if(isset($_GET['id'])){
					$period_get = $_GET['id'];
					$startperiod = explode("xxx", $period_get);
					$startperiod = $startperiod[0];
				} else {
					$startperiod = '2021-01-01';
				}
				$startperiod_new = date_create($startperiod);
				$endperiod_part4 = date_add($startperiod_new,date_interval_create_from_date_string($count_datas_part4_end." days"));
				$endperiod_part4 = date_format($startperiod_new,"Y-m-d");
				$count_jobs_part_4 = 0;
				foreach($conn->query("SELECT id FROM charts WHERE date BETWEEN '".$startperiod_part4."' AND '".$endperiod_part4."' ORDER BY date ASC") as $row) {
					$count_jobs_part_4++;
				}

				echo $count_jobs_part_1.'<br>';
				echo $count_jobs_part_2.'<br>';
				echo $count_jobs_part_3.'<br>';
				echo $count_jobs_part_4.'<br>';

				$count_total = ($count_jobs_part_1+$count_jobs_part_2+$count_jobs_part_3+$count_jobs_part_4);

				$pencentage_1 = (100-($count_jobs_part_1*100)/$count_total);
				$pencentage_2 = (100-($count_jobs_part_2*100)/$count_total);
				$pencentage_3 = (100-($count_jobs_part_3*100)/$count_total);
				$pencentage_4 = (100-($count_jobs_part_4*100)/$count_total);




				// JOBS
				$collaborators = array('Ector', 'Tati', 'Luan', 'Filipe', 'Vitor' );
				$colors = array('rgba(255, 0, 0, 1)', 'rgba(0, 0, 200, 1)', 'rgba(0, 200, 0, 1)', 'rgba(0, 0, 0, 1)', 'rgba(247, 147, 30, 1)');

				$conn = db();

				$result = '';
				$colorscount = 0;
				foreach ($collaborators as $collname) {

					$result = $result."
					{
							label: '$collname',
							data: [";

					$x = 0;
					$last_collaborator = 'jl';

					foreach($conn->query("SELECT date, collaborator, id FROM charts WHERE date > $period ORDER BY date ASC") as $row) {
						$fetch	= $row['date'];
						$collaborator	= $row['collaborator'];
						$id	= $row['id'];
						if($fetch == $last_fetch){
							if($collaborator == $collname){
									$x++;
							} elseif($last_collaborator == $collname AND $x < 1){
									$x++;
							}
						} else {
							$result .= "'$x' , ";
							if($collaborator == $collname){
								$x = 1;
							} else {
								$x = 0;
							}
						}
						$last_fetch = $fetch;
						$last_collaborator = $collaborator;
					}
					//$result = rtrim($result, ", ");


					$result = "$result],
							borderColor: [
									'$colors[$colorscount]'
							],
							borderWidth: 1,
					},";

					$colorscount++;

				}



				// TOTAL SUM

				$last_fetch = $startperiod;
				$period = "'$period_date'";

				$result = $result."
				{
						label: 'Tudo',
						data: [";

				$x = 0;
				$last_collaborator = 'jl';

				foreach($conn->query("SELECT date, collaborator, id FROM charts WHERE date > $period ORDER BY date ASC") as $row) {
					$fetch	= $row['date'];
					$collaborator	= $row['collaborator'];
					$id	= $row['id'];

					if($fetch == $last_fetch){

						foreach ($collaborators as $collabs) {
							if($collaborator == $collabs ){
								$x++;
							}
						}


					} else {
						$result .= "'$x' , ";
						$x = 1;
					}
					$last_fetch = $fetch;
				}
				//$result = rtrim($result, ", ");


				$result = "$result],
						borderColor: [
								'rgba(128, 128, 128, 1)'
						],
						borderWidth: 1,
						trendlineLinear: {
                style: 'rgba(255,105,180, .8)',
                lineStyle: 'solid',
                width: 1
            }
				},";




				$result = rtrim($result, ",");
			?>

			<style type="text/css">
				.trendline{
					width: 94%;
					height: 75%;
					margin-left: 3%;
					margin-top:-1%;
					background-color: #000;
					position: absolute;
					opacity: 0.1;

					clip-path: polygon(0% <?=$pencentage_1?>%, 25% <?=$pencentage_2?>%, 75% <?=$pencentage_3?>%, 100% <?=$pencentage_4?>%, 100% 100%, 0% 100%);
				}
			</style>

			<div class="trendline">
			</div>

			<canvas id="myChart" width="900" height="380"></canvas>
			<script>
			const ctx = document.getElementById('myChart');
			const myChart = new Chart(ctx, {
			    type: 'line',
					tension: 0.1,
			    data: {
			        labels: [<?=$datas?>],
			        datasets: [<?=$result?>
							]},
			    options: {
			        scales: {
			            y: {
			                beginAtZero: true
			            }
			        }
			    }
			});
			</script>

		</div>
	</div>
</div>
