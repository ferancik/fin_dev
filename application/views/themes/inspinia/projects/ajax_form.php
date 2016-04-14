
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nový projekt</h4>
    </div>
    <form method="post" class="form-horizontal" id="new-projekts-form">
        <div class="modal-body">

            <input type="hidden" name="firma_id" value="<?php echo $firma_id; ?>" />
            <input type="hidden" name="projekt_id" value="0" />
            <div class="form-group"><label class="col-sm-2 control-label">Nadradeny projekt</label>

                <div class="col-sm-10">
                    <select class="form-control m-b" name="parent" id="parent">
                        <option value="0">Hlavny projekt</option>
                        <?php echo $options; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Nazov</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nazov">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Číslo</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="cislo">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Od</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="date_from" name="date_from">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Do</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="date_to" name="date_to">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Popis</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="popis"></textarea>
                </div>
            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Zrušiť</button>
            <button type="submit" class="btn btn-primary">Uložiť</button>
        </div>
    </form>
</div>

<script type="text/javascript">
//    $('#date_from').datepicker({
//        autoclose: true
//    });
//
//    $('#data_1 .input-group.date').datepicker({
//        autoclose: true
//    });


    $("#new-projekts-form").on('submit', function (e) {
        
        var ucet_id = 0;
        $.ajax({
            url: base_url + "en/projects/addAjax/<?php echo $firma_id; ?>",
            type: "post",
            data: $(this).serialize(),
            beforeSend: function (xhr) {
                $(".loader").removeClass("hide");
            },
            success: function (data) {
                $('#modal_projekt').modal('hide');
                $('#projekt').selectedIndex = -1;
                $('#projekt').append(data.option);
                $('#projekt').chosen().trigger("chosen:updated");
            },
            complete: function (jqXHR, textStatus) {
                $(".loader").addClass("hide");
                $('#disponent').trigger('chosen:open');
            },
            dataType: 'JSON',
        });
        e.preventDefault();
    });
</script>
