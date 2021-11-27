<?php build('content') ?>
    <?php grab('partial/dota_player_search')?>
    <?php Flash::show()?>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="w-img">
                            <img src="<?php echo $user->profile->avatarfull?>" 
                            alt="avatar" style="width:100%">
                        </div>
                        <div class="media-body">
                            <h6><?php echo $user->profile->personaname?></h6>
                        </div>
                    </div>

                    <?php divider()?>
                    <p>Stats For Recent 20 games</p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>#</th>
                                <th>Hero</th>
                                <th>Remarks</th>
                            </thead>

                            <tbody>
                                <?php $counter = 0?>
                                <?php foreach($match_summaries as $index => $match): ?>
                                    <?php if( $index >= 5) break?>
                                    <tr>
                                        <td><?php echo ++$counter?></td>
                                        <td>
                                            <div class="media">
                                                <div class="w-img">
                                                    <img src="<?php echo $dota->getHeroImageUrl($match['name'])?>" 
                                                    alt="avatar" style="width:100%">
                                                </div>
                                                <div class="media-body">
                                                    <h6><?php echo $match['localized_name']?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                                $wins = $match['wins'];
                                                $matches = $match['total'];
                                                $lose = $matches - $wins;
                                                $win_rate = round(($wins / $matches) * 100 , 2);

                                                echo ("
                                                    {$win_rate}% {$wins}W {$lose}L
                                                ");
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-bordered dataTable">
                    <thead>
                        <th>#</th>
                        <th>HERO</th>
                        <th>KDA</th>
                    </thead>

                    <tbody>
                        <?php $counter = 0?>
                        <?php foreach($recent_matches as $match):?>
                            <?php $counter++?>
                            <tr>
                                <td><?php echo $counter?></td>
                                <td>
                                    <div class="media">
                                        <div class="w-img">
                                            <img src="<?php echo $dota->getHeroImageUrl($match->hero_name)?>" 
                                            alt="avatar" style="width:100%">
                                        </div>
                                        <div class="media-body">
                                            <h6><?php echo $match->localized_name?></h6>
                                            <p class="meta-date-time">
                                                <?php if($match->win) :?>
                                                    <span class="badge badge-success">Win</span>
                                                <?php else:?>
                                                    <span class="badge badge-danger">Lose</span>
                                                <?php endif?>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                        echo ("{$match->kills}/{$match->deaths}/{$match->assists}");
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endbuild()?>

<?php build('styles')?>
    <style>
        .media-body
        {
            margin-right: 15px;
        }
    </style>
<?php endbuild()?>

<?php loadTo('tmp/base')?>