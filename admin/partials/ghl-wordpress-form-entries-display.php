<?php
$id=$_GET['id'];

$helper= new Ghl_Wordpress_Helper();
$get_label=$helper->get_label_name($id);
$labelNames=$get_label[0];
$fieldNames=$get_label[1];

$query=new Ghl_Wordpress_Query();

$form_name=$query->ibs_ghl_get_form_name($id);

echo "<h1>".$form_name." Entries </h1> ";
?>

<table class="wp-list-table widefat striped">
    <thead>
        <tr>
            <th>Entry ID</th>
            <th>Form ID</th>
            <th>Field Name</th>
            <th>Field Value</th>
            
        </tr>
    </thead>
    <tbody>
    
        <?php 
            
            
            $JSON=$query->ibs_ghl_get_form_entries($id);

            foreach ($JSON as $entry){
                $field_name_show=array();
                $field_value_show=array();
                echo '<tr>';
                echo '<td>' . esc_html($entry->id).'</td>';
                echo '<td>' . esc_html($entry->form_id).'</td>';
                
                
                $decodedEntries = json_decode($entry->entries, true);
                
                foreach ($decodedEntries as $field => $value) {                
                    if ($field=='Submit'){
                        continue;
                    }
                    else{
                        for($j=0;$j<3;$j++){
                            if($field == $fieldNames[$j]){
                                    array_push($field_name_show,$labelNames[$j]);
                                    array_push($field_value_show,$value);
                                    break;
                                }
                            }
                    }
                            
                }
                    
                echo "<td>";
                for($i=0;$i<count($field_name_show);$i++){
                    echo "$field_name_show[$i]<br>";
                }
                echo "</td>";

                echo "<td>";
                for($i=0;$i<count($field_value_show);$i++){
                    echo "$field_value_show[$i]<br>";
                }
                echo "</td>";
                echo"</tr>"; 
            }
        ?>
    </tbody>
</table>
