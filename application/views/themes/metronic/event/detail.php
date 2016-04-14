<div class="row">

    <div class="col-md-4">
        <img class="img-responsive pic-bordered" src="<?php echo base_url() . $event->img; ?>" />
        <a href="<?php echo createEventForm($event->url); ?>" class="btn red btn-block"> Registrovať </a>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-8 profile-info">
                <h1 class="font-green sbold uppercase"><?php echo $event->name; ?></h1>
                <ul class="list-inline">
                    <li>
                        <i class="fa fa-map-marker"></i> <?php echo $event->location; ?> </li>
                    <li>
                        <i class="fa fa-calendar"></i><?php echo date("d. m. Y H:i", strtotime($event->date_from)); ?> </li>
                    <li>
                        <i class="fa fa-briefcase"></i> Šport </li>
                    <li>
                        <i class="fa fa-heart"></i> Beh
                    </li>
                </ul>
                <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt laoreet dolore magna aliquam tincidunt erat volutpat laoreet dolore magna aliquam tincidunt erat volutpat.
                </p>
                <p>
                    <a href="<?php echo $event->website; ?>"><?php echo $event->website; ?></a>
                </p>

            </div>
            <!--end col-md-8-->
            <div class="col-md-4">
                
            </div>
            <!--end col-md-4-->
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="portlet-body">
                    <div id="gmap_basic" class="gmaps"> </div>
                </div>
            </div>
        </div>
    </div>
</div>

