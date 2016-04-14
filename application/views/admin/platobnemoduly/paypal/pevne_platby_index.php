<?php
$this->load->view('admin/spravy', null);
?>
<div class="btn-toolbar">
     <a href="<?php echo site_url('admin/platobnemoduly/paypal_logy')?>" style="margin-right: 10px;" > <button class="btn btn-primary"><i class=" icon-list-alt icon-white"></i> Zobrazit logy</button></a> 
    <a href="<?php echo site_url('admin/platobnemoduly/paypal_nastavenia')?>" style="margin-right: 10px;" > <button class="btn btn-primary"><i class="icon-wrench icon-white"></i> PayPal nastavenia</button></a> 
    <a href="<?php echo site_url('admin/platobnemoduly/paypal_pevne_platby_uprava')?>" > <button class="btn btn-primary"><i class="icon-plus icon-white"></i> Pridat novu platbu</button></a>
</div>
<div class="well">
    
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Identifikator</th>
                        <th>Popis</th>
                        <th>Nazov Polozky (paypal)</th>
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
                            <td><?php echo $row->item_name; ?></td>
                             <td><?php echo $row->amount; ?></td>
                           <?php if (isset($row->mena) && $row->mena!=''){ ?>
                            <td><?php echo $row->mena; ?></td>
                           <?php }else{?>
                            <td>pouzije sa defaultna z:<br />
                                <a href="<?php echo site_url('admin/platobnemoduly/paypal_nastavenia')?>"><i class="icon-share" ></i> Nastaveni paypal-u</a>
                            </td>
                           <?php } ?>
                           
                            <td> <a href="<?php echo site_url('admin/platobnemoduly/paypal_pevne_platby_uprava/' . $row->id); ?>" ><i class="icon-pencil"></i></a>
                             
                                <a onclick="return ozaj('Tato platba sa moze pouzivat v systeme!\nNaozaj chcete odstrániť túto platbu?');" href="<?php echo site_url('admin/platobnemoduly/paypal_pevne_platby_zmazat/' . $row->id); ?>" ><i class="icon-trash"></i></a>
                             
                            </td>
                        </tr>

                    <?php }  }else{ ?>
                <tr><td colspan="7" style="text-align: center;"><i><?php echo lang('a_empty_table'); ?></i></td></tr>
          <?php  } ?>
                    
                </tbody>

            </table>
    </div>
<div class="clear"></div>


