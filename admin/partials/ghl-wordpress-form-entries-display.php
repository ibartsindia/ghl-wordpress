<!-- Displaying the Entries of the database save in the particular form  -->
<?php
$id=$_GET['id'];

//helper function
$helper= new Ghl_Wordpress_Helper();
$get_label=$helper->get_label_name($id);
$labelNames=$get_label[0];
$fieldNames=$get_label[1];

$query=new Ghl_Wordpress_Query();

//Get the form name as per the ID
$form_name=$query->ibs_ghl_get_form_name($id);

echo "<h1>".$form_name." Entries </h1> ";
?>

<table class="wp-list-table widefat striped">
    <thead>
        <tr>
            <th style="width:132px;">Entry ID</th>
            <th style="width:162px;">Form ID</th>
            <th style="width:12px;">Field Name</th>
            <th style="width:232px;">Field Value</th>
        </tr>
    </thead>
    <tbody>
    
    <?php
        //get the form entries data 
        $JSON=$query->ibs_ghl_get_form_entries($id);
        foreach ($JSON as $entry){
            $field_name_show=array();
            $field_value_show=array();
            echo '<tr>';
            echo '<td>' . esc_html($entry->id).'</td>';
            echo '<td>' . esc_html($entry->form_id).'</td>';
            
            //decoding the entries json 
            $decodedEntries = json_decode($entry->entries, true);
            foreach ($decodedEntries as $field => $value) {                
                if ($field=='Submit'){
                    continue;
                }
                else{
                        for($j=0;$j<count($labelNames);$j++){
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
