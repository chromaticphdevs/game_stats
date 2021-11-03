<?php
    extract($data);
    
?>
<?php if( isset($champions) && !empty($champions)) :?>
<div class="">
    <!-- PASS DATA STRUCTURE ['imageSrc' => 'linkToImage' , 'name' => 'name' , 'tags' => ['array'] // string] -->
    <div class="row">
        <?php foreach($champions as $champion) :?>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <img src="<?php echo $imgSrc.$champion->name.'.png'?>" alt="">
                    </div>
                    <div class="card-footer">
                        <h4 class="card-title"><?php echo $champion->name?></h4>
                        <div class="card-text"><?php echo wWrapSpan($champion->tags)?></div>
                    </div>
                </div>
            </div>
        <?php endforeach?>
        
    </div>
</div>
<?php endif?>