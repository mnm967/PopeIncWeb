<?php include("../../includes/admin-header.php");?>
<?php
    include("../../includes/classes/Item.php");
    include("../../includes/classes/Constants.php");

    if(isset($_SESSION['userLoggedIn'])){
        if($_SESSION['userLoggedIn'] ==  AdminConstants::$adminId){
        }else{
            header("Location: admin-login.php");
        }
        $user = new User($sqlConnection, $_SESSION['userLoggedIn']);
    }else{
        header("Location: admin-login.php");
    }
    
    if(isset($_GET['type'])){
        $type = $_GET['type'];
    }else{
        header("Location: admin-home.php");
    }
    if(isset($_GET['s'])){
        $gender = $_GET['s'];
    }else{
        header("Location: admin-home.php");
    }
    
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    $itemsPerPage = 20;
    $offset = ($page - 1) * $itemsPerPage;

    $brand = null;
    if(isset($_GET['brand'])){
        $brand = $_GET['brand'];
    }
    $clothing_size = null;
    if(isset($_GET['clothing_size'])){
        $clothing_size = strtoupper($_GET['clothing_size']);
    }
    $shoe_size = null;
    if(isset($_GET['shoe_size'])){
        $shoe_size = $_GET['shoe_size'];
    }
    $price = null;
    if(isset($_GET['price'])){
        $price = $_GET['price'];
    }
    $sortBy = null;
    if(isset($_GET['sortBy'])){
        $sortBy = $_GET['sortBy'];
    }
    $accessoryType = null;
    if(isset($_GET['accessoryType'])){
        $sortBy = $_GET['accessoryType'];
    }

    function getUrlClothingSize($type, $gender, $price, $sortBy, $brand, $size, $accessoryType){
        $link = "admin-clothing.php?type=$type&s=$gender";
        if($price != null) $link .= "&price=$price";
        if($brand != null) $link .= "&brand=$brand";
        if($sortBy != null) $link .= "&sortBy=$sortBy";
        if($accessoryType != null) $link .= "&accessoryType=$accessoryType";

        $link .= "&clothing_size=$size";
        return $link;
    }
    function getUrlShoeSize($type, $gender, $price, $sortBy, $brand, $size, $accessoryType){
        $link = "admin-clothing.php?type=$type&s=$gender";
        if($price != null) $link .= "&price=$price";
        if($brand != null) $link .= "&brand=$brand";
        if($sortBy != null) $link .= "&sortBy=$sortBy";
        if($accessoryType != null) $link .= "&accessoryType=$accessoryType";

        $link .= "&shoe_size=$size";
        return $link;
    }
    function getUrlSortBy($type, $gender, $price, $clothing_size, $brand, $sortOrder, $accessoryType){
        $link = "admin-clothing.php?type=$type&s=$gender";
        if($price != null) $link .= "&price=$price";
        if($brand != null) $link .= "&brand=$brand";
        if($clothing_size != null) $link .= "&clothing_size=$clothing_size";
        if($accessoryType != null) $link .= "&accessoryType=$accessoryType";

        $link .= "&sortBy=$sortOrder";
        return $link;
    }
    function getUrlPage($type, $gender, $price, $clothing_size, $brand, $sortBy, $page, $accessoryType){
        $link = "admin-clothing.php?type=$type&s=$gender";
        if($price != null) $link .= "&price=$price";
        if($brand != null) $link .= "&brand=$brand";
        if($clothing_size != null) $link .= "&clothing_size=$clothing_size";
        if($sortBy != null) $link .= "&sortBy=$sortBy";
        if($accessoryType != null) $link .= "&accessoryType=$accessoryType";

        $link .= "&page=$page";
        return $link;
    }
?>
<head>
  <title><?php
    if($type == "accessories") echo "Accessories";
    else echo ucfirst($gender) ."'s " . ucfirst($type);
  ?></title>
</head>

