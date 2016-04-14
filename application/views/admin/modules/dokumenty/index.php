<?php $this->load->view('admin/spravy', null); ?>

<div class="btn-toolbar">
    <a href="<?php echo base_url() . 'admin/dokumenty/pridatdokument/novy' ?>" > <button class="btn btn-primary"><?php echo lang('add_new_document'); ?></button></a> 
</div>
<div class="well">

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th><?php echo lang('title'); ?></th>
                <th><?php echo lang('document'); ?></th>
                <th><?php echo lang('description'); ?></th>
                <th style="width: 70px;" ></th>
            </tr>
        </thead>
        <tbody>
           
                <?php 
                 if (is_array($dokumenty) && count($dokumenty)>0 ){
                foreach ($dokumenty as $row) { ?>
                    <tr class="">
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nazov']; ?></td>
                        <td><?php echo $row['dokument']; ?></td>
                        <td><?php echo $row['popis']; ?></td>
                        <td> 
                            <a href="<?php echo site_url('admin/dokumenty/pridatdokument/' . $row['id']) ; ?>" title="<?php echo lang('edit'); ?>"><i class="icon-pencil"></i></a>
                            <a href="<?php echo base_url() . 'uploads/dokumenty/' . $row['dokument']; ?>" target="_blank"><i class="icon-download-alt"></i></a>
                            <a onclick="return ozaj('<?php echo lang('popup_deleted_file'); ?> \n <?php echo $row['dokument']; ?>'); " href="<?php echo site_url( 'admin/dokumenty/odstranit/' . $row['id']); ?>" ><i class="icon-trash"></i></a>

                        </td>
                    </tr>

                <?php }   }else{ ?>
                <tr><td colspan="6" style="text-align: center;"><i><?php echo lang('a_empty_table'); ?></i></td></tr>
          <?php  } ?>

        </tbody>

    </table>
</div>
<div class="clear"></div>




