<?php
$this->load->view('admin/spravy', null);

?>
<div class="btn-toolbar">
    <a href="<?php echo site_url('admin/opravneniaskupiny/uprava');?>" > <button class="btn btn-primary">Pridat novu skupinu</button></a> 
</div>
<div class="well">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Názov</th>
                        <th>Popis</th>
                        <th>Posledná zmena</th>
                        <th style="width: 36px;" ></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                       if (is_array($data) && count($data)>0 ){
                    foreach ($data as $row) { ?>
                        <tr class="">
                            <td><?php echo $row->nazov; ?></td>
                         
                             <td><?php echo $row->popis; ?></td>
                            
                            <td class="center"><?php echo formatCasu($row->time); ?></td>
                            <td>
                                <?php if ($row->id !=1){?>
                                <a href="<?php echo site_url('admin/opravneniaskupiny/uprava/' . $row->id); ?>" ><i class="icon-pencil"></i></a>
                               
                                <a onclick="return ozaj('Naozaj chcete odstrániť tieto opravnenia?')" href="<?php echo site_url('admin/opravneniaskupiny/zmazat/' . $row->id); ?>" ><i class="icon-trash"></i></a>
                                <?php }
                                ?>
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


