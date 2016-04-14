<?php
$this->load->view('admin/spravy', null);
?>
<div class="btn-toolbar">
    <a href="<?php echo site_url('admin/spravapouzivatelov/uprava') ?>" > <button class="btn btn-primary">Pridat noveho pouzivatela</button></a> 
</div>
<div class="well">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Nick</th>
                <th>Email</th>
                <th>Opravnenie</th>
                <th>Posledne prihlasenie</th>
                <th style="width: 36px;" ></th>
            </tr>
        </thead>
        <tbody>
            
            <?php
               if (is_array($data) && count($data)>0 ){
            foreach ($data as $row) {
                if ($row->admin_permission != 1 || $prihlaseny_user->admin_permission == 1) {
                    
                    ?>
                <tr class="">
                    <td><?php echo $row->username; ?></td>

                    <td><?php echo $row->email; ?></td>
                    <?php
                    if ($row->admin_permission == 1) {
                        if ($prihlaseny_user->admin_permission == 1) {
                            ?>
                            <td><a href="<?php echo site_url('admin/spravapouzivatelov/uprava/' . $row->id); ?>" ><i class="icon-wrench"></i> <?php echo $row->admin_permission_nazov; ?></a></td>
                        <?php } else { ?>
                            <td><?php echo $row->admin_permission_nazov; ?></td>
                        <?php
                        }
                    } else {
                        ?>
                        <td><a href="<?php echo site_url('admin/spravapouzivatelov/uprava/' . $row->id); ?>" ><i class="icon-wrench"></i> <?php echo $row->admin_permission_nazov; ?></a></td> 
                    <?php }
                    ?>

                    <td class="center"><?php echo formatCasu($row->last_login); ?></td>
                    <td>
                        <?php
                        if ($row->admin_permission == 1) {
                            if ($prihlaseny_user->admin_permission == 1) {
                                ?>
                                <a href="<?php echo site_url('admin/spravapouzivatelov/uprava/' . $row->id); ?>" ><i class="icon-pencil"></i></a>
                                <a onclick="return ozaj('Naozaj chcete odstrániť tohoto pouzivatela?');" href="<?php echo site_url('admin/spravapouzivatelov/zmazat/' . $row->id); ?>" ><i class="icon-trash"></i></a>
                        <?php } else { ?>
                            <td></td>   
                        <?php
                        }
                    } else {
                        ?>
                <a href="<?php echo site_url('admin/spravapouzivatelov/uprava/' . $row->id); ?>" ><i class="icon-pencil"></i></a>

                <a onclick="return ozaj('Naozaj chcete odstrániť tohoto pouzivatela?');" href="<?php echo site_url('admin/spravapouzivatelov/zmazat/' . $row->id); ?>" ><i class="icon-trash"></i></a>
    <?php }
    ?>


            </td>
            </tr>

            <?php } }}else{ ?>
                <tr><td colspan="5" style="text-align: center;"><i><?php echo lang('a_empty_table'); ?></i></td></tr>
          <?php  } ?>
        </tbody>
    </table>
</div>
<div class="clear"></div>


