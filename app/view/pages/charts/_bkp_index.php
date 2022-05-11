<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-12">

				<label>Start</label><br>
				<input type="text" name="startperiod" class="startperiod"><br>
				<label>End</label><br>
				<input type="text" name="startperiod" class="endperiod"><br><br>
				<input type="submit" name="submit" value="Go" onclick="gochart()" class="btn bg-dark text-white"><br>

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
				}
				$datas = rtrim($datas, ", ");


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
							borderWidth: 1
					},";

					$colorscount++;

				}

				$result = rtrim($result, ",");
			?>



			<canvas id="myChart" width="900" height="200"></canvas>
			<script>
			const ctx = document.getElementById('myChart');
			const myChart = new Chart(ctx, {
			    type: 'line',
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
