<?php $this->load->view('admin/spravy', null); ?>
<div class="btn-toolbar">
    <a href="<?php echo site_url('admin/navbloky/pridajnavblok/novy') ?>" > <button class="btn btn-primary">Pridat novy blok</button></a> 
</div>
<div class="well">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nadpis</th>
                <th>Icon</th>
                <th>Text</th>
                <th style="width: 36px;" ></th>
            </tr>
        </thead>
        <tbody>
           
                <?php 
                    if (is_array($navbloky) && count($navbloky)>0 ){
                foreach ($navbloky as $row) { ?>
                    <tr class="sorting_3" id="riadok_<?php echo $row['id']; ?>">
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nadpis']; ?></td>
                        <td><img src="<?php echo base_url(); ?>images/navbloky/<?php echo $row['icon']; ?>" /></td>
                        <td><?php echo substr($row['text'], 0, 100); ?></td>
                        <td class="center">
                            <a href="<?php echo site_url('admin/navbloky/pridajnavblok/' . $row['id']) ; ?>" ><i class="icon-pencil"></i></a>
                            <a onclick="return ozaj('Naozaj chcete odstrániť navigačný blok <?php echo $row['nadpis']; ?>'); " href="<?php echo site_url('admin/navbloky/odstranit/' . $row['id']); ?>" ><i class="icon-trash"></i></a>
                        </td>
                    </tr>

                <?php }   }else{ ?>
                <tr><td colspan="6" style="text-align: center;"><i><?php echo lang('a_empty_table'); ?></i></td></tr>
          <?php  } ?>
        </tbody>
    </table>
</div>


<script>
    
    $(function() {
        $("#navbloky tbody").sortable().disableSelection();
    });
    $(function()
       {
               var nameIsCustom = false;
               $("#navbloky tbody").sortable({
                       update: function() {
                               var navBloky = $(this).sortable('toArray').toString();
                               $.ajax({
                                       url: "<?php echo site_url('admin/navbloky/ajaxporadie') ?>",
                                       type: "post",
                                       data: "navbloky=" + navBloky,
                                       error: function() {
                                               alert("Vyskytla sa neznáma chyba");
                                       }
                               });
                       }
               });

       });
   
</script>


