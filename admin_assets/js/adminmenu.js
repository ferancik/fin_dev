
function encHTML(str) {
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

(function($) {
    $.debug = {
        dump: function(arr, level, enc) {
            var dumped_text = "";
            if (!level)
                level = 0;
            var level_padding = "";
            for (var j = 0; j < level + 1; j++)
                level_padding += "    ";
            if (typeof(arr) == 'object') { //Array/Hashes/Objects 
                for (var item in arr) {
                    var value = arr[item];

                    if (typeof(value) == 'object') { //If it is an array, 
                        dumped_text += level_padding + "'" + item + "' ...\n";
                        dumped_text += $.debug.dump(value, level + 1);
                    } else if (typeof(value) == 'string') {
                        value = enc == true ? encHTML(value) : value;
                        dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
                    } else {
                        dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
                    }
                }
            } else { //Stings/Chars/Numbers etc. 
                dumped_text = "===>" + arr + "<===(" + typeof(arr) + ")";
            }
            return dumped_text;
        },
        print_r: function(obj, contId) {
            $("#" + contId).removeClass().css({
                display: "block",
                position: "absolute",
                top: "41px",
                right: "0px",
                padding: "10px",
                width: "700px",
                height: "auto",
                background: "#ddd",
                color: "black",
                border: "solid 1px black",
                zIndex: 1000
            }).html("<pre>" + $.debug.dump(obj) + "</pre><div id='close-debug'>Close</div>");

            $("#close-debug").css({cursor: "pointer"}).click(function() {
                $("#" + contId).remove();
            });
        }
    };
})(jQuery);

function parseTree(ul) {
    var tags = [];
    ul.children("li").each(function() {
        var subtree = $(this).children("ul");
        if (subtree.size() > 0)
            tags.push([$(this).attr("id"), parseTree(subtree)]);
        else
            tags.push($(this).attr("id"));
    });
    return tags;
}

$(document).ready(function() {

    $("li.tree_item span").droppable({
        // tolerance: "pointer",
        hoverClass: "tree_hover",
        activeClass: "tree_active",
        drop: function(event, ui) {
            var dropped = ui.draggable;
            dropped.css({top: 0, left: 0});
            var me = $(this).parent();
            if (me == dropped)
                return;
            var subbranch = $(me).children("ul");
            if (subbranch.size() == 0) {
                me.find("span").after("<ul id=\"sortable\" ></ul>");
                subbranch = me.find("ul");
            }
            var oldParent = dropped.parent();
            subbranch.eq(0).append(dropped);
            var oldBranches = $("li", oldParent);
            if (oldBranches.size() == 0) {
                $(oldParent).remove();
            }
        }
    });



    $("li.tree_item").draggable({
        opacity: 0.4,
        revert: true
    });


$("#zobrazitSkryteMEnu").click(function() {
    var coJe = $("#zobrazitSkryteMEnu").attr('rel');
     if (coJe == 0) {
         $('.nezobrazit').addClass('terazjezobrazene');
         $('.nezobrazit').removeClass('nezobrazit');
          $("#zobrazitSkryteMEnu").html('Skryt skryte menu');
          $("#zobrazitSkryteMEnu").attr('rel', 1);
     }else if (coJe == 1) {
          $('.terazjezobrazene').addClass('nezobrazit');
          $('.nezobrazit').removeClass('terazjezobrazene');
          $("#zobrazitSkryteMEnu").html('Zobrazit skryte menu');
           $("#zobrazitSkryteMEnu").attr('rel', 0);
     }
});
    $("#editaciaPoradia").click(function() {
        var coJe = $("#editaciaPoradia").attr('rel');
        if (coJe == 0) {
            $('#sortable').sortable({
                update: function() {
                    var FotoItems = $(this).sortable('toArray').toString();
                    $.ajax({
                        url: URL_SAVE_MENU_PORADIE,
                        type: "post",
                        data: "polozky=" + FotoItems,
                        error: function() {
                            alert("Vyskytla sa neznáma chyba");
                        }
                    });
                }});
            $('#sortable').sortable("enable");
            
            $("li.tree_item").draggable();
            $("li.tree_item").draggable("disable");
            $("li.tree_item span").droppable();
            $("li.tree_item span").droppable("disable");

            $("#editaciaPoradia").html('Prepnut na editaciu Menu');
            $("#editaciaPoradia").attr('rel', 1);
        } else if (coJe == 1) {
            $('#sortable').sortable("disable");
            
            $("li.tree_item").draggable("enable");
            $("li.tree_item span").droppable("enable");
            
            
            $("#editaciaPoradia").attr('rel', 0);
            $("#editaciaPoradia").html('Prepnut na editaciu poradia');
        }


    });
    
    
    


    $("#saveBtn").click(function() {
//        alert('ulozene');
        var tree = $.toJSON(parseTree($("#tag_tree")));
        $.post(URL_SAVE_MENU, {menu: tree}, function(res) {
            //$("#printOut").html(res);
        });

        // $.debug.print_r(parseTree($("#tag_tree")), "printOut", false);
    });


});


