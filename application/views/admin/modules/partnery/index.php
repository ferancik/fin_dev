<?php $this->load->view('admin/spravy', null); ?>

<div class="btn-toolbar">
    <a href="<?php echo site_url('admin/partnery/pridatpartnera/novy') ?>" > <button class="btn btn-primary">Pridat partnera</button></a> 
</div>


<div class="well">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Názov</th>
                <th>Logo</th>
                <th>Popis</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (is_array($partnery) && count($partnery)>0 ){
            foreach ($partnery as $row) { ?>
                <tr class="">
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nazov']; ?></td>
                    <td><img src="<?php echo base_url(); ?>uploads/images/partner/<?php echo $row['logo']; ?>" /></td>
                    <td><?php echo $row['popis']; ?></td>
                    <td class="center">
                        <a href="<?php echo site_url('admin/partnery/pridatpartnera/' . $row['id']); ?>" ><i class="icon-pencil"></i></a>
                        <a onclick="return ozaj('Odstranit partnera <?php echo $row['nazov']; ?>'); " href="<?php echo site_url('admin/partnery/deletpartner/' . $row['id']); ?>" ><i class="icon-trash"></i></a>

                    </td>
                </tr>

            <?php }   }else{ ?>
                <tr><td colspan="6" style="text-align: center;"><i><?php echo lang('a_empty_table'); ?></i></td></tr>
          <?php  } ?>

        </tbody>

    </table>

</div>

