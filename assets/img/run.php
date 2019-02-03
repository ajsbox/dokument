<?php 
	$csv = array();

// check there are no errors
if(isset($_FILES['csv']['error']) and $_FILES['csv']['error'] == 0){
    $name = $_FILES['csv']['name'];
    $ext = explode('.', $name);
	$ext = $ext[sizeOf($ext)-1];
	
    $type = $_FILES['csv']['type'];
    $tmpName = $_FILES['csv']['tmp_name'];

    // check the file is a csv
    if($ext === 'csv'){
        if(($handle = fopen($tmpName, 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);

            $row = 0;

            while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                // number of fields in the csv
                $num = count($data);

                // get the values from the csv
                $csv[$row]['row1'] = $data[0];
                $csv[$row]['row2'] = $data[1];
				$csv[$row]['row3'] = $data[2];
                // inc the row
                $row++;
            }
            fclose($handle);
        }
    }
	print_r($csv);exit;
}
?>
<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="csv" value="" />
	<input type="submit" name="submit" value="Save" />
</form>