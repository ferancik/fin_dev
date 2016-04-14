<?php
$this->load->view('admin/spravy', null);
?>
<div class="btn-toolbar">
    <a href="<?php echo site_url('admin/spravajazykov/uprava/')   ?>" > <button class="btn btn-primary">Pridat novy jazyk</button></a> 
</div>
<div class="well">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nazov</th>
                <th>Active</th>
                <th>ISO code</th>
                <th style="width: 36px;" ></th>
            </tr>
        </thead>
        <tbody>
            <?php
              if (is_array($data) && count($data)>0 ){
            foreach ($data as $row) { ?>
                <tr class="">
                    <td><?php echo $row->id; ?></td>

                    <td><img src="<?php echo base_url().'admin_assets/flag/'.$row->icon;?>" alt="<?php echo $row->iso_code; ?>"/> <?php echo $row->name; ?></td>
                    <td><?php 
                   $arrt =  array('1'=>'Active', '2'=>'Deactive');
                    
                    echo $arrt[$row->active]; ?></td>
                    <td><?php echo $row->iso_code; ?></td>

                    <td>

                        <a href="<?php echo site_url('admin/spravajazykov/uprava/' . $row->id); ?>" ><i class="icon-pencil"></i></a>

                        <a onclick="return ozaj('Naozaj chcete odstrániť tento jazyk?');" href="<?php echo site_url('admin/spravajazykov/zmazat/' . $row->id); ?>" ><i class="icon-trash"></i></a>

                    </td>
                </tr>

            <?php }  }else{ ?>
                <tr><td colspan="5" style="text-align: center;"><i><?php echo lang('a_empty_table'); ?></i></td></tr>
          <?php  } ?>
        </tbody>
    </table>
</div>
<div class="clear"></div>


