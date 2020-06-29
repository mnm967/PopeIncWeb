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
    
    //TODO itemId
    /*if(isset($_GET['id'])){
        $itemId = $_GET['id'];
        $existsQuery = mysqli_query($sqlConnection, "SELECT images FROM items WHERE id='$itemId'");
        if(mysqli_num_rows($existsQuery) == 0){
            header("Location: admin-home.php");
        }
    }else{
        header("Location: index.php");
    }*/
?>
<head>
    <title>
      <?php 
        if(isset($_GET['id'])){
            echo $item->getName();
        }else{
            echo 'Add Clothing';
        }
        ?>
    </title>
</head>
<section class="mbr-section form3 cid-rixMG5zlpO" id="form-details">
    <div class="container">
        <div class="row justify-content-center">
            <div class="title col-12 col-lg-8">
                <h2 class="align-center pb-2 mbr-fonts-style display-2">
                    UPDATE ITEM</h2>
            </div>
        </div>
        <div class="row py-4 justify-content-center">
            <div class="col-12 col-lg-6  col-md-8 ">
                    <div class="input-group">
                        <div class="input-holder">
                        <p>
                            <label for="name-form-details">Name*</label>
                            <input class="form-control" type="text" name="name-form-details" placeholder="Item Name*" id="name-form-details" required>
                        </p>
                        <p>
                            <label for="description-form-details">Description*</label>
                            <input class="form-control" type="text" name="description-form-details" placeholder="Description*" id="description-form-details" required>
                        </p>
                        <p>
                            <label for="brand-form-details">Brand*</label>
                            <input class="form-control" type="text" name="brand-form-details" placeholder="Brand*" id="brand-form-details" required>
                        </p>
                        <p>
                            <label for="price-form-details">Price (ZAR)*</label>
                            <input class="form-control" type="number" name="price-form-details" placeholder="Price (ZAR)*" id="price-form-details" required>
                        </p>
                        <p>
                            <div class="additional-info-list">
                                
                            </div>
                            <button onclick="addAdditionalItem()" name="additionalInfoButton" class="btn btn-primary display-4 align-center" style="margin: 16px 0; width: 100%;">Add Additional Info Item</button>
                        </p>
                        <p>
                            <div class="row sizes justify-content-center" >
                                <h4 class="card-title mbr-fonts-style display-6">
                                    Is Stock Available:
                                </h4>
                                <div class="size-btn-holder">
                                    <button onclick="selectAvailable('no')" class='btn btn-av btn-size-selected transition-hover display-4 btn-av-no' value="0" id='av-selected'>No</button>
                                    <button onclick="selectAvailable('yes')" class='btn btn-av btn-size-unselected transition-hover display-4 btn-av-yes' value="1">Yes</button>
                                </div>
                            </div>
                        </p>
                        <p>
                            <div class="row sizes justify-content-center">
                                <h4 class="card-title mbr-fonts-style display-6">
                                    Type:
                                </h4>
                                <div class="size-btn-holder">
                                    <button onclick="selectType('clothing')" class='btn btn-type btn-size-selected transition-hover display-4 btn-type-clothing' value="0" id='type-selected'>Clothing</button>
                                    <button onclick="selectType('shoes')" class='btn btn-type btn-size-unselected transition-hover display-4 btn-type-shoes' value="1">Shoes</button>
                                    <button onclick="selectType('accessories')" class='btn btn-type btn-size-unselected transition-hover display-4 btn-type-accessories' value="2">Accessories</button>
                                </div>
                            </div>
                        </p>
                        <p>
                            <div class="row sizes justify-content-center" >
                                <h4 class="card-title mbr-fonts-style display-6">
                                    Gender:
                                </h4>
                                <div class="size-btn-holder">
                                    <button onclick="selectGender('men')" class='btn btn-gender btn-size-selected transition-hover display-4 btn-gender-men' value="0" id='gender-selected'>Men</button>
                                    <button onclick="selectGender('women')" class='btn btn-gender btn-size-unselected transition-hover display-4 btn-gender-women' value="1">Women</button>
                                    <button onclick="selectGender('both')" class='btn btn-gender btn-size-unselected transition-hover display-4 btn-gender-both' value="2">Both</button>
                                </div>
                            </div>
                        </p>
                        <p>
                            <div class="row sizes justify-content-center" >
                                <h4 class="card-title mbr-fonts-style display-6">
                                    Available Sizes (Clothing):
                                </h4>
                                <div class="size-btn-holder">
                                    <button onclick="selectSize('xs')" class='btn btn-size btn-size-selected transition-hover display-4 btn-clothing-xs btn-clothing-selected' value="xs">XS</button>
                                    <button onclick="selectSize('s')" class='btn btn-size btn-size-unselected transition-hover display-4 btn-clothing-s' value="s">S</button>
                                    <button onclick="selectSize('m')" class='btn btn-size btn-size-unselected transition-hover display-4 btn-clothing-m' value="m">M</button>
                                    <button onclick="selectSize('l')" class='btn btn-size btn-size-unselected transition-hover display-4 btn-clothing-l' value="l">L</button>
                                    <button onclick="selectSize('xl')" class='btn btn-size btn-size-unselected transition-hover display-4 btn-clothing-xl' value="xl">XL</button>
                                    <button onclick="selectSize('xxl')" class='btn btn-size btn-size-unselected transition-hover display-4 btn-clothing-xxl' value="xxl">XXL</button>
                                </div>
                            </div>
                        </p>
                        <p>
                            <div class="row sizes justify-content-center" >
                                <h4 class="card-title mbr-fonts-style display-6">
                                    Available Sizes (Shoes):
                                </h4>
                                <div class="size-btn-holder">
                                    <button onclick="selectShoesSize('5')" class='btn btn-size btn-size-selected transition-hover display-4 btn-shoes-5 btn-shoes-selected' value="5">5</button>
                                    <button onclick="selectShoesSize('6')" class='btn btn-size btn-size-unselected transition-hover display-4 btn-shoes-6' value="6">6</button>
                                    <button onclick="selectShoesSize('7')" class='btn btn-size btn-size-unselected transition-hover display-4 btn-shoes-7' value="7">7</button>
                                    <button onclick="selectShoesSize('8')" class='btn btn-size btn-size-unselected transition-hover display-4 btn-shoes-8' value="8">8</button>
                                    <button onclick="selectShoesSize('9')" class='btn btn-size btn-size-unselected transition-hover display-4 btn-shoes-9' value="9">9</button>
                                    <button onclick="selectShoesSize('10')" class='btn btn-size btn-size-unselected transition-hover display-4 btn-shoes-10' value="10">10</button>
                                    <button onclick="selectShoesSize('11')" class='btn btn-size btn-size-unselected transition-hover display-4 btn-shoes-11' value="11">11</button>
                                    <button onclick="selectShoesSize('12')" class='btn btn-size btn-size-unselected transition-hover display-4 btn-shoes-12' value="12">12</button>
                                    <button onclick="selectShoesSize('13')" class='btn btn-size btn-size-unselected transition-hover display-4 btn-shoes-13' value="13">13</button>
                                </div>
                            </div>
                        </p>
                        </div>
                            <div class="input-group-btn">
                            <button name="detailsButton" class="btn btn-primary display-4" style="margin: 16px 0;">SAVE AND PROCEED</button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>
