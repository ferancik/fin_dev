<?
$this->load->view('admin/spravy', null);
?>
<div class="btn-toolbar">
    <a href="<?php echo site_url('admin/adminwebmenuall/uprava/') ?>" > <button class="btn btn-primary">Pridat novy typ menu</button></a> 
</div>
<div class="well">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Identifikator</th>
                <th>Popis</th>
                <th>Menu manager</th>
                <th style="width: 36px;" ></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (is_array($data)){
            foreach ($data as $row) { ?>
                <tr class="">
                    <td><?php echo $row->identifikator; ?></td>
                    <td><?php echo $row->popis; ?></td>
                     <td> <a href="<?php echo site_url('admin/adminwebmenu/zobraz/' . $row->id); ?>" ><i class="icon-pencil"></i> Otvor</a></td>
                    <td>
                       
                        <a href="<?php echo site_url('admin/adminwebmenuall/uprava/' . $row->id); ?>" ><i class="icon-pencil"></i></a>

                        <a onclick="return ozaj('Naozaj chcete odstrániť tento typ menu?\n');" href="<?php echo site_url('admin/adminwebmenuall/zmazat/' . $row->id); ?>" ><i class="icon-trash"></i></a>

                    </td>
                </tr>

            <?php }
            
            }else{ ?>
                <tr><td colspan="4" style="text-align: center;"><i><?php echo lang('a_empty_table'); ?></i></td></tr>
          <?php  } ?>

        </tbody>
    </table>
</div>
<div class="clear"></div>



