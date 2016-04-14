<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="span2">
                <ul class="nav nav-list well">

                    <li>
                        Step 1
                    </li>
                    <li class="divider"></li>
                    <li class="active">
                        <a href="#">Step 2</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        Completed
                    </li>



                </ul>
            </div>
            <div class="span6 well">
                <?php
                if ($this->session->flashdata('message') != '') {
                    ?>
                    <div class="alert alert-error" >
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
                <? }
                ?>

                <form action="<?php echo base_url(); ?>?t=step3" method="POST">
                    <fieldset>
                        <legend>Step 2: Create Administrator</legend> 

                        <?php
                        $data = $this->session->all_userdata();

                        $username = array(
                            'name' => 'username',
                            'value' => (isset($data['username'])) ? $data['username'] : '',
                            'class' => "span8",
                        );
                        $email = array(
                            'name' => 'email',
                            'value' => (isset($data['email'])) ? $data['email'] : '',
                            'class' => "span8",
                        );
                        ?>
                        <label>Username</label>
                        <?php echo form_input($username); ?>

                        <label>Email</label>
<?php echo form_input($email); ?>

                        <label>Password</label>
                        <input type="password" class="span8" name="password" /> 

                        <label>Confirm Password</label>
                        <input type="password" class="span8" name="password2" /> 

                        <label>
                            &nbsp;
                        </label>
                        <input type="hidden" value="step3" name="akyKrok" />
                        <button type="submit" class="btn btn-primary btn-large">Install</button>
                    </fieldset>
                </form>
            </div>
            <div class="span4">
            </div>
        </div>
    </div>
</div>