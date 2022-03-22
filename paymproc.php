<?php
$input = file_get_contents('php://input');
$updated = json_decode($input, true);
file_put_contents("result.json", $input . PHP_EOL . PHP_EOL, FILE_APPEND);

function setAmount($amount, $chat_id, $user_id, $message_id)
{
  $userIdDb = getUserID($user_id);
  $userRow = getUserInput($userIdDb);
  $cartId = getCartID($userIdDb);
  $selectedItem = $userRow['userProductid'];
  $ID = intval($selectedItem);
  $selection = GetSelection($ID);
  $selected_price = $selection['price'];
  $quanitiy = intval($amount);

  $res = setqunti($userIdDb, $quanitiy, $selected_price, $cartId, $selectedItem, $chat_id, $message_id);
}

function setBack($amount, $chat_id, $user_id, $message_id)
{
  $userIdDb = getUserID($user_id);
  $userRow = getUserInput($userIdDb);
  $cartId = getCartID($userIdDb);
  $selectedItem = $userRow['userProductid'];
  $ID = intval($selectedItem);
  $selection = GetSelection($ID);
  $selected_price = $selection['price'];
  $quanitiy = intval($amount);

  $res = setbackqunti($userIdDb, $quanitiy, $selected_price, $selectedItem, $chat_id);
}

function nextNotify($chat_id)
{

  $markup  = array('keyboard' => array(array('Next')), 'resize_keyboard' => true, 'selective' => true, 'one_time_keyboard' => true);
  $markupjs = json_encode($markup);
  $ret = message($chat_id, "Press Next to confirm", $markupjs);
}

function setQuantity($num)
{
  $userupdate = $GLOBALS['updated'];
  $message_id = $userupdate['message']['message_id'];
  $chat_id = $userupdate['message']['chat']['id'];
  $user_id = $userupdate['message']['from']['id'];
  $text = $userupdate['message']['text'];



  $markup  = array('inline_keyboard' => array(array(array('text' => $num,  'callback_data' => '0')), array(array('text' => '1',  'callback_data' => '1'), array('text' => '2',  'callback_data' => '2'), array('text' => '3',  'callback_data' => '3')), array(array('text' => '4',  'callback_data' => '4'), array('text' => '5',  'callback_data' => '5'), array('text' => '6',  'callback_data' => '6')), array(array('text' => '7',  'callback_data' => '7'), array('text' => '8',  'callback_data' => '8'), array('text' => '9',  'callback_data' => '9')), array(array('text' => 'Clear',  'callback_data' => 'Clear'), array('text' => '0',  'callback_data' => '0'), array('text' => 'Submit',  'callback_data' => 'submit')), array(array('text' => 'Cancel order',  'callback_data' => 'Cancel'))));

  $markupjs = json_encode($markup);

  $ret = message($chat_id, "Enter Quantity", $markupjs);
  return $userupdate['message']['message_id'];
}

function sharePhone($chat_id)
{

  $markup  = array('keyboard' => array(array(array('text' => 'Phone Number', 'request_contact' => true)), array(array('text' => 'Back'), array('text' => 'Cancel'))), 'resize_keyboard' => true, 'one_time_keyboard' => true, 'selective' => true);
  $markupjs = json_encode($markup);
  $ret = message($chat_id, "Please share your Phone Number", $markupjs);
  return;
}

function shareLocation()
{
  $userupdate = $GLOBALS['updated'];
  $chat_id = $userupdate['message']['chat']['id'];
  $user_id = $userupdate['message']['from']['id'];
  $text = $userupdate['message']['text'];
  $markup  = array('keyboard' => array(array(array('text' => 'Current Location', 'request_location' => true)), array(array('text' => 'Back'), array('text' => 'Cancel'))), 'resize_keyboard' => true, 'one_time_keyboard' => true, 'selective' => true);
  $markupjs = json_encode($markup);
  $ret = message($chat_id, "Share your location", $markupjs);
  return;
}

function orderType()
{
  $userupdate = $GLOBALS['updated'];
  $chat_id = $userupdate['message']['chat']['id'];
  $user_id = $userupdate['message']['from']['id'];
  $text = $userupdate['message']['text'];
  $markup  = array('keyboard' => array(array(array('text' => 'Pickup Order')), array(array('text' => 'Delivery Order')), array(array('text' => 'Back'), array('text' => 'Cancel Order'))), 'resize_keyboard' => true, 'one_time_keyboard' => true, 'selective' => true);
  $markupjs = json_encode($markup);
  $ret = message($chat_id, "Select order type", $markupjs);
  return;
}

function AddCart($chat_id, $user_id)
{


  $markup  = array('inline_keyboard' => array(array(array('text' => 'Add more products',  'callback_data' => 'Yes')), array(array('text' => 'Continue to order', 'callback_data' => 'Next')), array(array('text' => 'Cancel previous order', 'callback_data' => 'Cancel'))));
  $markupjs = json_encode($markup);
  $ret = message($chat_id, "Do you want to add more to your cart?", $markupjs);
  return;
}

