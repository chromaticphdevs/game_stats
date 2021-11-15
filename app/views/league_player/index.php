<?php build('content') ?>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="w-img">
                            <img src="https://thumbs.dreamstime.com/b/businessman-vector-icon-avatar-sign-man-business-suit-male-face-flat-design-man-avatars-profile-concept-concept-boss-85517342.jpg" 
                            alt="avatar" style="width:100%">
                        </div>
                        <div class="media-body">
                            <h6>FAKER</h6>
                            <p class="meta-date-time">Challenger</p>
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
                                <?php foreach($matches_with_remarks as $index => $matches_with_remark): ?>
                                    <?php
                                        $counter++;
                                        if( $counter > 5) break;
                                        $remarks = $matches_with_remark->remarks;
                                    ?>

                                    <tr>
                                        <td><?php echo $counter?></td>
                                        <td>
                                            <div class="media">
                                                <div class="w-img">
                                                    <img src="<?php echo $imgSrc.$index.'.png'?>" 
                                                    alt="avatar" style="width:100%">
                                                </div>
                                                <div class="media-body">
                                                    <h6><?php echo $index?></h6>
                                                </div>
                                            </div>
                                            <td>
                                                <?php
                                                    $lose = $remarks->total_matches - $remarks->wins;
                                                    echo ("
                                                        {$remarks->win_rate}% {$remarks->wins}W {$lose}L
                                                    ");
                                                ?>
                                            </td>
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
                        <th>HERO</th>
                        <th>KDA</th>
                    </thead>

                    <tbody>
                        <?php foreach($matches as $match):?>
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="w-img">
                                            <img src="<?php echo $imgSrc.$match->name.'.png'?>" 
                                            alt="avatar" style="width:100%">
                                        </div>
                                        <div class="media-body">
                                            <h6><?php echo $match->name?></h6>
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