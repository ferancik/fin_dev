var priebezny_stav = 0;
function getData() {
    $("#firma").on('change', function (e) {
        $.ajax({
            url: base_url + "en/transaction/getData",
            type: "post",
            data: {firma_id: $(this).val()},
            success: function (data) {
                $("#ajax_data").html(data.field);
                $(".chosen-select").chosen();
                $("#priebezny_stav").val(data.stav);
                $("#vydaj").prop('disabled', true);
                $("#prijem").prop('disabled', true);
                $("#prijem").attr("placeholder", "Príjem");
                $("#vydaj").attr("placeholder", "Výdaj");
            },
            dataType: 'JSON',
            async: false
        });
        e.preventDefault();
    });
}


function priebeznyStavFunction() {
    $(document).delegate("#ucet", "change", function (e) {
        getPriebeznyStav($(this).val());
    });
}




function getContentModal(url) {
    $.ajax({
        url: url,
        type: "post",
        success: function (data) {
            $("#modal_body_content").html(data.html);

        },
        complete: function (jqXHR, textStatus) {
            $('#myModal').modal('show');
        },
        dataType: 'JSON',
        async: false
    });
}


function getPriebeznyStav(ucet_id) {
    $.ajax({
        url: base_url + "en/transaction/getPriebeznyStav",
        type: "post",
        data: {ucet_id: ucet_id},
        success: function (data) {
            $("#priebezny_stav").val(data.stav);
            $("#priebezny_stav_hide").val(data.stav);
            $("#vydaj").prop('disabled', false);
            $("#prijem").prop('disabled', false);
            $("#prijem").attr("placeholder", "Príjem");
            $("#vydaj").attr("placeholder", "Výdaj");
        },
        beforeSend: function (xhr) {
            $(".loader").removeClass("hide");
        },
        complete: function (jqXHR, textStatus) {
            $(".loader").addClass("hide");
            $('#projekt').trigger('chosen:open');
        },
        dataType: 'JSON',
        async: false
    });
}

function getAllDataTable(firma_id){
    $.ajax({
        url: base_url + "en/transaction/getAllDataTable",
        type: "post",
        data: {firma_id: firma_id},
        beforeSend: function (xhr) {
            $(".loader").removeClass("hide");
        },
        success: function (data) {
            $("#data_table_form_trasaction").html(data.html);
        },
        complete: function (jqXHR, textStatus) {
            $(".loader").addClass("hide");
        },
        dataType: 'JSON',
        async: false
    });
}


function getDataTable(ucet_id) {
    $('#table_' + ucet_id).dataTable({
        processing: true,
        serverSide: true,
        paging: true,
        searching: false,
        ajax: {
            url: "/en/transaction/getTransactions/" + ucet_id,
            type: "POST"
        }
    });
}

function getDataTableReload(ucet_id) {
    $('#table_' + ucet_id).dataTable({
        processing: true,
        serverSide: true,
        paging: false,
        searching: false,
        ajax: {
            url: "/en/transaction/getTransactions/" + ucet_id,
            type: "POST"
        }
    });
}

function insertTransaction() {
    //kontrola ci sa ma formular odoslat 
    $("#transaction_form").submit(function (e) {
        $.ajax({
            url: base_url + "en/transaction/insertTransaction",
            type: "post",
            data: $(this).serialize(),
            success: function (data) {
                $("#nazov").val("");
                $("#prijem").val("");
                $("#vydaj").val("");

            },
            complete: function (jqXHR, textStatus) {

                var dt = $('#table_' + $("#ucet").val()).dataTable();
                dt.fnDraw();
                getPriebeznyStav($("#ucet").val());


            },
            dataType: 'JSON',
            async: false
        });
        e.preventDefault();
    });
}




function spracujPriebeznyStav() {
    var priebezny_stav = $("#priebezny_stav_hide").val();

    var priebezny_stav_show = 0;
    $('#prijem').on('input', function () {
        priebezny_stav = $("#priebezny_stav_hide").val();
        $("#vydaj").attr("placeholder", "Výdaj");
        $("#vydaj").val("");
        priebezny_stav_show = parseFloat(priebezny_stav) + parseFloat($(this).val());
        $("#priebezny_stav").val(priebezny_stav_show);
    });

    $('#vydaj').on('input', function () {
        priebezny_stav = $("#priebezny_stav_hide").val();
        $("#prijem").attr("placeholder", "Príjem");
        $("#prijem").val("");
        priebezny_stav_show = parseFloat(priebezny_stav) - parseFloat($(this).val());
        $("#priebezny_stav").val(priebezny_stav_show);
    });
}







$(document).ready(function () {
    getData();
    priebeznyStavFunction();
    spracujPriebeznyStav();
    insertTransaction();

    $('#myModal').on('hidden', function () {
        $(this).data('modal', null);
    });
    
});