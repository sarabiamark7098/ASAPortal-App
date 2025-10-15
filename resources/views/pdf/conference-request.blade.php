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
    #control_number {
        width: 25%;
        height: 33px;
        top: 28.5mm;
        left: 67%;
    }
    #date_received {
        width: 20%;
        height: 20px;
        top: 57.6mm;
        left: 76.5%;
    }
    #requesting_office {
        width: 50%;
        height: 33px;
        top: 69mm;
        left: 34.5%;
    }
    #purpose {
        width: 50%;
        height: 45px;
        top: 78mm;
        left: 34.5%;
    }
    #requested_datetime {
        width: 50%;
        height: 45px;
        top: 90mm;
        left: 34.5%;
    }
    #pax {
        width: 50%;
        height: 25px;
        top: 106mm;
        left: 34.5%;
    }
    #focal {
        width: 50%;
        height: 45px;
        top: 116mm;
        left: 34.5%;
    }
    #facility {
        width: 27.5%;
        height: 22px;
        top: 152mm;
        left: 34.5%;
        text-align: center;
    }

    #building {
        width: 26%;
        height: 22px;
        top: 152mm;
        left: 64%;
        text-align: center;
    }

    #requester {
        width: 38%;
        height: 22px;
        top: 241mm;
        left: 12%;
        text-align: center;
    }
    #requester_position {
        width: 38%;
        height: 22px;
        top: 247mm;
        left: 12%;
        text-align: center;
        background-color:white;
    }
    #approving {
        width: 38%;
        height: 22px;
        top: 241mm;
        left: 55%;
        text-align: center;
    }
    #approving_position {
        width: 38%;
        height: 22px;
        top: 247mm;
        left: 55%;
        text-align: center;
        background-color:white;
    }


  </style>
</head>
<body>

  <!-- Page 1 -->
    <img src="{{ public_path('images/Request-for-Use-of-Conference-Room.jpg') }}" style="position:absolute; top:0; left:0; width:215.9mm; height:330.2mm; z-index:-1000;" alt="form">

    <div class="content" id="control_number">{{ $control_number }}</div>
    <div class="content" id="date_received">{{ date("F j, Y",strtotime($updated_at)) }}</div>
    <div class="content" id="requesting_office">{{ $requesting_office }}</div>
    <div class="content" id="purpose">{{ $purpose }}</div>
    <div class="content" id="requested_datetime">{{ date("F j, Y",strtotime($requested_start)) }} - {{ date("F j, Y",strtotime($requested_end)) }} <br> {{ date("h:i a",strtotime($requested_time_start)) }} - {{ date("h:i a",strtotime($requested_time_end)) }}</div>
    <div class="content" id="pax">{{ $number_of_persons }} PAX</div>
    <div class="content" id="focal">{{ $requester_name }}-{{ $requester_contact_number }}</div>
    <div class="content" id="facility">{{ $conference_room==='seminar'?'Seminar Hall':($conference_room==='magiting'?'Magiting Conference Room':($conference_room==='maagap'?'Maagap Conference Room':'')) }}</div>
    <div class="content" id="building">{{ $conference_room==='seminar'?'Sapphire Building':($conference_room==='magiting'?'Emerald Building':($conference_room==='maagap'?'Emerald Building':'')) }}</div>


    <div class="content" id="requester">{{ $requester_name }}</div>
    <div class="content" id="requester_position">{{ $requester_position }}</div>
    @foreach($signable as $index => $signatory)
        @if($signatory['label'] === "Division Chief")
            <div class="content" id="approving">{{ $signatory['full_name'] }}</div>
            <div class="content" id="approving_position">{{ $signatory['position'] }}</div>
        @endif
    @endforeach
</body>
</html>
