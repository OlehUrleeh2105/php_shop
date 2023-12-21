<?php
    function uploadFiles($files, $dir) {
        if($files['files']['name'][0] == ""){
            return "Please select at least one file";
        }

        $folder = $dir;

        $names = $files['files']['name'];
        $tmp_names = $files['files']['tmp_name'];
    
        $files_array = array_combine($tmp_names, $names);
    
        foreach($files_array as $tmp_folder => $image_name){
            move_uploaded_file($tmp_folder, $folder.$image_name);
        }
    
    return TRUE;
    }    
?>