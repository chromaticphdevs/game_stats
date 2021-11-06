<?php build('content')?>
	<div class="container">
		<div class="table table-responsive">
			<table class="table table-bordered">
				<thead>
					<th>Picture</th>
					<th>Name</th>
					<th>Pick Rate</th>
					<th>Win</th>
					<th>Lose</th>
				</thead>

				<tbody>
					<?php foreach($matches as $key => $match) : ?>
						<tr>
							<td>#</td>
							<td><?php echo $match->hero_detail->localized_name?></td>
							<td><?php echo $match->pickRate?>%</td>
							<td><?php echo $match->winLoseRate->win?>%</td>
							<td><?php echo $match->winLoseRate->lose?>%</td>
						</tr>
					<?php endforeach?>
				</tbody>
			</table>
		</div>

		<a href="<?php echo _route('dotaBalancer:index')?>" class="btn btn-primary">Balance</a>
		<h4>All Champions</h4>
		<?php grab('dota/partial/heroes' , ['heroes' => $heroes ?? []])?>
	</div>
<?php endbuild()?>
<?php loadTo('tmp/base')?>