<?php 
//Required data
require_once('dane.php');
$tableName = 'post_codes';

//form
echo'
    <div>
    <a href="prizes.php">Check Prizes</a>
        <form action="" id="calculate_form" method="post">
            <label>Postcode 5-digit</label><br>
            <input type="text" name="postcode" pattern="[0-9]{5}" required><br>
            <label>Order Amount</label><br>
            <input type="text" name="order_amount" pattern="[0-9]*"><br>
            <label><input type="checkbox" name="long_product" value="long_product">Long Product</label><br>
            <button name="submit">Submit</button>
        </form>
    </div>
';

//function to calculate
function count_shipment($zone_data, $order_amount, $long_product){
    if ($long_product){
        $shipment_price = round(($zone_data*$order_amount + 1995), 2);
    } else {
        $shipment_price = round(($zone_data*$order_amount), 2);
    }

    if($shipment_price > 12500){
        $output = '
            <p> Your shipping price is '.$shipment_price.'€, but just for you we will send it for '.$shipment_price*0.95.'€</p>
        ';
    } else {
        $output = '
            <p> Your shipping price is '.$shipment_price.'€</p>
        ';
    }
    return $output; 
}   

//checking and distributting form entry
if(isset($_POST['submit'])){
    $long_product = (isset($_POST['long_product'])) ? true : false;
    $zone_code = substr($_POST['postcode'], 0, 2);

    if ($zone_code > 86){
        echo'<p style:"color:red;">please check your Postcode there is no zone '.$zone_code.'</p>';
    } else {
        $zone_data = fetch_data($tableName, $zone_code);
        if($zone_data){
            if($zone_data != ""){
                $zone_price = str_replace(',','.',$zone_data[0]['price']);
                $zone_price = floatval($zone_price);
                echo count_shipment($zone_price, $_POST['order_amount'], $long_product);
            }
        } else {
            echo '<p>Prices havent beean asinged to regions yet</p>';
        }
    }
}


