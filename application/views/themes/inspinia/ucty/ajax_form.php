<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Nový účet</h4>

    </div>
    <form method="post" class="form-horizontal" id="form-new-ucet">
        <div class="modal-body">

            <input type="hidden" name="firma_id" id="firma_id" value="<?php echo $firma_id; ?>" />
            <div class="form-group">
                <label class="col-sm-2 control-label">Názov</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name" required="" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Banka</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="banka" id="banka" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Pobocka</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="banka_pobocka" id="banka_pobocka" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Číslo účtu</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="cislo_uctu" id="cislo_uctu" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">SWIFT</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="swift" id="swift" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">IBAN</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="iban" id="iban" />
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
            <button type="submit" class="btn btn-primary" id="btn-add-new-ucet">Pridať nový</button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $("#form-new-ucet").on('submit', function (e) {
        console.log("odoslat formular");
        var ucet_id = 0;
        $.ajax({
            url: base_url + "en/ucty/addAjax/<?php echo $firma_id; ?>",
            type: "post",
            data: $(this).serialize(),
            beforeSend: function (xhr) {
                $(".loader").removeClass("hide");
            },
            success: function (data) {
                $('#modal_ucty').modal('hide');
                $('#ucet').selectedIndex = -1;
                $('#ucet').append(data.ucet);
                $('#ucet').chosen().trigger("chosen:updated");
                ucet_id = data.ucet_id;
                            },
            complete: function (jqXHR, textStatus) {
                $(".loader").addClass("hide");
                getPriebeznyStav(ucet_id);
                getAllDataTable(<?php echo $firma_id; ?>);
                $('#projekt').trigger('chosen:open');
            },
            dataType: 'JSON',
        });
        e.preventDefault();
    });
</script>