<?
$this->load->view('admin/spravy', null);
?>	
<div class="btn-toolbar">
    <a href="<?php echo site_url('admin/fotogaleria/novy/') ?>" > <button class="btn btn-primary">Pridat novu galeriu</button></a> 
</div>
<div class="well">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Stručný Názov</th>
                        <th>Názov</th>

                        <th>Stručný popis</th>
                        <th>Počet fotiek</th>
                        <th style="width: 55px;"></th>
                    </tr>
                </thead>
                <tbody> 
                    <?php 
                      if (is_array($data) && count($data)>0 ){
                    foreach ($data as $key => $row) {
                        $obrazky = $this->fotogaleria->getObrazky($row->id);
                        
                        ?>
                        <tr class="">
                            <td><?php echo $row->small_nazov; ?></td>
                            <td><?php echo $row->nazov; ?></td>
                            <td><?php echo $row->small_popis; ?></td>
                            <td><?php echo (is_array($obrazky)) ? count($obrazky): $obrazky ; ?></td>  
                            <td>  
                                <a href="<?php echo site_url('admin/fotogaleria/novy/' . $row->id) ;  ?>" ><i class="icon-pencil"></i></a>
                                <a href="<?php echo site_url('admin/fotogaleria/pridajobrazky/' . $row->id); ?>" ><i class="icon-camera"></i></a>
                                 <a onclick="return ozaj('Naozaj chcete odstrániť tuto fotogaleriu ?');" href="<?php echo site_url('admin/fotogaleria/zmazat/' . $row->id); ?>" ><i class="icon-trash"></i></a>
                            </td>
                        </tr>

                    <?php } }else{ ?>
                <tr><td colspan="6" style="text-align: center;"><i><?php echo lang('a_empty_table'); ?></i></td></tr>
          <?php  } ?>
                </tbody>
            </table>	
    </div>
            <div class="clear"></div>


