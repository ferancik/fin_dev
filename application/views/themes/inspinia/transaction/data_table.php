<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <?php foreach ($ucty as $key => $ucet) { ?>
                            <li class="<?php echo ($key == 0) ? 'active' : ''; ?>"><a data-toggle="tab" href="#tab-<?php echo $ucet->ucet_id; ?>"><?php echo $ucet->name; ?></a></li>
                            <?php $first++;
                        } ?>

                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="tab-content">
<?php foreach ($ucty as $key => $ucet) { ?>
                        <div id="tab-<?php echo $ucet->ucet_id; ?>" class="tab-pane <?php echo ($key == 0) ? 'active' : ''; ?>">
                            <table id="table_<?php echo $ucet->ucet_id; ?>" class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Datum</th>
                                        <th>Text</th>
                                        <th>Projekt</th>
                                        <th>Účel</th>
                                        <th>Príjem</th>
                                        <th>Výdaj</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><strong>Priebežný stav:</strong></th>
                                        <th><?php echo $priebezny_stav[$ucet->ucet_id]; ?></th>
                                        <th id="prijem_<?php echo $ucet->ucet_id; ?>"><?php echo $prijem[$ucet->ucet_id]; ?></th>
                                        <th id="vydaj_<?php echo $ucet->ucet_id; ?>"><?php echo $vydaj[$ucet->ucet_id]; ?></th>
                                    </tr>

                                </tfoot>
                            </table>
                        </div>
<?php } ?>
                </div>

            </div>

        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function () {
<?php foreach ($ucty as $key => $value) { ?>
       getDataTable(<?php echo $value->ucet_id; ?>);
<?php } ?>
    });
</script>