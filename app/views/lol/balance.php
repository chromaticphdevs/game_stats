<?php build('content')?>
<h4>Balance Popular Heroes</h4>
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

                <?php 
                	if(is_null($row)) continue;
                	
					$isRevamped = isset($row->revamp);
					
					if($isRevamped)
					$revampKeys = array_keys((array) $row->revamp->stats );
				?>
				<tr>
					<td><?php echo $counter++?></td>
					<td>
						 <div class="user-profile">
                           <a href="<?php echo _route('league:show' , $row->championName)?>">
                           	<img src="http://ddragon.leagueoflegends.com/cdn/11.21.1/img/champion/<?php echo $row->championName?>.png">
                           </a>
                            <div class="user-meta-info">
                                <p class="user-name" data-name="<?php echo $row->championName?>"><?php echo $row->championName?>	</p>
                            </div>
                        </div>
					</td>
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
<?php endbuild()?>
<?php loadTo('tmp/base')?>