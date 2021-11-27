<div class="statbox widget box box-shadow">
    <div class="widget-content widget-content-area">
        <small>Search Player</small>
        <?php
            Form::open([
                'method' => 'get',
                'action' => _route('dotaplayer:search')
            ]);	
        ?>
        <div class="row">
            <div class="col-md-10">
                <?php Form::text('key' , '' , ['class' => 'form-control' , 'placeholder' => 'Eg. Mircale'])?>
            </div>

            <div class="col-md-2">
                <?php Form::submit('' , 'Search Player' , ['class' => 'btn btn-primary btn-lg'])?>
            </div>
        </div>

        <br>

        <?php Form::close()?>
    </div>
</div>

<?php divider()?>