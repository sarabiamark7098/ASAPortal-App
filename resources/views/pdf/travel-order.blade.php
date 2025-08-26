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

    /* TO */
    #control_number {
        width: 20%;
        height: 20px;
        top: 44.5mm;
        left: 74%;
    }
    #check_date {
        width: 20%;
        height: 20px;
        top: 52mm;
        left: 74%;
    }
    #driver_name {
        width: 55%;
        height: 20px;
        top: 67mm;
        left: 24.8%;
        font-weight: bold;
        text-transform: uppercase;
    }
    #vehicle {
        width: 30%;
        height: 20px;
        top: 82mm;
        left: 59%;
    }
    #destination {
        width: 33%;
        height: 20px;
        top: 88.4mm;
        left: 51.5%;
    }
    #dates {
        width: 21%;
        height: 20px;
        top: 95mm;
        left: 11.5%;
    }
    #purpose {
        width: 68%;
        height: 20px;
        top: 101mm;
        left: 21%;
    }
    #supervising {
        width: 38%;
        height: 22px;
        top: 125mm;
        left: 51%;
        text-align: center;
        font-weight: bold;
    }
    #supervising_position{
        background-color: white;
        width: 38%;
        height: 16px;
        top: 131mm;
        left: 51%;
        text-align: center;
    }

    /* CA */
    #ca_driver_name {
        width: 37%;
        height: 20px;
        top: 175.5mm;
        left: 34%;
        text-transform: uppercase;
    }
    #ca_destination {
        width: 33%;
        height: 20px;
        top: 184mm;
        left: 51%;
    }
    #ca_dates {
        width: 30%;
        height: 20px;
        top: 192.5mm;
        left: 16%;
    }
    #ca_purpose {
        width: 68%;
        height: 20px;
        top: 201.5mm;
        left: 21%;
    }
  </style>
</head>
<body>

    <img src="{{ public_path('images/TRAVEL-ORDER-FORM.jpg') }}" style="position:absolute; top:0; left:0; width:215.9mm; height:330.2mm; z-index:-1000;" alt="form">

    <div class="content" id="control_number">{{ $control_number }}</div>
    <div class="content" id="check_date">{{ date("F j, Y",strtotime($updated_at)) }}</div>
    <div class="content" id="driver_name">{{ $vehicle_assignment['driver']['full_name'] }}</div>
    <div class="content" id="vehicle">{{ $vehicle_assignment['vehicle']['unit_type'] ." - ".  $vehicle_assignment['vehicle']['plate_number']  }}</div>
    <div class="content" id="destination">{{ $destination }}</div>
    <div class="content" id="dates">{{ date("M j, Y",strtotime($requested_start)) . " - " . date("M j, Y",strtotime($requested_end)) }}</div>
    <div class="content" id="purpose">{{ $purpose }}</div>
    @foreach($signable as $index => $signatory)
        @if($signatory['label'] === "Division Chief")
            <div class="content" id="supervising">{{ $signatory['full_name'] }}</div>
            <div class="content" id="supervising_position">{{ $signatory['position'] }}</div>
        @endif
    @endforeach
    <div class="content" id="ca_driver_name">{{ $vehicle_assignment['driver']['full_name'] }}</div>
    <div class="content" id="ca_destination">{{ $destination }}</div>
    <div class="content" id="ca_dates">{{ date("M j, Y",strtotime($requested_start)) . " - " . date("M j, Y",strtotime($requested_end)) }}</div>
    <div class="content" id="ca_purpose">{{ $purpose }}</div>

</body>
</html>
