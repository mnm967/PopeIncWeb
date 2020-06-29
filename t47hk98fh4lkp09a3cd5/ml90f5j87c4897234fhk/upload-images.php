<?php include("../../includes/admin-header.php");?>
<?php 
    include("../../includes/classes/Item.php");

    if(isset($_SESSION['userLoggedIn'])){
        if($_SESSION['userLoggedIn'] ==  AdminConstants::$adminId){
        }else{
            header("Location: admin-login.php");
        }
        $user = new User($sqlConnection, $_SESSION['userLoggedIn']);
    }else{
        header("Location: admin-login.php");
    }
    if(isset($_GET['id'])){
        $itemId = $_GET['id'];
    }else{
        header("Location: admin-home.php");
    }
    $query = mysqli_query($sqlConnection, "SELECT images FROM items WHERE id='$itemId'");
    if(mysqli_num_rows($query ) == 0){
        header("Location: admin-home.php");
    }
    $row = mysqli_fetch_array($query);
    $images = json_decode($row['images'], true);

    $item = new Item($sqlConnection, $itemId);

    if(isset($_POST["submit"])) {
        //echo $_FILES["fileToUpload"]["tmp_name"];
        if($_FILES["fileToUpload"]["name"] == ""){
            echo "<div><h2 class='align-center pb-2 mbr-fonts-style display-5'>Please choose an image.<h2></div>";
        }else{
            $target_dir = "../../assets/images/";

            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            //$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            /*if($check !== false) {
                $uploadOk = 1;
            } else {
                $error = "File is not an image.";
                $uploadOk = 0;
            }*/
            /*if(file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }*/
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "bmp" ) {
                    $error = "Sorry, only images are allowed.";
                    $uploadOk = 0;
            }
            if($uploadOk == 0) {
                echo "<div><h2 class='align-center pb-2 mbr-fonts-style display-5'>Sorry, your file was not uploaded - $error.<h2></div>";
            }else{
                $permitted_chars = "0123456789abcdefghijklmnopqrstuvwxyz";
                $name = substr(str_shuffle($permitted_chars), 0, 13);

                if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir.$name.".".$imageFileType)){
                    //echo "The file ". basename($_FILES["fileToUpload"]["name"]). " has been uploaded.";
                    echo "<div><h2 class='align-center pb-2 mbr-fonts-style display-5'>Your file uploaded successfully.</h2></div>";
                    array_push($images, "assets/images/".$name.".".$imageFileType);
                    $newJSON = json_encode($images);
                    $addQuery = mysqli_query($sqlConnection, "UPDATE items SET images='$newJSON' WHERE id='$itemId'");
                }else{
                    echo "<div><h2 class='align-center pb-2 mbr-fonts-style display-5'>Sorry, there was an error uploading this file. Please use a different file.</h2></div>";
                }
            }
        }
    }
?>
<head>
    <title>
      <?php
            echo $item->getName();?>
    </title>
</head>
<section class="mbr-section form3 cid-rixMG5zlpO" id="form-details" style="padding: 32px">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="align-center pb-2 mbr-fonts-style display-2">
      <?php 
            echo $item->getName();
        ?></h2>
            </div>
        </div>
        <div class="row justify-content-center">
        <form action="upload-images.php?id=<?php echo $itemId;?>" method="post" enctype="multipart/form-data">
            <label style="display: block; width: 100%">Select image to upload by clicking 'Browse' then click 'Upload':</label>
            <input type="file" name="fileToUpload" id="fileToUpload" style="display: block; width: 100%">
            <input type="submit" value="Upload Image" name="submit" style="display: block; width: 100%">
        </form>
        </div>
    <div class="container">
        <div class="row justify-content-center">
            <?php
                foreach($images as $img){
                    echo "<div class='item-card col-12 col-md-4 col-lg-2 col-sm-4'>
                        <div class='card-wrapper'>
                                <div class='card-img'>
                                    <img src='../../$img' alt='$img'>
                                </div>
                                <div class='mbr-section-btn align-center' >
                                    <button onclick=\"removeImageLink($itemId, '$img')\" class='btn btn-warning-outline display-4'>REMOVE</button>
                                </div>
                            </div>
                        </div>";
                }
            ?>
        </div>
    </div>
</section>
<script>
    function removeImageLink(itemId, img){
        $.post("includes/ajax/remove-image.php", {itemId: itemId, img: img}, function(result){
            window.location.href = window.location.href;
        });
    }
</script>
<?php include("../../includes/admin-footer.php");?>