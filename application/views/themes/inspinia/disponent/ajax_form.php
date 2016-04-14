
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nový disponent</h4>
    </div>
    <form method="post" class="form-horizontal" id="new-disponent-form">
        <input type="hidden" name="disponent_id" value="0" />
        <div class="modal-body">

            <div class="form-group">
                <label class="col-sm-2 control-label">Nazov</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nazov" required="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Organizacia</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="organizacia">
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
    


    $("#new-disponent-form").on('submit', function (e) {
        
        var ucet_id = 0;
        $.ajax({
            url: base_url + "en/disponent/addAjax",
            type: "post",
            data: $(this).serialize(),
            beforeSend: function (xhr) {
                $(".loader").removeClass("hide");
            },
            success: function (data) {
                $('#modal_disponent').modal('hide');
                $('#disponent').selectedIndex = -1;
                $('#disponent').append(data.option);
                $('#disponent').chosen().trigger("chosen:updated");
            },
            complete: function (jqXHR, textStatus) {
                $(".loader").addClass("hide");
                $('#ucel').trigger('chosen:open');
            },
            dataType: 'JSON',
        });
        e.preventDefault();
    });
</script>