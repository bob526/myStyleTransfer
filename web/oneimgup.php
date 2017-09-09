<?php
/**This page is write for style image uploading**/
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('Net/SSH2.php');
include('Net/SCP.php');

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$PHP_LIMIT_SIZE = 30000000;
$downloadFolder = 'download/';

exec("rm -f ".$downloadFolder."oneimg*");


// Check if image file is a actual image or fake image
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
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.<br>";
    $uploadOk = 0;
}
// Check file size  30MB
if ($_FILES["fileToUpload"]["size"] > $PHP_LIMIT_SIZE) {
    echo "Sorry, your file is too large.<br>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
    echo "Sorry, only JPG, JPEG & PNG files are allowed.<br>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.<br>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
    } else {
        echo "Sorry, there was an error uploading your file.<br>";
    }
}
$imageFileName = str_replace($target_dir,"",$target_file);
//system("scp -i ~/.ssh/gslave02 -P 2223 uploads/".$imageFileName." nari@140.123.97.173:~/style_transfer/neural-style");

$ssh_connection = new Net_SSH2('140.123.97.173',2223);
if (!$ssh_connection->login('nari','1122abc')) {
    throw new Exception("Failed to login");
}


//Need Change
//Const String Declare
$oneimgtranPath = "./style_transfer/neural-style/oneimgtran/";
$contentDir = "content/";
$styleDir = "style/";
$outputDir = "output/";

$scp_connection = new Net_SCP($ssh_connection);
//scp_connection->put('remote file name','local file name',NET_SCP_LOCAL_FILE);
if (!$scp_connection->put($oneimgtranPath.$imageFileName , $target_file,NET_SCP_LOCAL_FILE)) {
    throw new Exception("Failed to send file");
}

echo "Uploaded to Computing Server<br>";
/*
$cutimageRunPath = "./style_transfer/mywork/";
$cutimageProgramName = "cutimage.run";
$cutimageOutputFolder = "output/";

echo $ssh_connection->exec($cutimageRunPath.$cutimageProgramName.' '.$cutimageRunPath.$imageFileName.' '.'5000'.' '.$cutimageRunPath.$cutimageOutputFolder);
echo "Run cutimage.run completed!.<br>";

$picNum = (int) $ssh_connection->exec('ls '.$cutimageRunPath.$cutimageOutputFolder.' '.'-1 | wc -l');
echo "The picNum = ".$picNum.'<br>';



for ($i=0;$i<$picNum;$i++) {
	$theFileName = 'img'.($i+1).'.jpg';
	if(!$scp_connection->get($cutimageRunPath.$cutimageOutputFolder.$theFileName,$downloadFolder.$theFileName)) {
		throw new Exception("Failed to download file".$theFileName);
	}

	//Delete the image
	$ssh_connection->exec("rm ".$cutimageRunPath.$cutimageOutputFolder.$theFileName);
}

//Delete image file
$ssh_connection->exec("rm ".$cutimageRunPath.$imageFileName);
exec("rm -f ".$target_dir.$imageFileName);

echo "<a href=\"download/index.html\">Click Here to Redirect to the New Page</a>"
*/


?>
