<?php
Class APIs{
  protected $owapi = "6eac12ac20bc3d76c0391020b10ca535";
}
Class Currentweather Extends APIs{
  private $jsonfile;
  private $jsondata;
  private $temp;
  private $humidity;
  private $pressure;
  private $visibility;
  private $description;
  private $windspeed;
  private $winddir;
  private $iconcode;
  private $coordlon;
  private $coordlat;
  private $cityname;
  private $countrycode;
  private $sunrise;
  private $sunset;
  private $cloudsall;
  
  private function jsondata($url) {
    $this->jsonfile = file_get_contents($url);
    $this->jsondata = json_decode($this->jsonfile);
    return $this->jsondata;
  }
  
  
  //location for current weather
  public function locationbycity($lat, $lon) {
    //$currenturl = "http://api.openweathermap.org/data/2.5/weather?q=". str_replace(' ', '%20', $city) .",". str_replace(' ', '%20', $country) ."&units=metric&appid=". $this->owapi ."";
    $currenturl = "http://api.openweathermap.org/data/2.5/weather?lat=". str_replace(' ', '%20', $lat) ."&lon=". str_replace(' ', '%20', $lon) ."&units=metric&appid=". $this->owapi ."&cnt=1";
      return $currenturl;
  }
  // Get full
  public function getFullJson($url) {
    $this->temp = $this->jsondata($url);
    return $this->temp;
  }
  
  // Get current temperature
  public function temperature($url) {
    $this->temp = $this->jsondata($url)->main->temp;
    return $this->temp;
  }
  // Get current humidity
  public function humidity($url) {
    $this->humidity = $this->jsondata($url)->main->humidity;
    return $this->humidity;
  }
  // Get current pressure
  public function pressure($url) {
    $this->pressure = $this->jsondata($url)->main->pressure;
    return $this->pressure;
  }
  // Get current visibility
  public function visibility($url) {
    $this->visibility = $this->jsondata($url)->visibility;
    return $this->visibility;
  }
  //Get current weather description
  public function description($url) {
    $this->description = $this->jsondata($url)->weather[0]->description;
    return $this->description;
  }
  // Get wind speed
  public function windspeed($url) {
    $this->windspeed = $this->jsondata($url)->wind->speed;
    return $this->windspeed;
  }
  //Get wind direction
  public function winddir($url) {
    $this->winddir = $this->jsondata($url)->wind->deg;
    return $this->winddir;
  }
  //Get icon code
  public function iconcode($url) {
    $this->iconcode = $this->jsondata($url)->weather[0]->icon;
    return $this->iconcode;
  }
  // Get country name
  public function cityname($url) {
    $this->cityname = $this->jsondata($url)->name;
    return $this->cityname;
  }
  //Get city name
  public function countrycode($url) {
    $this->countrycode = $this->jsondata($url)->sys->country;
    return $this->countrycode;
  }
  //Get sunrise time
  public function sunrise($url) {
    $this->sunrise = $this->jsondata($url)->sys->sunrise;
    return $this->sunrise;
  }
  //Get sunset
  public function sunset($url) {
    $this->sunset = $this->jsondata($url)->sys->sunset;
    return $this->sunset;
  }
  //Get cloudsall
  public function cloudsall($url) {
    $this->cloudsall = $this->jsondata($url)->clouds->all;
    return $this->cloudsall;
  }
}

/*
$temperature = $weatherdata->temperature($weatherdata->locationbycity('Kolkata', 'In'));
$temperature = $weatherdata->temperature($weatherdata->locationbycity($getlatitude, $getlongitude));
$windspeed_ms = $weatherdata->windspeed($weatherdata->locationbycity($getlatitude, $getlongitude));
$humidity = $weatherdata->humidity($weatherdata->locationbycity($getlatitude, $getlongitude));
$pressure = $weatherdata->pressure($weatherdata->locationbycity($getlatitude, $getlongitude));
$cloudsall = $weatherdata->cloudsall($weatherdata->locationbycity($getlatitude, $getlongitude));
$cityname = $weatherdata->cityname($weatherdata->locationbycity($getlatitude, $getlongitude));
$winddir = $weatherdata->winddir($weatherdata->locationbycity($getlatitude, $getlongitude));
$countrycode = $weatherdata->countrycode($weatherdata->locationbycity($getlatitude, $getlongitude));
$description = $weatherdata->description($weatherdata->locationbycity($getlatitude, $getlongitude));
$visibility = $weatherdata->visibility($weatherdata->locationbycity($getlatitude, $getlongitude));
$sunrise = $weatherdata->sunrise($weatherdata->locationbycity($getlatitude, $getlongitude));
$sunset = $weatherdata->sunset($weatherdata->locationbycity($getlatitude, $getlongitude));*/
?>