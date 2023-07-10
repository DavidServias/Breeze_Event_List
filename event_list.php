<?php 
  // test data setup
  $development_mode = true;

  if ($development_mode == true) {
    require_once("event_list_test_data.php");
    $available_locations_array = json_decode($available_locations_json, true);
    $events_data = json_decode($events, true);
  } 
  else
  {
      $query_string = 'https://uufc.breezechms.com/api/events?';
      $api_key = "ef9b50b0ced375e5bc54e3338d6fe810";
      require_once('breeze.php');

      // create an stub class called Breeze
      // Comment this out for production. It's just hear to make the errors go away in development mode.
      Class Breeze {
        private $api_key;
        public function url($url) {
          return "This is a stub function. It's just here to make the errors go away.";
        }
        public function __construct($api_key) {
          $this->api_key = $api_key;
        }
      };

      // Get start and end dates for events
      $today = date("Y-m-d");
      $start_date_obj = date_create($today);
      $start_date_string = date_format($start_date_obj, "Y-m-d");
      $end_date_obj = date_add($start_date_obj, date_interval_create_from_date_string("10 days"));
      $end_date_string = date_format($end_date_obj, "Y-m-d");

      // construct request url from start and end dates
      $request_url = "https://uufc.breezechms.com/api/events?start=" . $start_date_string . "&end=" . $end_date_string . "&details=1";

      // Get event data from Breeze 
      $breeze = new Breeze($api_key);
      $events = $breeze->url($request_url);
      $events_data = json_decode($events, true);

      // get locations from breeze
      $breeze = new Breeze($api_key);
      $locations = $breeze->url('https://uufc.breezechms.com/api/events/locations');
      $available_locations_array = json_decode($locations, true);


  };?>

  <div class="breeze-calendar">
  <h1>Development Version</h1>

</div>

<!-- CODE FOR BREEZE CALENDAR GOES HERE
******************************************
****************************************** -->

<head>
  <meta charset="UTF-8">
  <title>Event List</title>
  <link rel="stylesheet" href="css/event_list.css">
  <!--include font awesome-->
  <script src="https://kit.fontawesome.com/6e1b248090.js" crossorigin="anonymous"></script> 
</head>
  <div id="app-container">
    <!-- Event List -->
    <div class="event-list-container">
      <h2 id="event-list-heading">Coming Up...</h2>
      <div id="event-list">
        <?php
          // loop through events
          foreach ( $events_data as $event)  {
            $name = $event["name"];
            $start_datetime = $event["start_datetime"];
            $month = date("M", strtotime($start_datetime));
            $day = date("d", strtotime($start_datetime));
            $year = date("Y", strtotime($start_datetime));
            // strip of the leading zero
            if ($day[0] == "0") {
              $day = $day[1];
            };
            // parse start time string
            $start_time = date("g:i A", strtotime($start_datetime));
            // if the start time is on the hour, remove the minutes
            if (substr($start_time, -2) == "00") {
              $start_time = substr($start_time, 0, -6) . substr($start_time_raw, -3);
            }; 
            // remove leading zero from start time.
            if ($start_time[0] == "0") {
              $start_time = substr($start_time, 1);
            };
            // parse end time string
            $end_datetime = $event["end_datetime"];
            // if end time is not set, don't display it
            if ($end_datetime == "0000-00-00 00:00:00") {
              $end_time = "";
              $time_string = $start_time;
            } else {
              $end_time = date("g:i A", strtotime($end_datetime));
              $time_string = $start_time . " - " . $end_time;
            };
            //$event_description = $event["details"]["event_description"];
            $category_id = $event["category_id"];
            
            // get only the first location id listed 
            $location_ids_raw = $event["details"]["location_ids_json"];
            $location_ids_array = json_decode($location_ids_raw);
            $event_location_id = $location_ids_array[0]->id;
            // get the location name from the available locations array
            // Find the element in  $available_locations_array with the value for "id" that matches $event_location_id.
            // Then get the value for "name" from that element.
            // $index will be the index of the element in $available_locations_array that matches $event_location_id.
            $index = array_search($event_location_id, array_column($available_locations_array, 'id'));
            $location_name = $available_locations_array[$index]["name"];?>
            <div class="event-container" onclick="toggleEventSummary(this)">
              <!-- Event Summary -->
              <div class="event-summary">
                <div class="date-container">
                  <h1 class="day"><?php echo $day ?></h1>
                  <p class="month"><?php echo $month ?></p>
                </div>
                <div class="event-info-container">
                    <h2 class="event-name"><?php echo $event["name"]; ?></h2>
                    <p class="event_time"><i class="fa-regular fa-clock"></i>* <?php echo $time_string; ?></p>
                    <p class="event_location"><i class="fa-solid fa-location-dot"></i>* <?php echo $location_name;  ?></p>    
                </div>  
                <div class="link-to-info-container">
                  <span id="link-to-info">info</span>
                </div>
              </div>
              <!-- Event Details: 
              Expands when event summary is clicked upon -->
              <div class="event-details">
                <h1 class="details-date"><?php echo $month; ?> <?php echo $day; ?>, <?php echo $year; ?></h1>
                <h2 class="details-name"><?php echo $event["name"]; ?></h2> 
                <p><strong>start time: </strong><?php echo date("g:i A", strtotime($start_datetime) ); ?></p>
                <p><strong>end time: </strong><?php echo date("g:i A", strtotime($end_datetime) ); ?></p>
                <p><strong>location: </strong><?php echo $location_name; ?></p>
                <p><strong>description: </strong><?php echo $event["details"]["event_description"]; ?></p>
                <p class="back-to-summary">back to summary</p>
              </div>
            <!-- End of event container -->  
            </div>
        
        <?php  }; // end foreach loop ?>     
        </div>  
    </div>
    <!--Event Details-->
  <!--  <div class="event-details-container">
      <h1>Sunday Service</h1>
      <h1>July 1, 2023</h1>
      <p><strong>Start/End: </strong>10:00 AM - 11:15 AM</p>
      <p><strong>Location: </strong>Avery Park</p>
      <p><strong>Description: </strong>Blah blah blah blah blah Blah blah blah blah blah Blah blah blah blah blah Blah blah blah blah blah Blah blah blah blah blah Blah blah blah blah blah Blah blah blah blah blah Blah blah blah blah blah Blah blah blah blah blah Blah blah blah blah blah</p>
      <p class="back-to-events">Back to Events</p>
    </div>  -->
  </div>
  <script src="js/event_list.js"></script>





  