function ChooseProvider($data)
{
  $userupdate = $GLOBALS['updated'];
  $chat_id = $data['message']['chat']['id'];
  $user_id = $data['message']['from']['id'];
  $message_id = $data['message']['message_id'];
  $message_idnum = intval($message_id) + 1;

  $UserId = getUserID($user_id);
  $urlStr = base64_encode(urlencode($UserId));

  $parampaypal = 'https://versavvymedia.com/tomocaBot/orderingPage/index.php?UserId=' . $urlStr;

  $markup  = array('inline_keyboard' => array(array(array('text' => 'Telebirr',  'url' => $parampaypal)), array(array('text' => 'Abyssinia', 'url' => $parampaypal)), array(array('text' => 'Paypal',  'url' => $parampaypal)), array(array('text' => 'Cancel Order', 'callback_data' => 'Cancel Order'))));
  $markupjs = json_encode($markup);
  $markup2  = array('keyboard' => array(array('Cancel Order')), 'resize_keyboard' => true, 'selective' => true);
  $markupj2s = json_encode($markup);
  $ret = message($chat_id, "Choose payment provider to continue ", $markupjs);
  $userIdDb = getUserID($user_id);
  setLastMsg($userIdDb, $message_idnum);
  return;
}

function ChooseProviderPK($data)
{
  $userupdate = $GLOBALS['updated'];
  $chat_id = $data['message']['chat']['id'];
  $user_id = $data['message']['from']['id'];
  $UserId = getUserID($user_id);

  $urlStr = base64_encode(urlencode($UserId));

  $parampaypal = 'https://versavvymedia.com/tomocaBot/orderingPage/index.php?UserId=' . $urlStr;

  $markup  = array('inline_keyboard' => array(array(array('text' => 'Telebirr',  'url' => $parampaypal)), array(array('text' => 'Abyssinia', 'url' => $parampaypal)), array(array('text' => 'Paypal',  'url' => $parampaypal)), array(array('text' => 'Cancel Order', 'callback_data' => 'Cancel Order'))));
  $markupjs = json_encode($markup);
  $ret = message($chat_id, "Choose payment provider to continue ", $markupjs);
  return;
}





function showdetail($UIDS, $chat_id, $user_id, $message_id)
{
  global $db;
  $detail = getUserInput($UIDS);
  $ChartStart = intval($detail['CartStart']);
  $ChartEnd = intval($detail['CartEnd']);
  $arryDetail = array();
  $i = 1;

  if ($ChartStart > $ChartEnd) {
    $ret = message($chat_id, "The Cart is empty", null);
    setStep($user_id, "");
    $UID = getUserID($user_id);
    ClearQuan($UID);
  } else {
    for ($x = $ChartStart; $x <= $ChartEnd; $x++) {
      $query = "SELECT * From cart WHERE cartId=$x";;
      $res = mysqli_query($db, $query);
      $res = mysqli_fetch_assoc($res);
      $selectedItem = GetSelection($res['ProductId']);

      $Ch_title = $selectedItem['Title'];
      $Ch_quan = $res['Quantity'];
      $Ch_prc = $selectedItem['price'];
      $Ch_amn = $res['Amount'];
      $Ch_Update = $res['Updated'];

      if ($Ch_Update == "Updated") {
        $detailText = urlencode("❕ Updated product\n\nProduct Number:" . $i  . "\n\nProduct: " . $Ch_title . "\n\n" . "Quantity: " . $Ch_quan . "\n\n" . "Price/Package:" . $Ch_prc . "birr" . "\n\n"  . "Total Amount:" . $Ch_amn . "birr" . "\n\n");
      } else {
        $detailText = urlencode("\n\nProduct Number:" . $i  . "\n\nProduct: " . $Ch_title . "\n\n" . "Quantity: " . $Ch_quan . "\n\n" . "Price/Package:" . $Ch_prc . "birr" . "\n\n"  . "Total Amount:" . $Ch_amn . "birr" . "\n\n");
      }


      $markup  = array('keyboard' => array(array('Next'), array('Go Back', 'Cancel')), 'resize_keyboard' => true, 'selective' => true, 'one_time_keyboard' => true);
      $markupjs = json_encode($markup);
      $ret = message($chat_id, $detailText, $markupjs);
      $i++;
    }
  }
}

