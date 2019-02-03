<?php //$table = base64_encode($table_name); 

  $path = base64_encode(getcwd() . "\\assets\\app\\file_upload\\uploads\\".$table_name.'\\'.$file_name);
 // echo $file_name;exit;
?>
<iframe src="<?=$url?>assets/app/file_upload/uploads/scaner/online_demo_scan.php?doc_id=<?=$docId?>&table_name=<?=$table_name?>&file_name=<?=$file_name?>&url=<?=$url?>&desc=<?=$description?>&main=<?=$main?>" height="98%;" width="100%"></iframe>