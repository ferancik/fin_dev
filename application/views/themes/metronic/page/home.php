<div class="row">
    <?php foreach ($events as $key => $event) { ?>
    
        <div class="col-sm-12 col-md-3">
            <div class="thumbnail">
                <a href="<?php echo createUrlEventDetail($event->url); ?>" >
                    <img src="" alt="Obrazok preteku" style="width: 100%; height: 200px;">
                </a>
                <div class="caption">
                    <a href="<?php echo createUrlEventDetail($event->url); ?>" ><h3><?php echo $event->name; ?></h3></a>
                    <p><?php echo $event->short_description; ?></p>
                </div>
            </div>
        </div>
</a>
    <?php } ?>
</div>