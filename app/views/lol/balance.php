<?php build('content')?>
	<div class="container">
		<h4>Top Five</h4>
		<div class="table-responsive">
			<?php $counter = 1?>
			<table class="table table-bordered">
				<thead>
					<th>#</th>
					<th>Hero</th>
                    <th>Type</th>
					<th>Pick Rate</th>
					<th>Win Rate</th>
					<th>Lose Rate</th>
                    <th>Current</th>
					<th>Balance</th>
				</thead>

				<tbody>
					<?php foreach($balances as $key => $row) :?>
                        <?php if(is_null($row)) continue?>
                        <?php 
							$isRevamped = isset($row->revamp);
							
							if($isRevamped)
							$revampKeys = array_keys((array) $row->revamp->stats );
							
						?>
						<tr>
							<td><?php echo $counter++?></td>
							<td><?php echo $row->championName?></td>
                            <td>
                                <?php echo wWrapSpan($row->tags)?>
                            </td>
							<td><?php echo $row->pickRate .'%'?></td>
							<td><?php echo $row->winLoseRate->win .'%'?></td>
							<td><?php echo $row->winLoseRate->lose .'%'?></td>
							<td>
                                <ul class="list-unstyled">
                                <?php foreach($revampKeys as $rVampKey => $rVampValue):?>
                                    <li><?php echo "[{$rVampValue}] = {$row->stats->$rVampValue}";?></li>
                                <?php endforeach?>
                                </ul>
                            </td>
                            <td>
								<?php if( $isRevamped ) :?>
                                <ul class="list-unstyled">
                                    <?php foreach($revampKeys as $rVampKey => $rVampValue):?>
                                        <li>
											<?php echo "[{$rVampValue}] = {$row->revamp->stats->$rVampValue}";?>
										</li>
                                    <?php endforeach?>
                                </ul>
                                <span class="badge badge-<?php echo isEqual($row->revamp->type , 'nerf') ? 'danger':'primary' ?>">
									<?php echo $row->revamp->type?>
								</span>
								<?php else:?>
									<p>Un touched</p>
								<?php endif?>
                            </td>
						</tr>
					<?php endforeach?>
				</tbody>
			</table>
		</div>
	</div>
<?php endbuild()?>
<?php loadTo('tmp/base')?>