<?php $this->load->view('admin/spravy', null); ?>
<div class="btn-toolbar">
    <a href="<?php echo site_url('admin/sliders/novy_slider/novy') ?>" > <button class="btn btn-primary">Pridat novy slider</button></a> 
</div>
<div class="well">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Názov</th>
                <th>Umiestnenie</th>
                <th>Popis</th>
                <th style="text-align: center">Akcie</th>
            </tr>
        </thead>
        <tbody>
            <?php 
               if (is_array($slider) && count($slider)>0 ){
            foreach ($slider as $row) { ?>
                <tr class="">
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nazov']; ?></td>
                    <td><?php echo $row['umiestnenie']; ?></td>
                    <td><?php echo $row['popis']; ?></td>
                    <td class="center">
                        <a href="<?php echo site_url('admin/sliders/novy_slider/' . $row['id']) ; ?>" ><i class="icon-pencil"></i></a>
                        <a href="<?php echo site_url('admin/sliders/pridajfotoslider/' . $row['id']); ?>" ><i class="icon-camera"></i></a>

                    </td>
                </tr>

            <?php }}else{ ?>
                <tr><td colspan="6" style="text-align: center;"><i><?php echo lang('a_empty_table'); ?></i></td></tr>
          <?php  } ?>
        </tbody>

    </table>	

</div>