<script>
    var additionalItems = 0;
    function addAdditionalItem(){
        additionalItems++;
        $('.additional-info-list').append("<div class='additional-info' style='padding-top: 8px;'>\
                                    <div class='additional-item'>\
                                        <h3 class='mbr-fonts-style display-5'>Additional Item "+additionalItems+" (Optional)</h3>\
                                        <label>Name (eg. Color)</label>\
                                        <input class='form-control additioanl-item-name' type='text' name='additioanl-item-name' id='additional-item-name-"+additionalItems+"' placeholder='Name'>\
                                        <label>Detail (eg. Blue)</label>\
                                        <input class='form-control additioanl-item-detail' type='text' name='additioanl-item-detail' id='additional-item-detail-"+additionalItems+"' placeholder='Detail'>\
                                    </div>\
                                </div>");
    }
    function selectSize(size){
        var btnClass = ".btn-clothing-"+size;
        if($(btnClass).hasClass("btn-clothing-selected")){
            $(btnClass).removeClass("btn-size-selected");
            $(btnClass).addClass("btn-size-unselected");
            $(btnClass).removeClass("btn-clothing-selected");
        }else{
            $(btnClass).removeClass("btn-size-unselected");
            $(btnClass).addClass("btn-size-selected");
            $(btnClass).addClass("btn-clothing-selected");
        }
    }
    function selectShoesSize(size){
        var btnClass = ".btn-shoes-"+size;
        if($(btnClass).hasClass("btn-shoes-selected")){
            $(btnClass).removeClass("btn-size-selected");
            $(btnClass).addClass("btn-size-unselected");
            $(btnClass).removeClass("btn-shoes-selected");
        }else{
            $(btnClass).removeClass("btn-size-unselected");
            $(btnClass).addClass("btn-size-selected");
            $(btnClass).addClass("btn-shoes-selected");
        }
    }
    function selectAvailable(av){
        var btnClass = ".btn-av-"+av;
        $(".btn-av").removeClass("btn-size-selected");
        $(".btn-av").attr("id" , "");
        $(".btn-av").addClass("btn-size-unselected");

        $(btnClass).removeClass("btn-size-unselected");
        $(btnClass).addClass("btn-size-selected");
        $(btnClass).attr("id" , "av-selected");
    }
    function selectType(type){
        var btnClass = ".btn-type-"+type;
        $(".btn-type").removeClass("btn-size-selected");
        $(".btn-type").attr("id" , "");
        $(".btn-type").addClass("btn-size-unselected");

        $(btnClass).removeClass("btn-size-unselected");
        $(btnClass).addClass("btn-size-selected");
        $(btnClass).attr("id" , "type-selected");
    }
    function selectGender(gender){
        var btnClass = ".btn-gender-"+gender;
        $(".btn-gender").removeClass("btn-size-selected");
        $(".btn-gender").attr("id" , "");
        $(".btn-gender").addClass("btn-size-unselected");

        $(btnClass).removeClass("btn-size-unselected");
        $(btnClass).addClass("btn-size-selected");
        $(btnClass).attr("id" , "gender-selected");
    }

    

    function addItem(){

    }
    function updateItem($id){

    }
</script>
<?php include("../../includes/admin-footer.php");?>