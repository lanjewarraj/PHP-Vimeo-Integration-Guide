<?php
//database insert
$connection = mysqli_connect('localhost','root','','test_vimeo');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Play you video</title>
</head>
<body>
    <div class="video-container">
        <?php
        $select = "SELECT * FROM vimeo_php";
        $run = mysqli_query($connection,$select);
        if($run){
            foreach($run as $rows){
                ?>

        <div class="video-content">
            <div class="vid-player">
                <iframe src="https://player.vimeo.com/video/<?php echo $rows['video_id'];?>" width="400" height="400" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
            <div class="vid-text">
                <h1><?php echo $rows['title'];?></h1>
                <p><?php echo $rows['description'];?></p>
            </div>
        </div>

        <?php }
        }
        ?>
    </div>
<script src="https://player.vimeo.com/api/player.js"></script>
</body>
</html>