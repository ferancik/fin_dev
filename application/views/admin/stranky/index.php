<?php
$this->load->view('admin/spravy', null);
?>
<div class="btn-toolbar">
    <a href="<?php echo site_url('admin/stranky/uprava') ?>" > <button class="btn btn-primary">Pridat novu</button></a> 
</div>
<div class="well">
    
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Názov</th>
                        <th>Typ stránky</th>
                        <th>Url stránky</th>
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
                            <td><?= ($row->pevna == 1) ? 'Systémová' : "Užívatelská" ;?></td>
                            <?php if  ($row->pevna != 1) { ?>
                            <td><?php echo $row->seo_url; ?> <br /> <a target="_blank"  href="<?php echo base_url(); ?><?php echo $this->config->item('CONTROLER_PRE_OBSLUHU_UZIVATELSKYCH_STRANOK').$row->seo_url;?>" ><i class="icon-share"></i> Otvor v novom okne</a></td>
                            <?php }else{?>
                             <td>neni</td>
                            <?php }?>
                            <td class="center"><?php echo formatCasu($row->modifikacia); ?></td>
                            <td> <a href="<?php echo site_url('admin/stranky/uprava/' . $row->id); ?>" ><i class="icon-pencil"></i></a>
                                <?php if  ($row->pevna != 1 || $prihlaseny_user->admin_permission == 1) {?>
                                <a onclick="return ozaj('Naozaj chcete odstrániť túto stránku?');" href="<?php echo site_url('admin/stranky/zmazat/' . $row->id); ?>" ><i class="icon-trash"></i></a>
                                <?php } ?>
                            </td>
                        </tr>

                    <?php }  }else{ ?>
                <tr><td colspan="5" style="text-align: center;"><i><?php echo lang('a_empty_table'); ?></i></td></tr>
          <?php  } ?>
                    
                </tbody>

            </table>
    </div>
            <div class="clear"></div>

