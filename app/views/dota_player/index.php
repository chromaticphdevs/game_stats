<?php build('content') ?>
    <?php grab('partial/dota_player_search')?>
    <?php Flash::show()?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <th>#</th>
                <th>Persona Name</th>
                <th>Avatar</th>
            </thead>

            <tbody>
                <?php foreach($users as $key => $user) :?>
                    <tr>
                        <td><?php echo ++$key?></td>
                        <td><?php echo $user->personaname?></td>
                        <td>
                            <a href="<?php echo _route('dotaplayer:show' , $user->account_id)?>"><img src="<?php echo $user->avatarfull?>" alt="Avatar"></a>
                        </td>
                    </tr>
                <?php endforeach?>
            </tbody>
        </table>
    </div>
<?php endbuild()?>
<?php loadTo('tmp/base')?>