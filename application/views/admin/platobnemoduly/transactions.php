<div class="well">

    <table class="table table-hover">
        <thead>
            <tr>
                <th>TXN ID</th>
                <th>User ID</th>
                <th>Suma</th>
                <th>Datum</th>
                <th>Brana</th>
                <th>IP</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                 if (is_array($data) && count($data)>0 ){
            foreach ($data as $row) { ?>
                <tr class="">
                    <td><?php echo $row->txn_id; ?></td>
                    <td><?php echo $row->user_id; ?></td>
                    <td><?php echo $row->amount; ?> <?php echo $row->currency; ?></td>
                    
                    <td><?php echo formatCasu($row->date); ?></td>
                    <td><?php echo $row->gateway; ?></td>
                    <td><?php echo $row->ip; ?></td>
                </tr>

            <?php }  }else{ ?>
                <tr><td colspan="6" style="text-align: center;"><i><?php echo lang('a_empty_table'); ?></i></td></tr>
          <?php  } ?>
        </tbody>

    </table>
</div>
<div class="clear"></div>

