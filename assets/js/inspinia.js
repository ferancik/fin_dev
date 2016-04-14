// Custom scripts
$(document).ready(function () {
    // metsiMenu
    $('#side-menu').metisMenu({
        preventDefault: false
    }
    );

    // collapse ibox function
    $('.collapse-link').click(function () {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        var content = ibox.find('div.ibox-content');
        content.slideToggle(200);
        button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        ibox.toggleClass('').toggleClass('border-bottom');
        setTimeout(function () {
            ibox.resize();
            ibox.find('[id^=map-]').resize();
        }, 50);
    });

    // close ibox function
    $('.close-link').click(function () {
        var content = $(this).closest('div.ibox');
        content.remove();
    });

    // small todo handler
    $('.check-link').click(function () {
        var button = $(this).find('i');
        var label = $(this).next('span');
        button.toggleClass('fa-check-square').toggleClass('fa-square-o');
        label.toggleClass('todo-completed');
        return false;
    });

    // minimalize menu
    $('.navbar-minimalize').click(function () {
        $("body").toggleClass("mini-navbar");
    })

    // tooltips
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

    $("[data-toggle=popover]")
            .popover();
});

function rocnyPrehlad(url, data_send, container, title) {
    var title_graph = title || "";
    console.log(data_send);
    $.ajax({
        type: "POST",
        url: url,
        data: data_send,
        success: function (vystup) {

            var category = [];
            $.each(vystup.data.categories, function (key, val) {
                category[key] = val;
            });


            var arrProducts = []; //This needs to be an array not a string.
            $.each(vystup.data.data, function (index, elektraren) {
                var prod = {};//make a new product for each iteration
                prod['data'] = elektraren.hodnoty;
                prod['name'] = elektraren.nazov;
                prod['type'] = 'column';
                arrProducts.push(prod); //add the product to thearray of products       
            });

//                //vlozenie predikcie do grafu
            var prod = {};//make a new product for each iteration
//                
//
            prod['data'] = vystup.data.predikcia;
            prod['name'] = 'Predikcia';
            prod['type'] = 'spline';
            arrProducts.push(prod); //add the product to thearray of products



            var chart = new Highcharts.Chart({
                chart: {
                    renderTo: container
                },
                title: {
                    text: ""
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: category,
                    labels: {
                        rotation: -45,
                        y: +30
                    },
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text:  title_graph + ' MWh'
                    }
                },
                legend: {
                    backgroundColor: '#FFFFFF',
                    align: 'center',
                    verticalAlign: 'bottom',
                    x: 60,
                    y: 20,
                    floating: true,
                    style: {
                        zIndex: 10
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y} MWh</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: arrProducts
            });

        },
        dataType: 'JSON'
    });

}

// For demo purpose - animation css script
function animationHover(element, animation) {
    element = $(element);
    element.hover(
            function () {
                element.addClass('animated ' + animation);
            },
            function () {
                //wait for animation to finish before removing classes
                window.setTimeout(function () {
                    element.removeClass('animated ' + animation);
                }, 2000);
            });
}

// Minimalize menu when screen is less than 768px
$(function () {
    $(window).bind("load resize", function () {
        if ($(this).width() < 768) {
            $('body').addClass('body-small')
        } else {
            $('body').removeClass('body-small')
        }
    })
})

// Dragable panels
function WinMove() {
    $("div.ibox").not('.no-drop')
            .draggable({
                revert: true,
                zIndex: 2000,
                cursor: "move",
                handle: '.ibox-title',
                opacity: 0.8
            })
            .droppable({
                tolerance: 'pointer',
                drop: function (event, ui) {
                    var draggable = ui.draggable;
                    var droppable = $(this);
                    var dragPos = draggable.position();
                    var dropPos = droppable.position();
                    draggable.swap(droppable);
                    setTimeout(function () {
                        var dropmap = droppable.find('[id^=map-]');
                        var dragmap = draggable.find('[id^=map-]');
                        if (dragmap.length > 0 || dropmap.length > 0) {
                            dragmap.resize();
                            dropmap.resize();
                        }
                        else {
                            draggable.resize();
                            droppable.resize();
                        }
                    }, 50);
                    setTimeout(function () {
                        draggable.find('[id^=map-]').resize();
                        droppable.find('[id^=map-]').resize();
                    }, 250);
                }
            });
}
jQuery.fn.swap = function (b) {
    b = jQuery(b)[0];
    var a = this[0];
    var t = a.parentNode.insertBefore(document.createTextNode(''), a);
    b.parentNode.insertBefore(a, b);
    t.parentNode.insertBefore(b, t);
    t.parentNode.removeChild(t);
    return this;
};
