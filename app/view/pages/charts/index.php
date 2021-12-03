<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-12">



			<?php

				$conn = db();
				$result = '';
				$x = 1;
				$last_fetch = '2021-01-04';



				foreach($conn->query("SELECT date, collaborator, id FROM charts ORDER BY date ASC") as $row) {

					$fetch	= $row['date'];
					$collaborator	= $row['collaborator'];
					$id	= $row['id'];

					//echo $fetch.' --- '.$collaborator.' ---- '.$id.'<br>';


					if($fetch == $last_fetch){
						if($collaborator == 'Ector'){
							$x++;
						} 
					} else {

						$result .= "'".$last_fetch."' -- ".$x.", <br>";
						$x = 0;

					}

					if($fetch > $last_fetch AND $collaborator == 'Ector'){
						$x = 1;
					} elseif($fetch < $last_fetch AND $collaborator == 'Ector' AND $x < 1) {
						$x = 1;
					}

					$last_fetch = $fetch;

				}
					$result = rtrim($result, ", ");
					echo $result;
				?>



			<canvas id="myChart" width="900" height="200"></canvas>
			<script>
			const ctx = document.getElementById('myChart');
			const myChart = new Chart(ctx, {
			    type: 'line',
			    data: {
			        labels: [<?php	$conn = db(); $result = ''; $x = 1; $last_fetch = '2021-01-01';  foreach($conn->query("SELECT date FROM charts WHERE collaborator = 'Ector'") as $row) { $fetch	= $row['date'];  if($fetch == $last_fetch){ $x++; } else { $result .= "'".$last_fetch."', ";  $x = 1; } $last_fetch = $fetch; } $result = rtrim($result, ", "); echo $result; ?>],
			        datasets: [{
			            label: '# of Votes',
			            data: [<?php	$conn = db(); $result = ''; $x = 1; $last_fetch = '2021-01-01';  foreach($conn->query("SELECT date FROM charts WHERE collaborator = 'Ector'") as $row) { $fetch	= $row['date'];  if($fetch == $last_fetch){ $x++; } else { $result .= "'".$x."', ";  $x = 1; } $last_fetch = $fetch; } $result = rtrim($result, ", "); echo $result; ?>],
			            borderColor: [
											<?php	$conn = db(); $result = ''; $x = 1; $last_fetch = '2021-01-01';  foreach($conn->query("SELECT date FROM charts WHERE collaborator = 'Ector'") as $row) { $fetch	= $row['date'];  if($fetch == $last_fetch){ $x++; } else { $result .= "'rgba(255, 0, 0, 1)', ";  $x = 1; } $last_fetch = $fetch; } $result = rtrim($result, ", "); echo $result; ?>
			            ],
			            borderWidth: 1
			        },
							{
								label: '# of Votes',
								data: [<?php	$conn = db(); $result = ''; $x = 1; $last_fetch = '2021-01-01';  foreach($conn->query("SELECT date FROM charts WHERE collaborator = 'Tati'") as $row) { $fetch	= $row['date'];  if($fetch == $last_fetch){ $x++; } else { $result .= "'".$x."', ";  $x = 1; } $last_fetch = $fetch; } $result = rtrim($result, ", "); echo $result; ?>],
								borderColor: [
										<?php	$conn = db(); $result = ''; $x = 1; $last_fetch = '2021-01-01';  foreach($conn->query("SELECT date FROM charts WHERE collaborator = 'Tati'") as $row) { $fetch	= $row['date'];  if($fetch == $last_fetch){ $x++; } else { $result .= "'rgba(0, 0, 200, 1)', ";  $x = 1; } $last_fetch = $fetch; } $result = rtrim($result, ", "); echo $result; ?>
								],
								borderWidth: 1
						},
						{
							label: '# of Votes',
							data: [<?php	$conn = db(); $result = ''; $x = 1; $last_fetch = '2021-03-28';  foreach($conn->query("SELECT date FROM charts WHERE collaborator = 'Filipe'") as $row) { $fetch	= $row['date'];  if($fetch == $last_fetch){ $x++; } else { $result .= "'".$x."', ";  $x = 1; } $last_fetch = $fetch; } $result = rtrim($result, ", "); echo $result; ?>],
							borderColor: [
									<?php	$conn = db(); $result = ''; $x = 1; $last_fetch = '2021-03-28';  foreach($conn->query("SELECT date FROM charts WHERE collaborator = 'Filipe'") as $row) { $fetch	= $row['date'];  if($fetch == $last_fetch){ $x++; } else { $result .= "'rgba(0, 200, 0, 1)', ";  $x = 1; } $last_fetch = $fetch; } $result = rtrim($result, ", "); echo $result; ?>
							],
							borderWidth: 1
					},
					{
						label: '# of Votes',
						data: [<?php	$conn = db(); $result = ''; $x = 1; $last_fetch = '2021-01-01';  foreach($conn->query("SELECT date FROM charts WHERE collaborator = 'Luan'") as $row) { $fetch	= $row['date'];  if($fetch == $last_fetch){ $x++; } else { $result .= "'".$x."', ";  $x = 1; } $last_fetch = $fetch; } $result = rtrim($result, ", "); echo $result; ?>],
						borderColor: [
								<?php	$conn = db(); $result = ''; $x = 1; $last_fetch = '2021-01-01';  foreach($conn->query("SELECT date FROM charts WHERE collaborator = 'Luan'") as $row) { $fetch	= $row['date'];  if($fetch == $last_fetch){ $x++; } else { $result .= "'rgba(50, 50, 50, 1)', ";  $x = 1; } $last_fetch = $fetch; } $result = rtrim($result, ", "); echo $result; ?>
						],
						borderWidth: 1
				}]
			    },
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