function showTotalDetail($UIDS, $chat_id, $user_id)
{
  global $db;
  $detail = getUserInput($UIDS);
  $ChartStart = intval($detail['CartStart']);
  $ChartEnd = intval($detail['CartEnd']);
  $totalSum = 0;
  if ($ChartStart > $ChartEnd) {
    $ret = message($chat_id, "The Cart is empty", null);
    setStep($UIDS, "");
    $UID = getUserID($user_id);
    ClearQuan($UID);
  } else {
    for ($x = $ChartStart; $x <= $ChartEnd; $x++) {
      $query = "SELECT * From cart WHERE cartId=$x";;
      $res = mysqli_query($db, $query);
      $res = mysqli_fetch_assoc($res);
      $Ch_quan = intval($res['Quantity']);
      $totalSum = $totalSum + $Ch_quan;
    }
  }

  $detailText = urlencode("Order Summary\n\nNumber of product type:" . $detail['NumProducts']  . "\n\nTotal number of bag: " . $totalSum . "\n\n" . "Discount: 15% \n\n" . "Total Cost:" . $detail['TotalAmount'] . "birr" . "\n\n");
  // $markup  = array('keyboard' => array(array('Next'), array('Go Back', 'Cancel')), 'resize_keyboard' => true, 'selective' => true, 'one_time_keyboard' => true);
  // $markupjs = json_encode($markup);
  $ret = message($chat_id, $detailText, null);
}




function DetailText($chat_id)
{
  $markup  = array('keyboard' => array(array('Next'), array('Go Back', 'Cancel')), 'resize_keyboard' => true, 'selective' => true, 'one_time_keyboard' => true);
  $markupjs = json_encode($markup);
  $ret = message($chat_id, "🛒 Cart Detail", $markupjs);
}
function SaveandShowSelection($selection, $update)
{
  $product_title = $selection['Title'];
  $product_image = $selection['photo'];
  $product_price = $selection['price'];
  $product_Desc = $selection['Description'];
  $product_Id = $selection['productId'];
}

function CancelNotifyer($data)
{
  $markup  = array('inline_keyboard' => array(array(array('text' => 'Back to Channel',  'url' => 'https://t.me/TomTomChan'))));
  $markupjs = json_encode($markup);
  $chat_id = $data['callback_query']['message']['chat']['id'];
  message($chat_id, "Order canceled!  Select Item again", $markupjs);
}

function CancelNotifyerUser($chat_id)
{
  $markup  = array('inline_keyboard' => array(array(array('text' => 'Back to Channel',  'url' => 'https://t.me/TomTomChan'))));
  $markupjs = json_encode($markup);

  message($chat_id, "Order canceled!  Select Item again", $markupjs);
}

function AddNotifyerUser($chat_id)
{
  $markup  = array('inline_keyboard' => array(array(array('text' => 'Back to Channel',  'url' => 'https://t.me/TomTomChan'))));
  $markupjs = json_encode($markup);

  message($chat_id, "To add more product to your 🛒 go back to the channel", $markupjs);
}

function CancelNotifyerWeb($UserID)
{
  $markup  = array('inline_keyboard' => array(array(array('text' => 'Back to Channel',  'url' => 'https://t.me/TomTomChan'))));
  $markupjs = json_encode($markup);
  // $chat_id = $data['message']['chat']['id'];
  message($UserID, "Order canceled!  Select Item again", $markupjs);
}


function BackNotif($data)
{
  $chat_id = $data['message']['chat']['id'];
  message($chat_id, "Going back!");
}

function BackNotifUser($chat_id)
{

  message($chat_id, "Going back!");
}

function CancelKey($data)
{
  $chat_id = $data['message']['chat']['id'];
  $markup  = array('keyboard' => array(array('Cancel Order')), 'resize_keyboard' => true, 'selective' => true);
  $markupjs = json_encode($markup);
  message($chat_id, null, $markupjs);
}

function DeletRequest($userIdDb)
{
  DeletRow($userIdDb);
}

function GetBestDistance($user_id, $longtiude, $latitude){

  $shopLat =  array (
    array("Volvo",22,18),
    array("BMW",15,13),
    array("Saab",5,2),
    array("Land Rover",17,15)
  );

  $latitudeTo=floatval($latitude);
  $longitudeTo=floatval($longtiude);

  $distanceTable = array();
  $distanceTable[0] = twopoints_on_earth(9.03112, 38.75077,$latitudeTo, $longitudeTo);
  $distanceTable[1] = twopoints_on_earth(9.04537, 38.74997,$latitudeTo, $longitudeTo);
  $distanceTable[2] = twopoints_on_earth(8.99632, 38.73574,$latitudeTo, $longitudeTo);
  $distanceTable[3] = twopoints_on_earth(8.99368, 38.77676,$latitudeTo, $longitudeTo);
  $distanceTable[4] = twopoints_on_earth(8.9959, 38.79035,$latitudeTo, $longitudeTo);
  $distanceTable[5] = twopoints_on_earth(9.00174, 38.78339,$latitudeTo, $longitudeTo);
  $distanceTable[6] = twopoints_on_earth(9.00756, 38.78393,$latitudeTo, $longitudeTo);
  $distanceTable[7] = twopoints_on_earth(8.98966, 38.76544,$latitudeTo, $longitudeTo);
  $distanceTable[8] = twopoints_on_earth(9.01979, 38.76826,$latitudeTo, $longitudeTo);
  $distanceTable[9] = twopoints_on_earth(9.00524, 38.76733,$latitudeTo, $longitudeTo);



  $maxIndex = array_search(max($distanceTable), $distanceTable);
  $TomocaNum= $maxIndex+1;

}