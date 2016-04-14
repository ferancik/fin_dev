<div class="well">
    
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Identifikator</th>
                        <th>Data</th>
                         <th>Cas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row) { ?>
                        <tr class="">
                            <td><?php echo $row->log_id; ?></td>
                             <td><pre><?php echo $row->log_data; ?></pre></td>
                             <td><?php echo $row->log_created 	; ?></td>
                        </tr>

                    <?php } ?>
                    
                </tbody>

            </table>
    </div>
<div class="clear"></div>
