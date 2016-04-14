<?
$this->load->view('admin/spravy', null);
?>
<div class="btn-toolbar">
       <a href="<?php echo base_url() . 'admin/platobnemoduly/skrill_logy'?>" style="margin-right: 10px;" > <button class="btn btn-primary"><i class=" icon-list-alt icon-white"></i> Zobrazit logy</button></a> 
    <a href="<?php echo base_url() . 'admin/platobnemoduly/skrill_nastavenia'?>" style="margin-right: 10px;" > <button class="btn btn-primary"><i class="icon-wrench icon-white"></i> Skrill nastavenia</button></a> 
    <a href="<?php echo base_url() . 'admin/platobnemoduly/skrill_pevne_platby_uprava'?>" > <button class="btn btn-primary"><i class="icon-plus icon-white"></i> Pridat novu platbu</button></a>
</div>
<div class="well">
    
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Identifikator</th>
                        <th>Popis</th>
                        <th>Nazov polozky (skrill)</th>
                        <th>Popis polozky (skrill)</th>
                        <th>Cena</th>
                        <th>Mena</th>
                        <th style="width: 36px;" ></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                      if (is_array($data) && count($data)>0 ){
                    foreach ($data as $row) { ?>
                        <tr class="">
                            <td><?php echo $row->identifikator; ?></td>
                            <td><?php echo $row->popis; ?></td>
                             <td><?php echo $row->detail1_description; ?></td>
                            <td><?php echo $row->detail1_text; ?></td>
                           
                             <td><?php echo $row->amount; ?></td>
                           <?php if (isset($row->currency) && $row->currency!=''){ ?>
                            <td><?php echo $row->currency; ?></td>
                           <?php }else{?>
                            <td>pouzije sa defaultna z:<br />
                                <a href="<?php echo base_url()?>admin/platobnemoduly/skrill_nastavenia"><i class="icon-share" ></i> Nastaveni paypal-u</a>
                            </td>
                           <?php } ?>
                           
                            <td> <a href="<?php echo base_url() . 'admin/platobnemoduly/skrill_pevne_platby_uprava/' . $row->id; ?>" ><i class="icon-pencil"></i></a>
                             
                                <a onclick="return ozaj('Tato platba sa moze pouzivat v systeme!\nNaozaj chcete odstrániť túto platbu?');" href="<?php echo base_url() . 'admin/platobnemoduly/skrill_pevne_platby_zmazat/' . $row->id; ?>" ><i class="icon-trash"></i></a>
                             
                            </td>
                        </tr>

                    <?php }   }else{ ?>
                <tr><td colspan="7" style="text-align: center;"><i><?php echo lang('a_empty_table'); ?></i></td></tr>
          <?php  } ?>
                    
                </tbody>

            </table>
    </div>
<div class="clear"></div>


