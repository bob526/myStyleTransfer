<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('Net/SSH2.php');
include('Net/SCP.php');

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$PHP_LIMIT_SIZE = 30000000;
// Check if image file is a actual image or fake image
/*
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
*/
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size  30MB
if ($_FILES["fileToUpload"]["size"] > $PHP_LIMIT_SIZE) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
/*
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
    echo "Sorry, only JPG, JPEG & PNG files are allowed.";
    $uploadOk = 0;
}
*/
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
$videoFileName = str_replace($target_dir,"",$target_file);
//system("scp -i ~/.ssh/gslave02 -P 2223 uploads/".$videoFileName." nari@140.123.97.173:~/style_transfer/neural-style");

$ssh_connection = new Net_SSH2('140.123.97.173',2223);
if (!$ssh_connection->login('nari','1122abc')) {
    throw new Exception("Failed to login");
}

$scp_connection = new Net_SCP($ssh_connection);
//scp_connection->put('remote file name','local file name',NET_SCP_LOCAL_FILE);
if (!$scp_connection->put('style_transfer/mywork/' . $videoFileName,$target_file,NET_SCP_LOCAL_FILE)) {
    throw new Exception("Failed to send file");
}

echo "Uploaded to Computing Server<br>";

echo $ssh_connection->exec('./style_transfer/mywork/cutvideo.run '. $videoFileName . ' ' . '5000');
echo "Run cutvideo.run completed!.<br>";
?>
