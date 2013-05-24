<?php

require_once ('dbconfig.php');
include('insert_array_mysql.php');
$check = $_GET['action'];
$obj = new fiziserviceAPI;
switch ($check) {
  /**
   * 	@description - To Search events nearby based on current geolocation with category
   * 	@Example URL - fiziserviceAPI.php?action=SEARCH_EVENT&lat=37.785835&long=-122.406418&cat=Arts
   */
  case "SEARCH_EVENT":
    $obj->search();
    break;
  /**
   * 	@description - Get Event details
   * 	@Example URL - fiziserviceAPI.php?action=EVENT_DETAILS&id=
   * 	@response 	 - JSON response with dictionary named searched_nearby
   */
  case "EVENT_DETAILS":
    $obj->details();
    break;
  /**
   * 	@description - To List all events
   * 	@Example URL - fiziserviceAPI.php?action=LIST_EVENTS
   * 	@response 	 - JSON response with dictionary named event_details
   */
  case "LIST_EVENTS":
    $obj->listevents();
    break;

  /**
   * 	@description - To Add Events - will be used by admin
   * 	@Example URL - fiziserviceAPI.php?action=ADD_EVENT
   * 	@response 	 - JSON response with dictionary named event_list
   */
  case "ADD_EVENT":
    $obj->addevent();
    break;

  /**
   * 	@description - To get near by events to an event
   * 	@Example URL - fiziserviceAPI.php?action=GET_NEARBY&id=
   */
  case "GET_NEARBY":
    $obj->getnearby();

  /**
   * 	@description - To get list of all categories
   * 	@Example URL - fiziserviceAPI.php?action=LIST_CATEGORY
   * 	@response 	 - JSON response with dictionary named categories
   */
  case "LIST_CATEGORY":
    $obj->getcategory();
}

class fiziserviceAPI {

  public function addevent() {
    $Address = $_POST['Address'];
    $LatLong = $this->getLatLong($Address);
    $_POST['Latitude'] = $LatLong['Lat'];
    $_POST['Longitude'] = $LatLong['Long'];
    $noimg = $_POST['nimg'];
    $imgnames = $this->add_images($noimg);
    $remv = array_flip(array('nimg', 'action'));
    $output = array_diff_key($_POST, $remv);
    $result = array_merge((array) $output, (array) $imgnames);
    // print_r($result);
    $rs = mysql_insert_array("events", $result);
    if ($rs['mysql_error'] == null) {
      print_r($rs);
      echo "Inserted <br><a href='../addevent.php'>Insert More</a>";
    } else {
      echo "error : " . $rs['mysql_error'];
    }
  }

  public function add_images($nimg) {
    $imagenames;


    for ($i = 1; $i <= $nimg; $i++) {
      $img = "Image" . $i;
      $date = new DateTime();
      $datetime = $date->format('Y-m-d H:i:s');

      $filename = $_FILES[$img]["name"];
      $image_path = sprintf(
              "%s/%s_%s_%s.%s", "images", $img, $_POST['Title'], $datetime, pathinfo($filename, PATHINFO_EXTENSION)
      );
      echo $image_path;

      $chckimg = move_uploaded_file($_FILES[$img]["tmp_name"], $image_path);
      if ($chckimg) {

        // echo "Image uploaded <a href=' " .$burl.$image_path ."'>here</a>";
      } else {
        // echo "error";
      }
      $imagenames[$img] = $image_path;
      // print_r($imagenames);
    }
    // print_r($imagenames);
    return $imagenames;
  }

  public function search() {

    // $stxt=$_GET['txt'];
    $slat = $_GET['lat'];
    $slong = $_GET['long'];
    $scat = $_GET['cat'];
    // echo $scat;

    $GivenRadius = 5;
    $sql = "SELECT `EventId`,`Title`,`Summary`,`Date`,`Time`,`Category`,`Latitude`, `Longitude`,`Image1`,
			3956*2*ASIN(SQRT(POWER(SIN((" . $slat . "-abs(Latitude))*pi()/180/2),2)+COS(" . $slat . "*pi()/180)*COS(abs(Latitude)*pi()/180)*POWER(SIN((" . $slong . "-Longitude)*pi()/180/2), 2))) as distance
			FROM `events`
			WHERE `Category` LIKE '%" . $scat . "%' AND `Date` BETWEEN CURRENT_DATE AND CURRENT_DATE + INTERVAL 14 DAY
			order by distance asc";

    $result = mysql_query($sql) or die(mysql_error());
    // echo $sql;
    // print_r($result);
    $ne = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
      // echo "hiiii";
      // print_r($row);
      $ne[] = $row;
      // echo json_encode($row) ;
    }
    $nearby['searched_nearby'] = $ne;
    // print_r($nearby);

    if ($nearby['nearbyevents'] == null) {
      echo "no results";
    } else {
      echo json_encode($nearby);
    }
  }

  public function details() {
    $eveid = $_GET['id'];
    $sql = "SELECT * FROM events WHERE EventID = " . $eveid;
    $result = mysql_query($sql) or die($sql . "<br/><br/>" . mysql_error());
    $row ['event_details'] = mysql_fetch_array($result, MYSQL_ASSOC);
    // print_r($row);
    // $rs=array_filter($row);
    // print_r($rs);
    echo json_encode($row);
  }

  public function listevents() {
    $sql = "SELECT `EventID`, `Title`,`Latitude`,`Longitude`,`Summary`, `Date`,`Image1` FROM events";
    $result = mysql_query($sql);
    // print_r($result);
    $Event = array();
    $rs = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $Event[] = $row;
      // print_r($Event);
    }
    $rs['event_list'] = $Event;
    // print_r($rs);
    echo json_encode($rs);
  }

  public function getLatLong($location) {
    // $address = urlencode($location->getAddressLine1().' '.$location->getAddressLine2().' '.$location->getCity().' '.$location->getState().', '.$location->getCountry()) ;
    //33.7471045 , -117.8683609
    $address = urlencode($location);
    $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=IND";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response);
    $lat = $response_a->results[0]->geometry->location->lat;
    $long = $response_a->results[0]->geometry->location->lng;
    $latlongArray = array('Lat' => $lat, 'Long' => $long);
    return $latlongArray;
  }

  public function getnearby() {

    $eveid = $_GET['id'];

    $sql = "SELECT Latitude ,Longitude FROM events WHERE `EventId` = " . $eveid;
    $result = mysql_query($sql);

    $row = mysql_fetch_array($result);
    $Latitude = $row['Latitude'];
    $Longitude = $row['Longitude'];
    $GivenRadius = 2;
    $query = "select  3956*2*ASIN(SQRT(POWER(SIN((" . $Latitude . "-abs(Latitude))*pi()/180/2),2)+COS(" . $Latitude . "*pi()/180)*COS(abs(Latitude)*pi()/180)*POWER(SIN((" . $Longitude . "-Longitude)*pi()/180/2), 2))) as distance
			from events having distance <" . $GivenRadius . "order by distance asc";
    $rs = mysql_query($query) or die(mysql_error());
    while ($rslt = mysql_fetch_array($rs, MYSQL_ASSOC)) {
      # code...
      print_r($rslt);
      // echo json_encode($rslt);
    }
  }

  function getcategory() {
    $query = "SELECT distinct(category) from events ";
    $rs = mysql_query($query);
    $arr = array();
    while ($array = mysql_fetch_array($rs, MYSQL_ASSOC)) {
      $arr[] = $array['category'];
    }

    $category = array();
    $category['categories'] = $arr;
    // print_r($category);
    print_r(json_encode($category));
  }

}
