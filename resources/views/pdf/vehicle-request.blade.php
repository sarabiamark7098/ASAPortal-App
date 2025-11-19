<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Printable Pages</title>
  <style>
    @page {
      size: 8.5in 13in;
      margin: 0;
      padding: 0;
    }

    .page-break {
        page-break-after: always;
    }

    .content {
        position: absolute;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12pt;
    }

    #requesting_office {
        width: 50%;
        height: 40px;
        top: 61mm;
        left: 42%;
    }
    #purpose {
        width: 50%;
        height: 66px;
        top: 72mm;
        left: 42%;
    }
    #passengers {
        width: 50%;
        height: 87px;
        top: 90mm;
        left: 42%;
    }
    #destination {
        width: 50%;
        height: 37px;
        top: 113mm;
        left: 42%;
    }
    #requested_start {
        width: 50%;
        height: 24px;
        top: 123mm;
        left: 42%;
    }
    #requested_time {
        width: 50%;
        height: 24px;
        top: 130mm;
        left: 42%;
    }
    #requester_name {
        width: 35%;
        height: 22px;
        top: 153mm;
        left: 9%;
        text-align: center;
        font-weight: bold;
    }
    #date_requested {
        width: 25%;
        height: 18px;
        top: 165mm;
        left: 26.5%;
        font-size: 10pt;
    }


    #control_number {
        width: 50%;
        height: 22px;
        top: 182mm;
        left: 28%;
    }

    #dispatcher1 {
        width: 35%;
        height: 22px;
        top: 153mm;
        left: 53%;
        text-align: center;
        font-weight: bold;
    }
    #date_received{
        width: 25%;
        height: 18px;
        top: 165mm;
        left: 66%;
        font-size: 10pt;
    }

    #dispatcher2 {
        width: 40%;
        height: 22px;
        top: 237mm;
        left: 12%;
        text-align: center;
        font-weight: bold;
    }

    #dispatcher3 {
        width: 35%;
        height: 22px;
        top: 292mm;
        left: 12%;
        text-align: center;
        font-weight: bold;
    }
    #supervising {
        width: 38%;
        height: 22px;
        top: 292mm;
        left: 50%;
        text-align: center;
        font-weight: bold;
    }
    #supervising_position{
        background-color: white;
        width: 38%;
        height: 16px;
        top: 299mm;
        left: 50%;
        text-align: center;
    }
    #vehicle_type{
        width: 23%;
        height: 18px;
        top: 197mm;
        left: 26%;
        font-size: 10pt;
    }
    #plate_number{
        width: 23%;
        height: 18px;
        top: 202mm;
        left: 26%;
        font-size: 10pt;
    }
    #driver_name{
        width: 30%;
        height: 18px;
        top: 197mm;
        left: 62%;
        font-size: 10pt;
    }
    #contact_number{
        width: 30%;
        height: 18px;
        top: 202mm;
        left: 62%;
        font-size: 10pt;
    }
    #check_date{
        width: 25%;
        height: 18px;
        top: 237mm;
        left: 67%;
        font-size: 10pt;
    }
    #check_time{
        width: 25%;
        height: 18px;
        top: 244mm;
        left: 67%;
        font-size: 10pt;
    }

    #available{
        width: 3%;
        height: 30px;
        top: 258mm;
        left: 12.2%;
        font-size: 17pt;
        font-weight: bold;
    }
    #approved{
        width: 3%;
        height: 30px;
        top: 258mm;
        left: 50.4%;
        font-size: 17pt;
        font-weight: bold;
    }
    #notavailable{
        width: 3%;
        height: 30px;
        top: 258mm;
        left: 25.8%;
        font-size: 17pt;
        font-weight: bold;
    }
    #notavailable2{
        width: 3%;
        height: 30px;
        top: 267mm;
        left: 50.4%;
        font-size: 17pt;
        font-weight: bold;
    }
    #disapproved{
        width: 3%;
        height: 30px;
        top: 262.5mm;
        left: 50.4%;
        font-size: 17pt;
        font-weight: bold;
    }


    /* Page 2 */
    #page2_control_number {
        width: 15%;
        height: 20px;
        top: 46mm;
        left: 77%;
    }
    #page2_date {
        width: 25%;
        height: 20px;
        top: 66mm;
        left: 28.5%;
    }
    #page2_plate_number{
        width: 15%;
        height: 20px;
        top: 66mm;
        left: 77%;
    }
    #page2_driver_name{
        width: 60%;
        height: 20px;
        top: 74mm;
        left: 28.5%;
    }
    #page2_passengers {
        width: 60%;
        height: 70px;
        top: 80mm;
        left: 28.5%;
    }
    #page2_destination {
        width: 60%;
        height: 20px;
        top: 99mm;
        left: 28.5%;
    }
    #page2_purpose {
        width: 60%;
        height: 50px;
        top: 108mm;
        left: 28.5%;
    }
    #page2_dispatcher1 {
        width: 35%;
        height: 22px;
        top: 128mm;
        left: 4%;
        text-align: center;
        font-weight: bold;
    }
    #page2_supervising {
        width: 38%;
        height: 22px;
        top: 128mm;
        left: 55%;
        text-align: center;
        font-weight: bold;
    }
    #page2_supervising_position{
        background-color: white;
        width: 38%;
        height: 16px;
        top: 135mm;
        left: 55%;
        text-align: center;
    }
    #page2_blank{
        background-color: white;
        width: 38%;
        height: 16px;
        top: 140mm;
        left: 55%;
        text-align: center;
    }
  </style>
