
<?php
require('vendor/autoload.php');
require_once('config/config.php');
use Vimeo\Vimeo;

if(isset($_POST['upload-btn'])){

    $client = new Vimeo($clientId,$clientSecret,$accessToken);
    $response = $client->request('/tutorial', array(), 'GET');
    
    $file = $_FILES['file1']['name'];  
    $tmp = $_FILES['file1']['tmp_name'];
    
	$title = $_POST['vidtitle'];
	$desc = $_POST['viddesc'];
    
	$uri = $client->upload($tmp, array(
		"name" => "$title",
		"description" => "$desc",
    ));

    $response = $client->request($uri . '?fields=transcode.status');

    if ($response['body']['transcode']['status'] === 'complete') {
        print 'Your video finished transcoding.';
    } 
    elseif ($response['body']['transcode']['status'] === 'in_progress') {
        print 'Video Uploading Done. (your video is still processing..please try to access your video after few minutes)';
    }
    else {
	   print 'Your video encountered an error during transcoding.';
    }
    
    $response = $client->request($uri . '?fields=link');
    $video_link = $response['body']['link'];
    
    $get_vid_id = explode("/",$video_link);
    
    $get_vid_id = $get_vid_id['3'];


    //database insert
    $connection = mysqli_connect('localhost','root','','vimeo_php');

    $sql = "INSERT INTO vimeo_php(video_id,title,description) VALUES ('$get_vid_id','$title','$desc')";

    $run = mysqli_query($connection,$sql);

    if($run){
        echo "data inserted";
    }
    else{
        echo mysqli_error($connection);
    }


}