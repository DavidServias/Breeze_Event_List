<?php
  $events ='
    [
      {"name":"Movie Night",
        "category_id":"1",
        "start_datetime":"2022-11-05 20:30:00",
        "end_datetime":"0000-00-00 00:00:00",
        "details":
          {"location_ids_json": 
            "[{\"id\":\"188\"},{\"id\":\"190\"},{\"id\":\"850\"},{\"id\":\"187\"}]",
            "event_description":"This is a description of the event."
          }
      },
      {"name":"Tuna Roast",
        "category_id":"1",
        "start_datetime":"2022-11-05 20:30:00",
        "end_datetime":"0000-00-00 00:00:00",
        "details":
          {"location_ids_json": 
            "[{\"id\":\"190\"},{\"id\":\"190\"},{\"id\":\"850\"},{\"id\":\"187\"}]",
            "event_description":"This is a description of the event."
          }
      },
      {"name":"Rummage Sale",
        "category_id":"1",
        "start_datetime":"2022-11-05 20:30:00",
        "end_datetime":"0000-00-00 00:00:00",
        "details":
          {"location_ids_json": 
            "[{\"id\":\"850\"},{\"id\":\"190\"},{\"id\":\"850\"},{\"id\":\"187\"}]",
            "event_description":"This is a description of the event."
          }
      }
      
    ]';

    $available_locations_json = '[
        {
                "id":"190",
                "name":"Adult Ministries Room"
            },
        {
                "id":"188",
                "name":"Auditorium"
            },
        {
                "id":"189",
                "name":"Gathering Space"
            },
        {
                "id":"850",
                "name":"Room 301"
            },
        {
                "id":"187",
                "name":"Student Room"
            }
        ]';
