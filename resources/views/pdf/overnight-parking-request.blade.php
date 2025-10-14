<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Printable Pages</title>
  <style>
    @page {
      size: 8.27in 11.69in; /* A4 size */
      margin: 0;
    }

   .content {
        position: absolute;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12pt;
    }

    #control_number {
        width: 20%;
        height: 20px;
        top: 37mm;
        left: 67%;
    }
    #requester {
        width: 55%;
        height: 23px;
        top: 50mm;
        left: 31%;
    }
    #position {
        width: 54%;
        height: 23px;
        top: 58mm;
        left: 33%;
    }
    #office {
        width: 30%;
        height: 23px;
        top: 65mm;
        left: 19%;
    }
    #contact_number {
        width: 25%;
        height: 23px;
        top: 65mm;
        left: 62%;
    }

    #justification {
        width: 75%;
        height: 22px;
        top: 76mm;
        left: 13%;
    }

    #dates {
        width: 35%;
        height: 23px;
        top: 90mm;
        left: 13%;
    }
    #vehicle_details {
        width: 35%;
        height: 23px;
        top: 90mm;
        left: 51%;
    }
    #requester_name {
        width: 35%;
        height: 23px;
        top: 109mm;
        left: 13%;
        text-transform: uppercase;
        font-weight: bold;
        text-align: center;
    }
    #requested {
        width: 35%;
        height: 20px;
        top: 120mm;
        left: 13%;
        text-align: center;
    }


    #supervising {
        width: 35%;
        height: 23px;
        top: 109mm;
        left: 55%;
        text-transform: uppercase;
        font-weight: bold;
        text-align: center;
    }
    #supervising_position {
        width: 35%;
        height: 20px;
        top: 120mm;
        left: 55%;
        text-align: center;
        background-color: white;
    }

    #page_2_control_number {
        width: 20%;
        height: 20px;
        top: 176mm;
        left: 67%;
    }
    #page_2_requester {
        width: 55%;
        height: 23px;
        top: 188mm;
        left: 31%;
    }
    #page_2_position {
        width: 54%;
        height: 23px;
        top: 197mm;
        left: 33%;
    }
    #page_2_office {
        width: 30%;
        height: 23px;
        top: 203mm;
        left: 19%;
    }
    #page_2_contact_number {
        width: 25%;
        height: 23px;
        top: 203mm;
        left: 62%;
    }

    #page_2_justification {
        width: 75%;
        height: 22px;
        top: 214mm;
        left: 13%;
    }

    #page_2_dates {
        width: 35%;
        height: 23px;
        top: 228mm;
        left: 13%;
    }
    #page_2_vehicle_details {
        width: 35%;
        height: 23px;
        top: 228mm;
        left: 51%;
    }
    #page_2_requester_name {
        width: 35%;
        height: 23px;
        top: 246mm;
        left: 13%;
        text-transform: uppercase;
        font-weight: bold;
        text-align: center;
    }
    #page_2_requested {
        width: 35%;
        height: 20px;
        top: 256mm;
        left: 13%;
        text-align: center;
    }

    #page_2_supervising {
        width: 35%;
        height: 23px;
        top: 246mm;
        left: 56%;
        text-transform: uppercase;
        font-weight: bold;
        text-align: center;
    }
    #page_2_supervising_position {
        width: 35%;
        height: 20px;
        top: 256mm;
        left: 56%;
        text-align: center;
        background-color: white;
    }

  </style>
</head>
<body>

    <img src="{{ public_path('images/Request-for-Overnight-Parking.jpg') }}" style="position:absolute; top:0; left:0; width:215.9mm; height:330.2mm; z-index:-1000;" alt="form">

    <div class="content" id="control_number">{{ $control_number }}</div>
    <div class="content" id="requester">{{ $requester_name }}</div>
    <div class="content" id="position">{{ $requester_position }}</div>
    <div class="content" id="office">{{ $office }}</div>
    <div class="content" id="contact_number">{{ $requester_contact_number }}</div>
    <div class="content" id="justification">{{ $justification }}</div>
    <div class="content" id="dates">{{ date("M j, Y",strtotime($requested_start)) . " - " . date("M j, Y",strtotime($requested_end)) ." / ". date("h:i A",strtotime($requested_time)) }}</div>
    <div class="content" id="vehicle_details">{{ $model ." / ". $plate_number}}</div>

    <div class="content" id="requester_name">{{ $requester_name }}</div>
    <div class="content" id="requested">{{ date("F j, Y",strtotime($created_at))  }}</div>
    @foreach($signable as $index => $signatory)
        @if($signatory['label'] === "Approving Officer")
            <div class="content" id="supervising">{{ $signatory['full_name'] }}</div>
            <div class="content" id="supervising_position">{{ $signatory['position'] }}</div>
        @endif
    @endforeach

    <!-- page 2 -->
    <div class="content" id="page_2_control_number">{{ $control_number }}</div>
    <div class="content" id="page_2_requester">{{ $requester_name }}</div>
    <div class="content" id="page_2_position">{{ $requester_position }}</div>
    <div class="content" id="page_2_office">{{ $office }}</div>
    <div class="content" id="page_2_contact_number">{{ $requester_contact_number }}</div>
    <div class="content" id="page_2_justification">{{ $justification }}</div>
    <div class="content" id="page_2_dates">{{ date("M j, Y",strtotime($requested_start)) . " - " . date("M j, Y",strtotime($requested_end)) ." / ". date("h:i A",strtotime($requested_time)) }}</div>
    <div class="content" id="page_2_vehicle_details">{{ $model ." / ". $plate_number}}</div>

    <div class="content" id="page_2_requester_name">{{ $requester_name }}</div>
    <div class="content" id="page_2_requested">{{ date("F j, Y",strtotime($created_at))  }}</div>
    @foreach($signable as $index => $signatory)
        @if($signatory['label'] === "Approving Officer")
            <div class="content" id="page_2_supervising">{{ $signatory['full_name'] }}</div>
            <div class="content" id="page_2_supervising_position">{{ $signatory['position'] }}</div>
        @endif
    @endforeach
</body>
</html>