<section class="mbr-section content4 cid-riDo1i5eiF" id="content4-y" style="padding-top: 9px; background-color: #fff !important;">
    <div class="container">
        <div class="media-container-row">
            <div class="title col-12 col-md-8">
                <h2 class="align-center pb-3 mbr-fonts-style display-2">
                    <?php echo ucfirst($type)?> For <?php echo ucfirst($gender)?></h2>
                <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-7">
                    <?php
                        if($type == "clothing" && $gender == "men") echo Constants::$mensClothingDescription;
                        if($type == "shoes" && $gender == "men") echo Constants::$mensShoesDescription;
                        if($type == "clothing" && $gender == "women") echo Constants::$womensClothingDescription;
                        if($type == "shoes" && $gender == "women") echo Constants::$womensShoesDescription;
                        if($type == "accessories") echo Constants::$accessoriesDescription;
                    ?>
                </h3>
                
            </div>
        </div>
    </div>
</section>

<section class="mbr-section sorting-container">
    <div class="container" style="padding: 0 26px 0 0 !important;">
        <div class="row align-center">
            <div class="dropdown col-12 col-md-4 col-lg-3 col-sm-4">
                <button class="btn btn-secondary dropdown-toggle dropdown-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php 
                        if($price != null){
                            echo "Up to R" . $price;
                        }else{
                            echo "Price";
                        }
                    ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php 
                        $link = "admin-clothing.php?type=$type&s=$gender";
                        if($clothing_size != null) $link .= "&clothing_size=$clothing_size";
                        if($shoe_size != null) $link .= "&shoe_size=$shoe_size";
                        if($brand != null) $link .= "&brand=$brand";
                        if($sortBy != null) $link .= "&sortBy=$sortBy";
                        if($accessoryType != null) $link .= "&accessoryType=$accessoryType";
                            
                        echo "<a class='dropdown-item' href='$link'>Any</a>";
                    ?>
                    <?php 
                        $maxQuery = mysqli_query($sqlConnection, "SELECT MAX(price) AS 'maxPrice' FROM items");
                        $maxRow = mysqli_fetch_array($maxQuery);
                        $maxPrice = $maxRow['maxPrice'];

                        $minQuery = mysqli_query($sqlConnection, "SELECT MIN(price) AS 'minPrice' FROM items");
                        $minRow = mysqli_fetch_array($minQuery);
                        $minPrice = $minRow['minPrice'];

                        $minRounded = ceil($minPrice / 100) * 100;
                        $maxRounded = ceil($maxPrice / 100) * 100;

                        $link = "admin-clothing.php?type=$type&s=$gender";
                        if($clothing_size != null) $link .= "&clothing_size=$clothing_size";
                        if($shoe_size != null) $link .= "&shoe_size=$shoe_size";
                        if($brand != null) $link .= "&brand=$brand";
                        if($sortBy != null) $link .= "&sortBy=$sortBy";
                        if($accessoryType != null) $link .= "&accessoryType=$accessoryType";

                        do{
                            echo "<a class='dropdown-item' href='$link&price=$minRounded'>Up to R$minRounded</a>";
                            $minRounded += 100;
                        }while($minRounded <= $maxRounded)
                    ?>
                </div>
            </div>
            <div class="dropdown col-12 col-md-4 col-lg-3 col-sm-4">
                <button class="btn btn-secondary dropdown-toggle dropdown-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php 
                        if($brand != null){
                            echo ucfirst($brand);
                        }else{
                            echo "Brand";
                        }
                    ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php 
                        $link = "admin-clothing.php?type=$type&s=$gender";
                        if($clothing_size != null) $link .= "&clothing_size=$clothing_size";
                        if($shoe_size != null) $link .= "&shoe_size=$shoe_size";
                        if($price != null) $link .= "&price=$price";
                        if($sortBy != null) $link .= "&sortBy=$sortBy";
                        if($accessoryType != null) $link .= "&accessoryType=$accessoryType";
                            
                        echo "<a class='dropdown-item' href='$link'>Any</a>";
                    ?>
                    <?php 
                        $query = mysqli_query($sqlConnection, "SELECT DISTINCT brand FROM items");
                        
                        $link = "admin-clothing.php?type=$type&s=$gender";
                        if($clothing_size != null) $link .= "&clothing_size=$clothing_size";
                        if($shoe_size != null) $link .= "&shoe_size=$shoe_size";
                        if($price != null) $link .= "&price=$price";
                        if($sortBy != null) $link .= "&sortBy=$sortBy";
                        if($accessoryType != null) $link .= "&accessoryType=$accessoryType";

                        while($row = mysqli_fetch_array($query)){
                            $brandName = $row['brand'];
                            $brandLinkName = strtolower($brandName);
                            echo "<a class='dropdown-item' href='$link&brand=$brandLinkName'>$brandName</a>";
                        }
                    ?>
                </div>
            </div>
            <div class="dropdown col-12 col-md-4 col-lg-3 col-sm-4" style="<?php if($type != "shoes") echo 'display: none;'?>">
                <button class="btn btn-secondary dropdown-toggle dropdown-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Shoe Size
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"><?php
                        $link = "admin-clothing.php?type=$type&s=$gender";
                        if($price != null) $link .= "&price=$price";
                        if($brand != null) $link .= "&brand=$brand";
                        if($sortBy != null) $link .= "&sortBy=$sortBy";
                        if($accessoryType != null) $link .= "&accessoryType=$accessoryType";
                            
                        echo "<a class='dropdown-item' href='$link'>Any</a>";
                    ?>
                    <a class="dropdown-item" href="<?php echo getUrlShoeSize($type, $gender, $price, $sortBy, $brand, "3", $accessoryType)?>">3 UK</a>
                    <a class="dropdown-item" href="<?php echo getUrlShoeSize($type, $gender, $price, $sortBy, $brand, "4", $accessoryType)?>">4 UK</a>
                    <a class="dropdown-item" href="<?php echo getUrlShoeSize($type, $gender, $price, $sortBy, $brand, "5", $accessoryType)?>">5 UK</a>
                    <a class="dropdown-item" href="<?php echo getUrlShoeSize($type, $gender, $price, $sortBy, $brand, "6", $accessoryType)?>">6 UK</a>
                    <a class="dropdown-item" href="<?php echo getUrlShoeSize($type, $gender, $price, $sortBy, $brand, "7", $accessoryType)?>">7 UK</a>
                    <a class="dropdown-item" href="<?php echo getUrlShoeSize($type, $gender, $price, $sortBy, $brand, "8", $accessoryType)?>">8 UK</a>
                </div>
            </div>
            <div class="dropdown col-12 col-md-4 col-lg-3 col-sm-4" style="<?php if($type != "clothing") echo 'display: none;'?>">
                <button class="btn btn-secondary dropdown-toggle dropdown-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Clothing Size
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"><?php 
                        $link = "admin-clothing.php?type=$type&s=$gender";
                        if($price != null) $link .= "&price=$price";
                        if($brand != null) $link .= "&brand=$brand";
                        if($sortBy != null) $link .= "&sortBy=$sortBy";
                        if($accessoryType != null) $link .= "&accessoryType=$accessoryType";
                            
                        echo "<a class='dropdown-item' href='$link'>Any</a>";
                    ?>
                    <a class="dropdown-item" href="<?php echo getUrlClothingSize($type, $gender, $price, $sortBy, $brand, "xs", $accessoryType)?>">XS</a>
                    <a class="dropdown-item" href="<?php echo getUrlClothingSize($type, $gender, $price, $sortBy, $brand, "s", $accessoryType)?>">S</a>
                    <a class="dropdown-item" href="<?php echo getUrlClothingSize($type, $gender, $price, $sortBy, $brand, "m", $accessoryType)?>">M</a>
                    <a class="dropdown-item" href="<?php echo getUrlClothingSize($type, $gender, $price, $sortBy, $brand, "l", $accessoryType)?>">L</a>
                    <a class="dropdown-item" href="<?php echo getUrlClothingSize($type, $gender, $price, $sortBy, $brand, "xl", $accessoryType)?>">XL</a>
                    <a class="dropdown-item" href="<?php echo getUrlClothingSize($type, $gender, $price, $sortBy, $brand, "xxl", $accessoryType)?>">XXL</a>
                </div>
            </div>

             <div class="dropdown col-12 col-md-4 col-lg-3 col-sm-4" style="<?php if($type != "accessories") echo 'display: none;'?>">
                <button class="btn btn-secondary dropdown-toggle dropdown-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                        if($accessoryType != null){
                            echo ucfirst($accessoryType);
                        }else{
                            echo "Accessory Type";
                        }
                    ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"><?php
                        $query = mysqli_query($sqlConnection, "SELECT DISTINCT accessoryType FROM items");
                        
                        $link = "admin-clothing.php?type=$type&s=$gender";
                        if($clothing_size != null) $link .= "&clothing_size=$clothing_size";
                        if($shoe_size != null) $link .= "&shoe_size=$shoe_size";
                        if($brand != null) $link .= "&brand=$brand";
                        if($price != null) $link .= "&price=$price";
                        if($sortBy != null) $link .= "&sortBy=$sortBy";
                        if($accessoryType != null) $link .= "&accessoryType=$accessoryType";

                        while($row = mysqli_fetch_array($query)){
                            $acType = $row['accessoryType'];
                            $acTypeLink = strtolower($acType);
                            echo "<a class='dropdown-item' href='$link&accessoryType=$acTypeLink'>$acType</a>";
                        }
                    ?></div>
            </div>

            <div class="dropdown col-12 col-md-4 col-lg-3 col-sm-4">
                <button class="btn btn-secondary dropdown-toggle dropdown-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sort By: <?php
                        if($sortBy != null){
                            switch($sortBy){
                                case "time_desc": echo "Latest"; break;
                                case "time_asc": echo "Oldest"; break;
                                case "brand_asc": echo "Brand ASC"; break;
                                case "brand_desc": echo "Brand DESC"; break;
                                case "price_asc": echo "Price ASC"; break;
                                case "price_desc": echo "Price DESC"; break;
                            }
                        }else{
                            echo "Latest";
                        }
                    ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="<?php echo getUrlSortBy($type, $gender, $price, $clothing_size, $brand, "time_desc", $accessoryType);?>">Latest</a>
                    <a class="dropdown-item" href="<?php echo getUrlSortBy($type, $gender, $price, $clothing_size, $brand, "time_asc", $accessoryType);?>">Oldest</a>
                    <a class="dropdown-item" href="<?php echo getUrlSortBy($type, $gender, $price, $clothing_size, $brand, "brand_asc", $accessoryType);?>">Brand ASC</a>
                    <a class="dropdown-item" href="<?php echo getUrlSortBy($type, $gender, $price, $clothing_size, $brand, "brand_desc", $accessoryType);?>">Brand DESC</a>
                    <a class="dropdown-item" href="<?php echo getUrlSortBy($type, $gender, $price, $clothing_size, $brand, "price_asc", $accessoryType);?>">Price ASC</a>
                    <a class="dropdown-item" href="<?php echo getUrlSortBy($type, $gender, $price, $clothing_size, $brand, "price_desc", $accessoryType);?>">Price DESC</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="items-container cid-riDn13Ln0F" id="services1-x">
    <div class="container">
        <div class="row justify-content-center">
            <?php
                $resultCount = 0;

                $genderId = 0;
                if($gender == "men") $genderId = 0;
                if($gender == "women") $genderId = 1;
                if($gender == "all") $genderId = 2;

                $typeId = 0;
                if($type == "clothing") $typeId = 0;
                if($type == "shoes") $typeId = 1;
                if($type == "accessories") $typeId = 2;
                
                //$queryString = "SELECT id FROM items WHERE gender in ($genderId, 2) AND type='$typeId'";
                $queryString = "SELECT COUNT(*) FROM items WHERE gender in ($genderId, 2) AND type='$typeId'";
                if($brand != null){
                    $queryString .= " AND brand='$brand'";
                }
                if($type == "clothing" && $clothing_size != null){
                    $queryString .= " AND availableClothesSizes LIKE '%$clothing_size%'";
                }
                if($type == "shoes" && $shoe_size != null){
                    $queryString .= " AND availableShoeSizes LIKE '%$shoe_size%'";
                }
                if($price != null){
                    $queryString .= " AND price<='$price'";
                }
                if($accessoryType != null){
                    $queryString .= " AND accessoryType='$accessoryType'";
                }
                
                $query = mysqli_query($sqlConnection, $queryString);

                $total_rows = mysqli_fetch_array($query)[0];
                $total_pages = ceil($total_rows/$itemsPerPage);

                //$queryString = "SELECT id FROM items WHERE gender in ($genderId, 2) AND type='$typeId'";
                $queryString = "SELECT id FROM items WHERE gender in ($genderId, 2) AND type='$typeId'";
                if($brand != null){
                    $queryString .= " AND brand='$brand'";
                }
                if($type == "clothing" && $clothing_size != null){
                    $queryString .= " AND availableClothesSizes LIKE '%$clothing_size%'";
                }
                if($type == "shoes" && $shoe_size != null){
                    $queryString .= " AND availableShoeSizes LIKE '%$shoe_size%'";
                }
                if($price != null){
                    $queryString .= " AND price<='$price'";
                }
                if($accessoryType != null){
                    $queryString .= " AND accessoryType='$accessoryType'";
                }
                if($sortBy != null){
                    if($sortBy == "price_asc") $queryString .= " ORDER BY price ASC";
                    else if($sortBy == "price_desc") $queryString .= " ORDER BY price DESC";
                    else if($sortBy == "time_asc") $queryString .= " ORDER BY timeAdded ASC";
                    else if($sortBy == "time_desc") $queryString .= " ORDER BY timeAdded DESC";
                    else if($sortBy == "brand_asc") $queryString .= " ORDER BY brand ASC";
                    else if($sortBy == "brand_desc") $queryString .= " ORDER BY brand DESC";
                }else{
                    $queryString .= " ORDER BY timeAdded DESC";
                }
                $queryString .= " LIMIT $offset, $itemsPerPage";
                $itemQuery = mysqli_query($sqlConnection, $queryString);

                $resultCount = mysqli_num_rows($itemQuery);
                while($row = mysqli_fetch_array($itemQuery)){
                    $id = $row['id'];
                    $item = new Item($sqlConnection, $id);
                    $title = $item->getName();
                    $itemBrand = $item->getBrand();
                    $description = $item->getDescription();
                    $itemPrice = $item->getPrice();
                    $image = json_decode($item->getImagesJSON(), true)[0];
                    echo "
                    <div class='item-card col-12 col-md-4 col-lg-2 col-sm-4'>
                        <div class='card-wrapper'>
                            <a href='admin-item.php?id=$id'>
                                <div class='card-img'>
                                    <img src='../../$image' alt='$title'>
                                </div>
                            </a>
                            <div class='card-box pb-md-5'>
                                <h4 class='item-card-title mbr-fonts-style display-7'>
                                    $itemBrand
                                </h4>
                                <span class='item-card-text mbr-text mbr-fonts-style display-7'>
                                    $title
                                </span>
                                <div class='mbr-section-btn align-center' >
                                    <a href='admin-item.php?id=$id' class='btn btn-warning-outline display-4'>
                                        R $itemPrice
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
            ?>
        </div>
    </div>
</section>
<section class="items-container cid-riDn13Ln0F" style="<?php if($resultCount == 0) echo "display:none;"?>">
    <div class="container">
        <div class="row justify-content-center">
                <div class="mbr-section-btn align-center col-sm" >
                    <a href="<?php
                        $prevPage = $page - 1;
                        echo getUrlPage($type, $gender, $price, $clothing_size, $brand, $sortBy, $prevPage, $accessoryType);
                    ?>" class="btn btn-page transition-hover display-4" style="<?php if($page == 1) echo "display:none;"?>">
                        < Previous
                    </a>
                </div>
                <div class="mbr-section-btn align-center col-sm" >
                    <a href="<?php
                        $nextPage = $page + 1;
                        echo getUrlPage($type, $gender, $price, $clothing_size, $brand, $sortBy, $nextPage, $accessoryType);
                    ?>" class="btn btn-page transition-hover display-4" style="<?php if($page == $total_pages) echo "display:none;"?>">
                        Next >
                    </a>
                </div>
        </div>
    </div>
</section>
<?php include("../../includes/admin-footer.php");?>