</head>
<body>

  <!-- Page 1 -->
    <img src="{{ public_path('images/Request-for-Use-of-Vehicle.jpg') }}" style="position:absolute; top:0; left:0; width:215.9mm; height:330.2mm; z-index:-1000;" alt="form">

    <div class="content" id="requesting_office">{{ $requesting_office }}</div>
    <div class="content" id="purpose">{{ $purpose }}</div>
    <div class="content" id="passengers">{{ $passengers }}</div>
    <div class="content" id="destination">{{ $destination }}</div>
    <div class="content" id="requested_start">{{ $requested_start }}</div>
    <div class="content" id="requested_time">{{ $requested_time }}</div>
    <div class="content" id="requester_name">{{ $requester_name }}</div>
    <div class="content" id="date_requested">{{ date("F j, Y",strtotime($date_requested)) }}</div>

    <div class="content" id="control_number">{{ $control_number }}</div>
    <div class="content" id="date_received">{{ date("F j, Y",strtotime($updated_at)) }}</div>

    @foreach($signable as $index => $signatory)
        @if($signatory['label'] === "Dispatcher")
            <div class="content" id="dispatcher1">{{ $signatory['full_name'] }}</div>
            <div class="content" id="dispatcher2">{{ $signatory['full_name'] }}</div>
            <div class="content" id="dispatcher3">{{ $signatory['full_name'] }}</div>
        @elseif($signatory['label'] === "Division Chief")
            <div class="content" id="supervising">{{ $signatory['full_name'] }}</div>
            <div class="content" id="supervising_position">{{ $signatory['position'] }}</div>
        @endif
    @endforeach
    @if ($vehicle_assignment)
    <div class="content" id="plate_number">{{ $vehicle_assignment['vehicle']['plate_number'] }}</div>
    <div class="content" id="vehicle_type">{{ $vehicle_assignment['vehicle']['unit_type'] }}</div>
    <div class="content" id="driver_name">{{ $vehicle_assignment['driver']['full_name'] }}</div>
    <div class="content" id="contact_number">{{ $vehicle_assignment['driver']['contact_number'] }}</div>
    @endif

    <div class="content" id="check_date">{{ date("F j, Y",strtotime($updated_at)) }}</div>
    <div class="content" id="check_time">{{ date("g:i a",strtotime($updated_at)) }}</div>

    <div class="content" id="available">{!! $status === "approved" || $status === "processed"? "&#x2713;" : "" !!}</div>
    <div class="content" id="approved">{!! $status === "approved" || $status === "processed"? "&#x2713;" : "" !!}</div>
    <div class="content" id="notavailable">{!! $status === "no_available"? "&#x2713;" : "" !!}</div>
    <div class="content" id="notavailable2">{!! $status === "no_available"? "&#x2713;" : "" !!}</div>
    <div class="content" id="disapproved">{!! $status === "disapproved"? "&#x2713;" : "" !!}</div>

    @if($status === "approved" || $status === "processed")
        <div class="page-break"></div>

    <!-- Page 2 -->
        <img src="{{ public_path('images/TRIP-TICKET.jpg') }}" style="position:absolute; top:0; left:0; width:215.9mm; height:330.2mm; z-index:-1000;" alt="form">

        <div class="content" id="page2_control_number">{{ $control_number }}</div>
        <div class="content" id="page2_plate_number">{{ $vehicle_assignment['vehicle']['plate_number'] }}</div>
        <div class="content" id="page2_date">{{ date("F j, Y",strtotime($requested_start)) ." - ". date("F j, Y",strtotime($requested_end)) }}</div>
        <div class="content" id="page2_driver_name">{{ $vehicle_assignment['driver']['full_name'] }}</div>
        <div class="content" id="page2_passengers">{{ $passengers }}</div>
        <div class="content" id="page2_destination">{{ $destination }}</div>
        <div class="content" id="page2_purpose">{{ $purpose }}</div>
        @foreach($signable as $index => $signatory)
            @if($signatory['label'] === "Dispatcher")
                <div class="content" id="page2_dispatcher1">{{ $signatory['full_name'] }}</div>
            @elseif($signatory['label'] === "Division Chief")
                <div class="content" id="page2_supervising">{{ $signatory['full_name'] }}</div>
                <div class="content" id="page2_supervising_position">{{ $signatory['position'] }}</div>
            @endif
        @endforeach
                <div class="content" id="page2_blank"></div>
    @endif
</body>
</html>
