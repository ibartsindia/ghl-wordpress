<?php 
class Ghl_Wordpress_Helper {
    public function get_label_name($id){
        $query=new Ghl_Wordpress_Query();
        $jsonArray=$query->ibs_ghl_get_form_meta_display($id);
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
        } 
        else {
            echo "Invalid JSON format.";
        }
        $get_label=array($labelNames,$fieldNames);
        return $get_label;
    }



}