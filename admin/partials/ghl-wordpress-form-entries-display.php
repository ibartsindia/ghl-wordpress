<?php
$id=$_GET['id'];

$query=new Ghl_Wordpress_Query();

$form_name=$query->ibs_ghl_get_form_name($id);

echo "<h1>".$form_name." Entries </h1> ";
?>

<table class="wp-list-table widefat striped">
    <thead>
        <tr>
            <th>Entry ID</th>
            <th>Form ID</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
    
        <?php            
            $JSON=$query->ibs_ghl_get_form_entries($id);
            foreach ($JSON as $entry){
                echo '<tr>';
                echo '<td>' . esc_html($entry->id).'</td>';
                echo '<td>' . esc_html($entry->form_id).'</td>';
                ?>
                <td>
                <?php
                $decodedEntries = json_decode($entry->entries, true);
                    foreach ($decodedEntries as $Entries) {
                        foreach ($Entries as $field => $value) {
                            echo "$field => $value<br>";
                        }
                    }?></td></tr><?php 
            }
        ?>
    </tbody>
