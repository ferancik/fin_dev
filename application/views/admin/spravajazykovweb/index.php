<?php
$this->load->view('admin/spravy', null);
?>

<ul id="myTab" class="nav nav-tabs">
    <li><a href="#alllanguage"  data-toggle="tab" >Všetky</a></li>
    <?php foreach ($alljazyky as $value) { ?>
        <li><a href="#<?= $value->dir; ?>"  data-toggle="tab" ><img src="<?php echo base_url().'admin_assets/flag/'.$value->icon; ?>" alt="<? echo $value->iso_code; ?>" /> <?php echo ucfirst($value->name); ?> <?php echo (($value->default == 1) ? '<em class="formee-req">*</em>' : ''); ?></a></li>
    <?php } ?>

</ul>

<div id="myTabContent" class="tab-content">

    <div id="alllanguage" class="tab-pane fade" >
        <div id="legend">
            <legend class="">Vsetky</legend>
        </div>
        <div class="well">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nazov</th>
                        <th>DIR</th>
                        <th>ISO code</th>
                        <th>Active</th>
                        <th style="width: 56px;" ></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dblanguage as $row) { ?>
                        <tr class="">
                            <td><img src="<?php echo base_url().'admin_assets/flag/'.$row->icon; ?>" alt="<? echo $row->iso_code; ?>" /> <? echo $row->name; ?></td> 
                            <td><? echo $row->dir; ?></td>
                            <td><? echo $row->iso_code; ?></td>
                            <td><? echo ($row->active == 1) ? 'Active' : ''; ?></td>
                            <td> 
                                <?php
                                if ($row->active == 1) {
                                    if ($row->dir != 'english') {
                                        ?>
                                        <a href="<?php echo site_url('admin/spravajazykovweb/deactive/' . $row->id) ?>" ><i class="icon-ban-circle"></i></a>
                                        <a onclick="return ozaj('Znova vytvorite jazyk z Anglickeho. Tymto sa prepise stara veriza, Chcete naozaj pokracovat?');" href="<?php echo site_url('admin/spravajazykovweb/recreate/' . $row->id) ?>" ><i class=" icon-refresh"></i></a>

                                        <?php
                                    }
                                } else {
                                    ?>
                                    <a href="<?php echo site_url('admin/spravajazykovweb/active/' . $row->id) ?>" ><i class="icon-ok-circle"></i></a>
                                    <?php if ($row->dir != 'english') { ?>
                                        <a onclick="return ozaj('Znova vytvorite jazyk z Anglickeho. Tymto sa prepise stara veriza, Chcete naozaj pokracovat?');" href="<?php echo site_url('admin/spravajazykovweb/recreate/' . $row->id) ?>" ><i class=" icon-refresh"></i></a>
                                    <?php } ?>

                                <?php } ?>


                            </td>
                        </tr>

                        <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

    <?php foreach ($alljazyky as $value) { ?>
        <div id="<?php echo $value->dir; ?>" class="tab-pane fade" >
            <div id="legend">
                <legend class=""><?php echo ucfirst($value->name); ?></legend>
            </div>
            <div class="well">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nazov</th>

                            <th style="width: 36px;" ></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subory[$value->dir] as $row) { ?>
                            <tr class="">


                                <td><?php echo $row; ?></td> 

                                <td> 
                                    <a href="<?php echo site_url('admin/spravajazykovweb/uprava/') . '/?jazyk=' . $value->dir . '/' . substr($row, 0, -4); ?>" ><i class="icon-pencil"></i></a>
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
</div>
<p>Pridanie novej hodoty do jazyka je mozne len pri English jazyku. Pri ostatnych sa polozka prida automaticky</p>
<div class="clear"></div>

<script type="text/javascript">
                                            $('#myTab a:first').tab('show');
                                            $('#myTab a').click(function(e) {
                                                e.preventDefault();
                                                $(this).tab('show');
                                            });
</script>
