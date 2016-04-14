<style type="text/css">
    .nezobrazit{
        display: none;
    }
</style>
<?
$this->load->view('admin/spravy', null);

function print_menu($data, $kolkate) {


   if ($kolkate == 0) {
        echo '<ul class="treeul" id="sortable">';
    } else {
        if (count($data) > 0) {
            echo '<ul class="treeul" id="sortable">';
        }
    }

    foreach ($data as $item) {
        if (count($item->parrents > 0)) { //(<i>' .$item->id . '</i>)
            echo '<li id="' . $item->id . '" class="tree_item '.(($item->zobrazit==0) ? 'nezobrazit' : '').'" ><span class="tree_label"><a href="#">  ' . getMenuIcon($item) . '' . $item->nazov . '</a></span>';
            print_menu($item->parrents, ++$kolkate);
            echo '<a class="tree_item_move" href="#"><i class="icon-move"></i></a>
                <a class="tree_item_edit" href="' . site_url('admin/adminmenu/editMenu/' . $item->id) . '/" data-toggle="modal" ><i class="icon-pencil"></i></a>
<a class="tree_item_del" href="' . site_url('admin/adminmenu/delMenu/' . $item->id) . '/" onclick="return ozaj(\'Naozaj chcete odstranit toto menu?\');" ><i class="icon-remove"></i></a>
</li>';
        }
    }


  if ($kolkate == 0) {
        echo '</ul><hr />';
    } else {
        if (count($data) > 0) {
            echo '</ul><hr />';
        }
    }
}
?>

<div id="printOut"></div>
<div class="clearfix"></div>
<div class="btn-toolbar">       

    <button class="btn btn-primary" id="saveBtn"  style="margin-right: 10px;" data-loading-text="Loading...">Uloziť poradie</button>

    <a href="<?= site_url('admin/adminmenu/editMenu/'); ?>" class="btn" data-toggle="modal"  > Pridat nove menu</a> 

    <button class="btn" rel="0" id="editaciaPoradia" >Prepnut na editaciu poradia</button>

    <button class="btn" rel="0" id="zobrazitSkryteMEnu" >Zobrazit skryte menu</button>
</div>

<div class="well">
    <div style="width: 500px;">
        <ul id="tag_tree">
            <li id="rootRoot" class="tree_item" ><span class="tree_label">Root Kategoria</span>
<?php
//preVarDump($data);
print_menu($data, 0);
?>
            </li>
        </ul>
    </div>
</div>
<div class="clear"></div>
<script src="<?php echo base_url() ?>admin_assets/plugins/jquery.json-2.4.js"></script>
<script type="text/javascript">

    var URL_SAVE_MENU = '<?php echo site_url('admin/adminmenu/save') ?>';
    var URL_SAVE_MENU_PORADIE = '<?php echo site_url('admin/adminmenu/savePoradie') ?>';
</script>
<script src="<?php echo base_url() ?>admin_assets/js/adminmenu.js"></script>
