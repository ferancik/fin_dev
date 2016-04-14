<div class="row">
    <div class="col-md-6 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <span class="caption-subject bold uppercase"><?php echo $event->name; ?></span>
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" role="form" id="form_registration" method="post" action="<?php echo createEventForm($event->url); ?>">
                    <input type="hidden" name="count_submision" value="1" id="count_submission" />
                    <div class="form-body" style="padding: 0;">
                        <div class="portlet box green">
                            <div class="portlet-title">
                                <div class="caption">
                                    1. <?php echo lang("Registrácia"); ?>
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <?php foreach ($fields as $key => $field) { ?>
                                    <?php $this->load->view(TEMPLATE . 'form/' . $field->field_type, array('field' => $field)); ?>
                                <?php } ?>
                                
                            </div>
                        </div>
                        
                        <div id="new-form"></div>

                        <div class="form-actions no-border-top no-padding-left no-padding-right no-background-color">
                            <div class="row">
                                <div class="col-md-3">
                                    <button type="button" onclick="getNewSubmission('<?php echo $event_url; ?>/newSubmission')" class="btn default">Ďalší účastník
                                        <a class="" data-toggle="modal" href="#long"> ? </a>
                                    </button>

                                </div>
                                <div class="col-md-9">
                                    <button type="submit" class="btn green pull-right"><?php echo lang("Pokračovať"); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="long" class="modal fade modal-scroll" tabindex="-1" data-replace="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">A Fairly Long Modal</h4>
            </div>
            <div class="modal-body">
                <img style="height: 800px" alt="" src="http://i.imgur.com/KwPYo.jpg"> </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#form_registration").validate();
    });
</script>

<script src="<?php echo base_url(); ?>/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>

