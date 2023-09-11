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
$mapName=array($decoded_mapped_data->name,$decoded_mapped_data->email,$decoded_mapped_data->phone);

//set GHL dropdown fields
$GHL_fields=array("Name","Email","Phone");
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
                            echo "<td>$field</td>";
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
    foreach($GHL_fields as $field){
        if(isset($_POST["form_field$field"])){
            if($field=='Name'){
                $user_name=$_POST["form_field$field"];
            }
            else if($field=='Email'){
                $user_email=$_POST["form_field$field"];
            }
            else if($field=='Phone'){
                $user_phone=$_POST["form_field$field"];
            }  
        }
    }
    $query->update_field_mapping($id,$user_name,$user_email,$user_phone);
    
    //for a single reload 
    echo "<script type='text/javascript'>
        window.location=document.location.href;
        </script>"; 
}
?>