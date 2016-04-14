<?php
if (file_exists(BASEPATH.'../installer')){
      $this->load->view('admin/spravy', array('sprava' => 'warning|<b>Please delete "installer" directory ! </b>'));
}
?>


<?php if (isset($data['analytic_visits']) || isset($data['analytic_views'])) { ?>
    <script src="<?php echo base_url() ?>admin_assets/plugins/jquery.excanvas.min.js"></script>
    <script src="<?php echo base_url() ?>admin_assets/plugins/jquery.flot.js"></script>

    <script type="text/javascript">
        $(function($) {
            var visits = <?php echo isset($data['analytic_visits']) ? $data['analytic_visits'] : 0 ?>;
            var views = <?php echo isset($data['analytic_views']) ? $data['analytic_views'] : 0 ?>;

            var buildGraph = function() {
                $.plot($('#analytics'), [{label: 'Visits', data: visits}, {label: 'Page views', data: views}], {
                    lines: {show: true},
                    points: {show: true},
                    colors: ["#5DB371", "#EAC85D","#5F90B0","#E55F3A"],
                    grid: {hoverable: true,   backgroundColor: { colors: ["#fff", "#fff"] }},
                    series: {
                        lines: {show: true, lineWidth: 1},
                        shadowSize: 0
                    },
                    xaxis: {mode: "time"},
                    yaxis: {min: 0},
                    selection: {mode: "x"}
                });
            };
            // create the analytics graph when the page loads
            buildGraph();

            // re-create the analytics graph on window resize
            $(window).resize(function() {
                buildGraph();
            });

            function showTooltip(x, y, contents) {
                $('<div id="tooltip">' + contents + '</div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y + 5,
                    left: x + 5,
                    'border-radius': '3px',
                    '-moz-border-radius': '3px',
                    '-webkit-border-radius': '3px',
                    padding: '3px 8px 3px 8px',
                    color: '#ffffff',
                    background: '#000000',
                    opacity: 0.80
                }).appendTo("body").fadeIn(500);
            }

            var previousPoint = null;

            $("#analytics").bind("plothover", function(event, pos, item) {
                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));

                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var x = item.datapoint[0],
                                y = item.datapoint[1];

                        showTooltip(item.pageX, item.pageY,
                                item.series.label + " : " + y);
                    }
                }
                else {
                    $("#tooltip").fadeOut(500);
                    previousPoint = null;
                }
            });

        });
    </script>

    <div class="well" >    
        <div id="analytics" style="height: 250px"></div>
    </div>
<?php } ?>

<div class="well">

    <table class="table">
        <thead>
            <tr>
                <th colspan="2">Server info</th>
            </tr>
        </thead>
        <tr>
            <td>Web Server</td>
            <td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
        </tr>
        <tr>
            <td>PHP</td>
            <td><?php echo PHP_VERSION; ?></td>
        </tr>
        <tr>
            <td>PHP Max Upload Size</td>
            <td><?php echo ini_get('upload_max_filesize') . 'B'; ?></td>
        </tr>
        <tr>
            <td>PHP Memory Limit</td>
            <td><?php echo ini_get('memory_limit') . 'B'; ?></td>
        </tr>
        <tr>
            <td>MySQL Version</td>
            <td><?php echo mysqli_get_client_info(); ?></td>
        </tr>

    </table>

</div>

