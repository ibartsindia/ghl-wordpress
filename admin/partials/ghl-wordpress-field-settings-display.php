<!-- When Settings option is clicked this html will show -->
<h1>Field Settings of Form No.<?php echo $id;?> </h1>

<?php
$query=new Ghl_Wordpress_Query();

//helper function
$helper= new Ghl_Wordpress_Helper();
$get_label=$helper->get_label_name($id);
$labelNames=$get_label[0];
$fieldNames=$get_label[1];

//get the mapped data
$form_mapping_data=$query->ibs_ghl_get_form_mapping_data($id);
$decoded_mapped_data=json_decode($form_mapping_data[0]->mapped_data);
$mapName=array();

foreach($decoded_mapped_data as $decodedField => $decodedValue){
    array_push($mapName,$decodedValue);
}


//set GHL dropdown fields
$GHL_fields=array("name","email","phone","dateOfBirth","state");
?>
<div >
    <h2 style="margin-right:40px;">Field Mapping </h2>
    <form method="post" >
        <table class="wp-list-table widefat striped">
            <thead>
                    <tr>
                        <th style="width:132px;">GHL fields</th>
                        <th style="width:132px;">Form Fields</th>
                    </tr>
            </thead>
            <tbody>    
                <?php
                    $j=0;
                    foreach($GHL_fields as $field){//settings page dropdown
                        echo "<tr>";
                            echo "<td>".esc_html(ucfirst($field))."</td>";
                            ?>
                            <td><select name='form_field<?php echo $field ?>' id='form_field'>
                            <?php
                            echo'<option value="select">Select</option>';
                            $x=1;
                            for ($i = 0; $i < count($fieldNames); $i++) {

                                //checking if value is mapped then it will show default in dropdown
                                if(($j<count($GHL_fields)) && $x && strpos($mapName[$j],$fieldNames[$i])!==false){
                                    $x=0;
                                    echo $j; ?>
                                    <option value='<?php echo $fieldNames[$i]; ?>' selected><?php echo $labelNames[$i]; ?>
                                    </option>
                                <?php }
                                else{ ?>
                                    <option value='<?php echo $fieldNames[$i]; ?>'><?php echo $labelNames[$i]; ?>
                                    </option>
                                <?php }
                            }
                            $j++;
                            echo "</select></td>";
                        echo "</tr>"; 
                    }
                ?>
            </tbody>
        </table>
        <button type='submit' style='width:60px; height:30px;'>Save</button>
    </form>  
</div>

<?php

//Save in mapped data in database 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $update_mapped_data=array();
    foreach($GHL_fields as $field){
        $update_mapped_data[$field]=$_POST["form_field$field"];
    }
    $jsonEncode=json_encode($update_mapped_data);
    $query->update_field_mapping($id,$jsonEncode);
    
    //for a single reload 
    echo "<script type='text/javascript'>
        window.location=document.location.href;
        </script>"; 
}
?>