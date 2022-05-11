
<?php
#sometimes, I've lost permission to create or delete folders, so this is a simple test to send to julio. If it runs, you have permissions again.
$path="\\\orspsrvapp02\\webroot2\\NDAs_dev\\folder-test-jmcn";
echo("Trying to create:". $path);
mkdir($path);


##juliomcn##
// $folderName = "../NDAs_dev/permissions/folder_test_julio";
// if (!is_dir($folderName)) {
//     mkdir($folderName, 0776, true);
// }
?>
