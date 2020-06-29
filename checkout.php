<?php include("includes/header.php");?>
<?php include("includes/classes/Item.php");?>

<?php
    if(!isset($_SESSION['userLoggedIn'])){
        header("Location: login.php");
    }
    $user = new User($sqlConnection, $_SESSION['userLoggedIn']);
    $userId = $user->getId();
    $cartItemsJSON = json_decode($cartUser->getCartIdsJSON(), true);
    $cartItems = array();
    foreach($cartItemsJSON as $itemId){
        $item = new Item($sqlConnection, $itemId['id']);
        array_push($cartItems, $item);
    }
    $total = 0;
    foreach($cartItems as $item){
        $total += $item->getPrice();
    }
?>

  <head>
    <title>Checkout</title>
  </head>
  <div class="container">
  <h2 class="align-center pb-3 mbr-fonts-style display-2" style="padding: 32px 0;">Delivery Address:</h2>

  <section class="items-container cid-riDn13Ln0F" id="services1-x">
    <div class="container" style="padding: 0;">
    <section class="mbr-section form3" style="background-color: #fff;">
        <div class="container" style="padding: 32px;">
          <div class="row justify-content-center">
            <div class="input-holder">
                <p><label for="recipient-name-input">Recipient Name*</label><input class="form-control search-input" type="text" id="recipient-name-input" name="recipient-name-input" placeholder="Recipient Name*"></p>
                <p><label for="recipient-number-input">Recipient Phone Number*</label><input class="form-control search-input" type="text" id="recipient-number-input" name="recipient-number-input" placeholder="Recipient Phone Number*"></p>
                <p><label for="complex-number-input">Complex Number (Optional)</label><input class="form-control search-input" type="text" id="complex-number-input" name="complex-number-input" placeholder="Complex Number (Optional)"></p>
                <p><label for="complex-name-input">Complex/Building Name (Optional)</label><input class="form-control search-input" type="text" id="complex-name-input" name="complex-name-input" placeholder="Complex Name (Optional)"></p>
                <p><label for="street-number-input">Street Number*</label><input class="form-control search-input" type="text" id="street-number-input" name="street-number-input" placeholder="Street Number*"></p>
                <p><label for="street-name-input">Street Name*</label><input class="form-control search-input" type="text" id="street-name-input" name="street-name-input" placeholder="Street Name*"></p>
                <p><label for="suburb-input">Suburb*</label><input class="form-control search-input" type="text" id="suburb-input" name="suburb-input" placeholder="Suburb*"></p>
                <p><label for="city-input">City/Town*</label><input class="form-control search-input" type="text" id="city-input" name="city-input" placeholder="City/Town*"></p>
                <p><label for="post-code-input">Post Code*</label><input class="form-control search-input" type="text" id="post-code-input" name="post-code-input" placeholder="Post Code*"></p>
                <p><label for="state-input">Province/State*</label><input class="form-control search-input" type="text" id="state-input" name="state-input" placeholder="State/Province*"></p>
                <p><label for="country-input">Country*</label><input class="form-control search-input" type="text" id="country-input" name="country-input" placeholder="Country*"></p>
            </div>
          </div>
            <div class="row justify-content-center">
              <button class="btn btn-sm btn-black display-4" name="search-button" onclick="checkAddress()">
                  <span class="mbrib-home mbr-iconfont mbr-iconfont-btn"></span>View Delivery Price <img id="checkout-loader" src="assets/images/785.gif" style="visibility: collapse; width: 28px; margin-left: 8px;" alt=""></button>
            </div>
          </div>
      </section>
      <div class="checkout-map-view" id="hidden-view" style="display: none;">
      <section style="background: none; padding-bottom: 32px;">
        <div class="container align-content-center">
                <!--<button onclick="setSatchelSelected()" class="card-checkout-holder">
                    <div class="checkout-card-activated transition-hover satchel-button">
                        <img src="assets/images/icons8-backpack-100.png" alt="Personal Details" class="checkout-card-image img-responsive transition-hover-img">
                        <h4 class="card-title display-4">Satchel Delivery Cost - <span id="satchel-price">R91</span></h4>
                    </div>
                </button>-->
                <button class="card-checkout-holder">
                    <div class="checkout-card-activated transition-hover parcel-button">
                        <img src="assets/images/icons8-cardboard-box-100.png" alt="Wish List" class="checkout-card-image img-responsive transition-hover-img">
                        <h4 class="card-title display-4">Parcel Delivery Cost - <span id="parcel-price">R0</span></h4>
                    </div>
                </button>
          </div>
      </section>
      <div class="row justify-content-center">
        <div style="width: 100%; padding: 0 32px">
                <div class="google-map">
                  <iframe id="checkout-map" frameborder="0" style="border:0" allowfullscreen="false">
                  </iframe>
                </div>
          </div>
      </div>
      <div class="container" style="padding: 16px 0">
        <div class="media-container-row">
            <div class="title">
            <h2 class="align-center pb-3 mbr-fonts-style display-2">
                    Items:
            </h2>
            </div>
        </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <?php
                    foreach($cartItems as $item){
                        $id = $item->getId();
                        $brand = $item->getBrand();
                        $price = $item->getPrice();
                        $name = $item->getName();
                        $images = json_decode($item->getImagesJSON(), true);
                        $imageUrl = $images[0];
                        $size = '';
                        foreach($cartItemsJSON as $jItem){
                            if($jItem['id'] == $id){
                                $size = $jItem['size'];
                            }
                        }

                        echo "<div class='item-card col-12 col-md-4 col-lg-2 col-sm-4'>
                        <div class='card-wrapper'>
                                <div class='card-img'>
                                    <img src='$imageUrl' alt='$name'>
                                </div>
                            <div class='card-box pb-md-5'>
                                <h4 class='item-card-title mbr-fonts-style display-7'>
                                    $brand
                                </h4>
                                <span class='item-card-text mbr-text mbr-fonts-style display-7'>
                                    $name
                                </span>
                                <div class='mbr-section-btn align-center' >
                                    <button class='btn btn-item-unclickable display-4' style='cursor: default; background-color: #55666b !important; border-color: #55666b !important;'>
                                        <span style='color: #fff'>R$price<span>
                                    </button>
                                </div>
                                <div class='mbr-section-btn align-center' >
                                    <button class='btn btn-item-unclickable display-4' style='cursor: default; background-color: #55666b !important; border-color: #55666b !important;'>
                                        <span style='color: #fff'>Size: $size<span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>";
                    }
                ?>
            </div>
        </div>
        <div class="row sizes justify-content-center" >
          <h4 class="card-title mbr-fonts-style display-6">
              Payment Method:
          </h4>
          <div class="size-btn-holder">
            <button onclick="selectPaymentMethod('cc')" class='btn btn-size btn-size-selected transition-hover display-4 btn-method-cc' value="cc" id='method-selected'>Credit Card</button>
            <button onclick="selectPaymentMethod('dc')" class='btn btn-size btn-size-unselected transition-hover display-4 btn-method-dc' value="dc">Debit Card</button>
          </div>
        </div>
      <div class="row justify-content-center checkout-prices" style="padding: 32px 0;">
        <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-5" id="order-cost">
                      Order Cost: R<?php echo $total; ?>
        </h3>
        <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-5" id="delivery-cost">
                      Delivery Cost: R0
        </h3>
        <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-5" style="font-weight: 500;" id="total-cost">
                      Total Cost: R0
        </h3>
      </div>
      <div class="row justify-content-center" style="padding: 16px;">
          <form action="https://sandbox.payfast.co.za/eng/process" method="POST">
              <input type="hidden" name="merchant_id" value="10012248">
              <input type="hidden" name="merchant_key" value="z5pnwd65ktzar">
              <input type="hidden" name="return_url" value="https://127.0.0.1/ClothingStore/order-successful.php">
              <input type="hidden" name="cancel_url" value="https://127.0.0.1/ClothingStore/cart.php">
              <input type="hidden" name="notify_url" value="https://127.0.0.1/ClothingStore/payfast.php">
              <input type="hidden" name="name_first" value="<?php echo $user->getFirstName();?>">
              <input type="hidden" name="name_last" value="<?php echo $user->getLastName();?>">
              <input type="hidden" name="email_address" value="sbtu01@payfast.co.za">
              <input type="hidden" name="cell_number" value="<?php echo $user->getPhoneNumber();?>">
              <input type="hidden" name="amount" id="amount-payfast" value="0">
              <input type="hidden" name="item_name" value="Pope.inc Order">
              <input type="hidden" name="email_confirmation" value="1">
              <input type="hidden" name="confirmation_address" value="mothusom68@gmail.com">
              <input type="hidden" name="payment_method" id="payfast-payment-method" value="cc">
              <button class="btn btn-sm btn-checkout display-4" type="submit" name="search-button">
                  Proceed to Payment ></button>
          </form>
              
      </div>
      </div>
    </div>
    </section>
    </div>
    <script>
      function selectPaymentMethod(method){
        var btnClass = ".btn-method-"+method;
        $(".btn-size").removeClass("btn-size-selected");
        $(".btn-size").attr("id" , "");
        $(".btn-size").addClass("btn-size-unselected");

        $(btnClass).removeClass("btn-size-unselected");
        $(btnClass).addClass("btn-size-selected");
        $(btnClass).attr("id" , "method-selected");

        $('#payfast-payment-method').val(method);
      }
      var address = null;
      var parcelPrice = null;
      /*var deliveryOption = 0;
      function setSatchelSelected(){
        deliveryOption = 0;
        $(".satchel-button").removeClass("checkout-card");
        $(".parcel-button").removeClass("checkout-card-activated");

        $(".satchel-button").addClass("checkout-card-activated");
        $(".parcel-button").addClass("checkout-card");
      }
      function setParcelSelected(){
        deliveryOption = 1;
        $(".satchel-button").removeClass("checkout-card-activated");
        $(".parcel-button").removeClass("checkout-card");

        $(".satchel-button").addClass("checkout-card");
        $(".parcel-button").addClass("checkout-card-activated");
      }*/
      function toTitleCase(str){
        return str.replace(/\b\w/g, function(txt){
          return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });
      }
      function proceedToPayment(){
        if(address != null && parcelPrice != null){
          $.post("includes/ajax/StoreCheckoutVariables.php", {address: address, parcelPrice: parcelPrice, totalCost: totalCost}, function(result){
            if(result == 'true'){
              alert(parcelPrice+" - "+address);
              $("#payfast-submit").click();
            }
          });
        }else{
          showModal("Something went wrong", "Please check your connection and ensure that you have entered the correct Address and Suburb.");
        }
      }

      function checkAddress(){
        var complexNumber = toTitleCase($("#complex-number-input").val().trim().toLowerCase());
        var complexName = toTitleCase($("#complex-name-input").val().trim().toLowerCase());

        var recipientName = toTitleCase($("#recipient-name-input").val().trim().toLowerCase());
        var recipientNumber = toTitleCase($("#recipient-number-input").val().trim().toLowerCase());

        var streetNumber = toTitleCase($("#street-number-input").val().trim().toLowerCase());
        var streetName = toTitleCase($("#street-name-input").val().trim().toLowerCase());
        var suburb = toTitleCase($("#suburb-input").val().trim().toLowerCase());
        var city = toTitleCase($("#city-input").val().trim().toLowerCase());
        var postCode = toTitleCase($("#post-code-input").val().trim().toLowerCase());
        var state = toTitleCase($("#state-input").val().trim().toLowerCase());
        var country = toTitleCase($("#country-input").val().trim().toLowerCase());
            $("#checkout-loader").css("visibility", "visible");
        
        if(streetNumber != "" &&
          streetName != "" &&
          suburb != "" &&
          city != "" &&
          postCode != "" &&
          state != "" &&
          country != "" &&
          recipientName != "" &&
          recipientNumber != ""){
            if(country.toLowerCase() != "south africa"){
              showModal("Unavailable Country", "Currently we only deliver to South African addresses. Thank you for your time.");
              return;
            }
            var totalCost = null;
            $(".checkout-map-view").css("display", "none");
            $("#checkout-loader").css("visibility", "visible");
            $.post("includes/ajax/check-address-json.php", {streetNumber: streetNumber, 
                                                            streetName: streetName,
                                                            suburb: suburb,
                                                            city: city,
                                                            postCode: postCode,
                                                            state: state,
                                                            country: country}, function(result){
              if(result != null){
                var resultJSON = null;
                try{
                  resultJSON = JSON.parse(result);
                  if(resultJSON.result === undefined){
                    resultJSON = null;
                  }
                }catch(err){
                  resultJSON = null;
                }
                if(resultJSON != null){
                  /*resultJSON.result.services.forEach(function(item, index){
                    if(item.type.toLowerCase() == "satchel"){
                      $("#satchel-price").html("R"+item.totalprice_normal)
                      return;
                    }
                  });*/
                  resultJSON.result.services.forEach(function(item, index){
                    if(item.type.toLowerCase() == "parcel"){
                      parcelPrice = Math.round(item.totalprice_normal) + 2;
                      $("#parcel-price").html("R"+parcelPrice);
                      $("#delivery-cost").html("Delivery Cost: R"+parcelPrice);
                      var cost = <?php echo $total; ?>;
                       totalCost = cost + parcelPrice;
                      $("#amount-payfast").val(totalCost);
                      $("#total-cost").html("Total Cost: R"+totalCost);
                      return;
                    }
                  });
                  //alert(resultJSON.result.services[0].type);

                  $("#checkout-loader").css("visibility", "collapse");
                  $(".checkout-map-view").css("display", "block");
                  $("html, body").animate({
                    scrollTop: ($("#hidden-view").offset().top)
                  }, 500);
                  if(complexNumber != "" && complexName != ""){
                    address = complexNumber+" "+complexName+","+streetNumber+" "+streetName+","+suburb+","+city+","+postCode+","+state+","+country;
                    $("#checkout-map").attr("src", "https://www.google.com/maps/embed/v1/place?key=AIzaSyAEIpgj38KyLFELm2bK9Y7krBkz1K-cMq8&q="+complexNumber+" "+complexName+","+streetNumber+" "+streetName+","+suburb+","+city+","+postCode+","+state+","+country);
                  }else{
                    address = streetNumber+" "+streetName+","+suburb+","+city+","+postCode+","+state+","+country;
                    $("#checkout-map").attr("src", "https://www.google.com/maps/embed/v1/place?key=AIzaSyAEIpgj38KyLFELm2bK9Y7krBkz1K-cMq8&q="+streetNumber+" "+streetName+","+suburb+","+city+","+postCode+","+state+","+country);
                  }
                  $.post("includes/ajax/StoreCheckoutVariables.php", {address: address, parcelPrice: parcelPrice, totalCost: totalCost, recipientName: recipientName, recipientNumber: recipientNumber}, function(result){
                    if(result == 'true'){}
                  });
                }else{
                  $("#checkout-loader").css("visibility", "collapse");
                  showModal("Something went wrong", "Please check your connection and ensure that you have entered the correct Address and Suburb.");
                }
              }else{
                $("#checkout-loader").css("visibility", "collapse");
                showModal("Something went wrong", "Please check your connection and ensure that you have entered the correct address.");
              }
            });
        }else{
          showModal("Incomplete Form", "Please ensure that you have filled inall required (*) fields.");
        }
      }
    </script>
<?php include("includes/footer.php");?>