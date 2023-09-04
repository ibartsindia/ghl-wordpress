
<script>
    function addMoreFields() {
    
    var container = document.getElementById("container");
    
    var newFields = document.createElement("div");
    newFields.className = "location_and_api_form"; // Add a class to style the container
    newFields.innerHTML = `
        <input class="location_name_field" type="text" name="" placeholder="">
        <input class="location_api_field" type="text" name="" placeholder="">
    `;
    container.appendChild(newFields);
}
</script>
<h1>Field Settings of Form No.<?php echo $id;?> </h1>

<?php
$query=new Ghl_Wordpress_Query();
$jsonArray=$query->ibs_ghl_get_form_meta_display($id);
// var_dump($jsonArray);
$data = json_decode(stripslashes($jsonArray), true);

if ($data !== null) {
    
    $labelNames = [];
    $fieldNames=[];
    foreach ($data as $item) {
        if (isset($item['label'])) {
            $labelNames[] = $item['label'];
            $fieldNames[] = $item['name'];
        }
    }
    // print_r($labelNames);
} else {
    echo "Invalid JSON format.";
}
?>
<div style="display:flex;">
    <h2 style="margin-right:40px;">Field Mapping </h2>
    <form method="post" style="display:flex;">
        <div>
            <h4 style="margin-right:40px;">GHL Field</h4>
            <select name="GHL" id="GHL_field">
                <option >Default</option>
                <option value="Name">Name</option>
                <option value="Email">Email</option>
                <option value="Phone">Phone</option>
                <option value="Submit">Submit</option>
            </select>
        </div>
        <div>
            <h4 style="margin-right:40px;">Form Field Label</h4>
            <?php
                echo'<select name="form_field" id="form_field">';
                echo'<option >Default</option>';
                for($i=0;$i<count($labelNames);$i++){
                    echo"<option value='$fieldNames[$i]'>$labelNames[$i]</option>";       
                }?>
                </select>
        </div>
        
        <button name='submitted' type='submit' style="width:60px; height:30px; margin-top:50px; margin-left:20px;">Save</button>
    </form>
</div>
<input type="hidden" name="total_forms" value="<?php echo esc_attr($totalForms); ?>">
            <!-- <input class="location_submit_button" type="submit" name='submitted' value="Submit"> -->
            <input type="hidden" name="total_forms" value="<?php echo esc_attr($totalForms + 1);?>">
            <button class="location_addmore_button" type="button" onclick="addMoreFields()">+</button>
<!-- <h2>Mapped Form fields with GHL Fields</h2> -->
<?php
$map=array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["field_value"])) {
        if(isset($_POST["submitted"])){
            foreach ($data as &$item) {
                if (isset($item['label']) && $item['label'] === $_POST["form_field"]) {
                    $query->ibs_ghl_update_form_mapping($id,$user_name,$user_email,$user_phone);     
                    break;
                }
            }
            $encoded_json=json_encode($data);
            $escapedJsonString = str_replace('"', '\"', $encoded_json);
            // var_dump( $escapedJsonString);
            $query->ibs_ghl_update_form_display_meta($id,$escapedJsonString);
            // echo "<script type='text/javascript'>
            //         window.location=document.location.href;
            //       </script>";
            
        }
        
    }
}
?>
