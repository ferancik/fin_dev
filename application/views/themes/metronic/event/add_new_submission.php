<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <?php echo $submission_count; ?>. <?php echo lang("Registrácia"); ?>
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
