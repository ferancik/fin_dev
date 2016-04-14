<!--<style>
    a {
    display: block;
    position: absolute;
    bottom: 0;
}
</style>-->

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo $firma->nazov; ?> </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>



                    </div>
                </div>
                <div class="ibox-content">
                    <form action="<?php echo site_url("transaction/insertTransaction"); ?>" method="post" class="form-horizontal" id="transaction_form">
                        <div class="form-group">

                            <input type="hidden" name="firma" value="<?php echo $firma->firma_id; ?>" />
                            <div id="ajax_data">
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <select data-placeholder="Vybrat ucet" class="form-control chosen-select m-b" name="ucet" id="ucet" required>
                                            <option value="">Vybrat ucet</option>
                                            <?php foreach ($ucty as $key => $ucet) { ?>
                                                <option value="<?php echo $ucet->ucet_id; ?>"><?php echo $ucet->name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <span class="input-group-btn"> 
                                            <a href="<?php echo site_url('ucty/addAjax/' . $firma->firma_id); ?>" type="button" class="btn btn-primary btn-input-add" data-target="#modal_ucty" data-toggle="modal">+</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <select data-placeholder="Vybrat projekt" class="form-control chosen-select" name="projekt" id="projekt" >
                                            <option value="">Vybrat projekt</option>
                                            <?php echo createOption($projekty); ?>
                                        </select>
                                        <span class="input-group-btn"> 
                                            <a href="<?php echo site_url("projects/addAjax/" . $firma->firma_id); ?>" type="button" class="btn btn-primary btn-input-add" data-toggle="modal" data-target="#modal_projekt">+</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <select data-placeholder="Vybrat disponenta" class="form-control chosen-select" name="disponent" id="disponent">
                                            <option value="">Vybrať disponenta</option>
                                            <?php foreach ($disponents as $key => $row) { ?>
                                                <option value="<?php echo $row->disponent_id; ?>"><?php echo $row->name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <span class="input-group-btn"> 
                                            <a href="<?php echo site_url("disponent/addAjax"); ?>" type="button" class="btn btn-primary btn-input-add" data-toggle="modal" data-target="#modal_disponent">+</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="hr-line-dashed"></div>-->
                        <div class="form-group">
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <select data-placeholder="Vybrat účel" class="form-control chosen-select" name="ucel" id="ucel">
                                        <option value="">Vybrať účel</option>
                                        <?php foreach ($ucely as $key => $row) { ?>
                                            <option value="<?php echo $row->kategoria_id; ?>"><?php echo $row->nazov; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="input-group-btn"> 
                                        <a href="<?php echo site_url("ucel/addAjax"); ?>" type="button" class="btn btn-primary btn-input-add" data-toggle="modal" data-target="#modal_ucel">+</a>
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="datum_user"  value="<?php echo date("d.m.Y"); ?>" data-mask="99.99.9999">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" name="nazov" id="nazov" placeholder="Nazov " class="form-control" required="">
                            </div>
                        </div>
                        <!--<div class="hr-line-dashed"></div>-->
                        <div class="form-group my-form-line">
                            
                            <div class="col-sm-4">
                                <input type="text" name="prijem" id="prijem" placeholder="Príjem" disabled=""  class="form-control text-right" >
                            </div>
                            <div class="col-sm-4">
                                <input type="text" name="vydaj" id="vydaj" placeholder="Výdaj" disabled="" class="form-control text-right">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" name="priebezny_stav" id="priebezny_stav" placeholder="Priebežný stav" value="0" disabled="" class="form-control text-right">
                                <input type="hidden" name="priebezny_stav_hide" id="priebezny_stav_hide" value="0" />
                            </div>
                        </div>
                        <div class="form-group my-form-line">
                            <div class="col-sm-4">
                                <button class="btn btn-primary float-right" type="submit">Save changes</button>
                            </div>
                        </div>
                        <!--<div class="hr-line-dashed"></div>-->

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="data_table_form_trasaction">
        <?php $this->load->view(TEMPLATE . 'transaction/data_table'); ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_ucty" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>

            </div>
            <div class="modal-body"><div class="te"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal -->
<div class="modal fade" id="modal_projekt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>

            </div>
            <div class="modal-body"><div class="te"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal -->
<div class="modal fade" id="modal_disponent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>

            </div>
            <div class="modal-body"><div class="te"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal -->
<div class="modal fade" id="modal_ucel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>

            </div>
            <div class="modal-body"><div class="te"></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script type="text/javascript">
    $(".chosen-select").chosen();

    // add the rule here
    $.validator.addMethod("valueNotEquals", function (value, element, arg) {
        return arg != value;
    }, "Value must not equal arg.");

    $("#projekt").on('change', function () {
        $('#disponent').trigger('chosen:open');
    });
    



</script>