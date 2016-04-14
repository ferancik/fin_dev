
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nový účel</h4>
    </div>
    <form method="get" class="form-horizontal" id="new-ucel-form">
        <div class="modal-body">
            <div class="form-group">
                <label class="col-sm-2 control-label">Názov</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nazov" required="">
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
    


    $("#new-ucel-form").on('submit', function (e) {
        
        var ucet_id = 0;
        $.ajax({
            url: base_url + "en/ucel/addAjax/<?php echo $firma_id; ?>",
            type: "post",
            data: $(this).serialize(),
            beforeSend: function (xhr) {
                $(".loader").removeClass("hide");
            },
            success: function (data) {
                $('#modal_ucel').modal('hide');
                $('#ucel').selectedIndex = -1;
                $('#ucel').append(data.option);
                $('#ucel').chosen().trigger("chosen:updated");
            },
            complete: function (jqXHR, textStatus) {
                $(".loader").addClass("hide");
                $('#nazov').focus();
            },
            dataType: 'JSON',
        });
        e.preventDefault();
    });
</script>