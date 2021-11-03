<?php build('content')?>
	<div class="container">
		<h4>Top Five</h4>
		<div class="table-responsive">
			<?php $counter = 1?>
			<table class="table table-bordered">
				<thead>
					<th>#</th>
					<th>Hero</th>
					<th>Pick Rate</th>
					<th>Win Rate</th>
					<th>Lose Rate</th>
					<th>Balance</th>
				</thead>

				<tbody>
					<?php foreach($topFivePopular as $key => $row) :?>
						<tr>
							<td><?php echo $counter++?></td>
							<td><?php echo $key?></td>
							<td><?php echo $row->pickRate .'%'?></td>
							<td><?php echo $row->winLoseRate->win .'%'?></td>
							<td><?php echo $row->winLoseRate->lose .'%'?></td>
							<td>NERF/BUFF</td>
						</tr>
					<?php endforeach?>

					<tr>
						<td>
							<a href="<?php echo _route('leagueBalancer:index')?>" 
								class="btn btn-primary btn-lg">Balance</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<h4>All Champions</h4>
		<?php grab('lol/partial/champions' , ['champions' => $champions ?? [] , 'imgSrc' => $imageSrc])?>
	</div>
<?php endbuild()?>
<?php loadTo('tmp/base')?>