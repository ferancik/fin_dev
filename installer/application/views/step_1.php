
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="span2">
                <ul class="nav nav-list well">

                    <li class="active">
                        <a href="#">Step 1</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        Step 2
                    </li>
                    <li class="divider"></li>
                    <li>
                        Completed
                    </li>
                </ul>
            </div>
            <div class="span6 well">
                <?php if ($this->session->flashdata('message') != '') { ?>
                    <div class="alert alert-error" >
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
                <? }
                ?>

                <form action="<?php echo base_url(); ?>?t=step2" method="POST">

                    <?php
                    $data = $this->session->all_userdata();

                    $mysql_host = array(
                        'name' => 'mysql_host',
                        'value' => (isset($data['mysql_host'])) ? $data['mysql_host'] : 'localhost',
                        'class' => "span8",
                    );

                    $mysql_user = array(
                        'name' => 'mysql_user',
                        'value' => (isset($data['mysql_user'])) ? $data['mysql_user'] : '',
                        'class' => "span8",
                    );

                    $mysql_pass = array(
                        'name' => 'mysql_pass',
                        'value' => (isset($data['mysql_pass'])) ? $data['mysql_pass'] : '',
                        'class' => "span8",
                    );

                    $mysql_db_name = array(
                        'name' => 'mysql_db_name',
                        'value' => (isset($data['mysql_db_name'])) ? $data['mysql_db_name'] : '',
                        'class' => "span8",
                    );
                    ?>
                    <fieldset>
                        <legend>Step 1: Configure Database</legend> 
                        <label>MySQL Hostname</label>
                        <?php echo form_input($mysql_host) ?>


                        <label>MySQL Username</label>
                        <?php echo form_input($mysql_user) ?>


                        <label>MySQL Password</label>
                        <?php echo form_password($mysql_pass) ?>


                        <label>MySQL Database</label>
                        <?php echo form_input($mysql_db_name) ?>

                        <label>
                            &nbsp;
                        </label>
                        <input type="hidden" value="step3" name="akyKrok" />
                        <div id="messageBox" style="display: none;"> 
                            <div >
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span  id="messageBoxText"></span>
                            </div></div>

                        <a href="#" onclick="checkDBConnect();
                                return false;" class="btn btn-success btn-large" >Check DB connect</a>
                        <button type="submit" class="btn btn-primary btn-large" style="margin-left: 10px;">Next Step »</button>
                    </fieldset>
                </form>
            </div>
            <div class="span4">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
                            $('input[name="mysql_user"]').on('keyup', function() {
                                var $db = $('input[name=mysql_user]');
                                if ($db.val().match(/[^A-Za-z0-9_-]+/)) {
                                    $db.val($db.val().replace(/[^A-Za-z0-9_-]+/, ''));
                                }
                            });

                            function checkDBConnect() {
                                $.post('<?php base_url() ?>?t=checkDBConnect', {
                                    mysql_host: $('input[name=mysql_host]').val(),
                                    mysql_user: $('input[name=mysql_user]').val(),
                                    mysql_pass: $('input[name=mysql_pass]').val(),
                                    mysql_db_name: $('input[name=mysql_db_name]').val()
                                }, function(data) {
                                    var $confirm_db = $('#messageBox');
                                    $confirm_db.hide();
                                    if (data.success === true) {

                                        $('#messageBoxText').html(data.message);

                                        $('#messageBox div')
                                                .removeClass('alert alert-error')
                                                .addClass('alert alert-success');


                                        $confirm_db.show();
                                    } else {
                                        $('#messageBoxText').html(data.message);
                                        $('#messageBox div')
                                                .removeClass('alert alert-success')
                                                .addClass('alert alert-error');
                                        $confirm_db.show();
                                    }
                                }, 'json'
                                        );

                            }

</script>