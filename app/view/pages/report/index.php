<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-12">



			<canvas id="myChart" width="900" height="200"></canvas>
			<script>
			const ctx = document.getElementById('myChart');
			const myChart = new Chart(ctx, {
			    type: 'line',
			    data: {
			        labels: [<loop>'{date}', </loop>],
			        datasets: [{
			            label: '# of Votes',
			            data: [<loop>'{collaborator}', </loop>],
			            borderColor: [
			                'rgba(255, 99, 132, 1)',
			                'rgba(0, 0, 0, 1)',
			                'rgba(255, 206, 86, 1)',
			                'rgba(75, 192, 192, 1)',
			                'rgba(153, 102, 255, 1)',
			                'rgba(255, 159, 64, 1)'
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
