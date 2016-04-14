<?
$this->load->view('admin/spravy', null);
?>	
<div class="btn-toolbar">
    <a href="<?php echo site_url('admin/fotogalerianastavenia/rozlisenie/') ?>" > <button class="btn btn-primary">Pridať nové rozlíšenie</button></a> 
</div>
<div class="well">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Názov</th>
                        <th>Šírka (x)</th>
                        <th>Výška (y)</th>
                        <th style="width: 55px;"></th>
                    </tr>
                </thead>
                <tbody> 
                    <?php 
                      if (is_array($data) && count($data)>0 ){
                    foreach ($data as $key => $row) {
                        ?>
                        <tr class="">
                            <td><?php echo $row->nazov; ?></td>
                            <td><?php echo $row->sirka; ?></td>
                            <td><?php echo $row->vyska; ?></td>
                            <td>  
                                <a href="<?php echo site_url('admin/fotogalerianastavenia/rozlisenie/' . $row->id) ;  ?>" ><i class="icon-pencil"></i></a>
                                <a onclick="return ozaj('Naozaj chcete odstrániť toto rozlíšenie ?');" href="<?php echo site_url('admin/fotogalerianastavenia/zmazat/' . $row->id); ?>" ><i class="icon-trash"></i></a>
                            </td>
                        </tr>

                    <?php } }else{ ?>
                <tr><td colspan="6" style="text-align: center;"><i><?php echo lang('a_empty_table'); ?></i></td></tr>
          <?php  } ?>
                </tbody>
            </table>	
    </div>
            <div class="clear"></div>


