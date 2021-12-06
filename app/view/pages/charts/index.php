<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-12">



			<?php
				$conn = db();

				// DATAS
				$datas = '';
				$x = 0;

				$period_date = '2021-01-01';
				$last_fetch = $period_date;
				$period = "'$period_date'";
				$last_collaborator = 'jl';
				foreach($conn->query("SELECT date, collaborator, id FROM charts WHERE date > $period ORDER BY date ASC") as $row) {
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
				$collaborators = array('Ector', 'Tati', 'Luan', 'Filipe' );
				$colors = array('rgba(255, 0, 0, 1)', 'rgba(0, 0, 200, 1)', 'rgba(0, 200, 0, 1)', 'rgba(0, 0, 0, 1)');

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
