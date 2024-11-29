<?php $type='sds'; if($type=='pdf'){?>
<iframe target="_blank" src="AWSDEMO/uploads/apqp_activity_document/52989-6948754565APQPUserGuideVersion1.2Frontend.pdf" height="900" width="800"></iframe>
<?php }else{ ?>
<!-- <iframe src="http://localhost:81/AWSDEMO/uploads/apqp_activity_document/66547-1451523635ProjectRevision.docx&embedded=true" height="900" width="600"></iframe> -->
<?php 

$filename ="AWSDEMO/uploads/apqp_activity_document/66547-1451523635ProjectRevision.docx";
    $striped_content = '';
    $content = '';

    if(!$filename || !file_exists($filename)) return false;

    $zip = zip_open($filename);
    if (!$zip || is_numeric($zip)) return false;

    while ($zip_entry = zip_read($zip)) {

        if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

        if (zip_entry_name($zip_entry) != "word/document.xml") continue;

        $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

        zip_entry_close($zip_entry);
    }
    zip_close($zip);      
    $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
    $content = str_replace('</w:r></w:p>', "\r\n", $content);
    $striped_content = strip_tags($content);

    print_r($striped_content);


?>

<?php } ?>