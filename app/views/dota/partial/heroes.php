<?php
    extract($data);
?>
<?php if( isset($heroes) && !empty($heroes)) :?>
<div class="">
    <div class="row">
        <?php foreach($heroes as $hero) :?>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <img src="<?php echo $hero->image_src?>" 
                            alt="<?php echo $hero->image_src?>" style="width: 100%;">
                    </div>
                    <div class="card-footer">
                        <h4 class="card-title"><?php echo $hero->localized_name?></h4>
                        <div class="card-text"><?php echo wWrapSpan($hero->roles)?></div>
                    </div>
                </div>
            </div>
        <?php endforeach?>
        
    </div>
</div>
<?php endif?>