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
        width: 15%;
        height: 20px;
        top: 37.8mm;
        left: 83%;
    }
    #date_requested {
        width: 17%;
        height: 16px;
        top: 48mm;
        left: 80.5%;
    }
    #requesting_office {
        width: 35%;
        height: 22px;
        top: 112mm;
        left: 30%;
        text-align: center;
    }
    #requester {
        width: 25%;
        height: 22px;
        top: 112mm;
        left: 3%;
        text-align: center;
        font-weight: bold;
    }
    #booked {
        width: 26%;
        height: 22px;
        top: 112mm;
        left: 73%;
        text-align: center;
        font-weight: bold;
    }
    #approving {
        width: 35%;
        height: 22px;
        top: 134mm;
        left: 24%;
        text-align: center;
        font-weight: bold;
    }
    #noted {
        width: 26%;
        height: 22px;
        top: 146mm;
        left: 65%;
        text-align: center;
        font-weight: bold;
    }
  </style>
</head>
<body>

    <img src="{{ public_path('images/Request-for-Air-Transport-Order.jpg') }}" style="position:absolute; top:0; left:0; width:215.9mm; height:330.2mm; z-index:-1000;" alt="form">

    <div class="content" id="control_number">{{ $control_number }}</div>
    <div class="content" id="date_requested">{{ date("F j, Y",strtotime($date_requested)) }}</div>
    <div class="content" id="requesting_office">{{ $requesting_office }}</div>
    @if ( $trip_ticket_type == 'Round-Trip')
            <div style="position: absolute; top: 59.5mm; left: 94.5mm; font-family: 'dejavusans'; font-size:medium">✔</div>
    @elseif ( $trip_ticket_type == 'One-Way')
            <div style="position: absolute; top: 57.2mm; left: 94.5mm; font-family: 'dejavusans'; font-size:medium">✔</div>
    @endif
    @foreach ( $passengers as $index => $passenger )
        <div class="content" style="width: 25%; height: 13px; top: {{ 64 + ($index * 3.8) }}mm; left: 5%;">{{ $passenger['first_name'] ." \u{00A0}". $passenger['last_name'] }}</div>
    @endforeach
    @foreach ( $flights as $index => $flight )
        <div class="content" style="width: 16%; height: 13px; top: {{ 64 + ($index * 3.8) }}mm; left: 30.3%;">{{ $flight['destination_from']."-".$flight['destination_to']  }}</div>
        @if ($flight['trip_mode'] == 'Depart')
            <div class="content" style="width: 11%; height: 13px; top: {{ 64 + ($index * 3.8) }}mm; left: 47%;">{{ date("M j, Y",strtotime($flight['departure_date']))  }}</div>
            <div class="content" style="width: 6%; height: 13px; top: {{ 64 + ($index * 3.8) }}mm; left: 58.5%;">{{ date("h:i A",strtotime($flight['etd']))  }}</div>
            <div class="content" style="width: 6%; height: 13px; top: {{ 64 + ($index * 3.8) }}mm; left: 65.5%;">{{ date("h:i A",strtotime($flight['eta']))  }}</div>
        @elseif ($flight['trip_mode'] == 'Return')
            <div class="content" style="width: 11%; height: 13px; top: {{ 64 + ($index * 3.8) }}mm; left: 72.5%;">{{ date("M j, Y",strtotime($flight['departure_date']))  }}</div>
            <div class="content" style="width: 6%; height: 13px; top: {{ 64 + ($index * 3.8) }}mm; left: 84.5%;">{{ date("h:i A",strtotime($flight['etd']))  }}</div>
            <div class="content" style="width: 6%; height: 13px; top: {{ 64 + ($index * 3.8) }}mm; left: 91.5%;">{{ date("h:i A",strtotime($flight['eta']))  }}</div>
        @endif
    @endforeach

    <div class="content" id="requester">{{ $requester_name }}</div>

    @foreach($signable as $index => $signatory)
        @if($signatory['label'] === "Reserved By")
            <div class="content" id="booked">{{ $signatory['full_name'] }}</div>
        @endif
        @if($signatory['label'] === "Approved By")
            <div class="content" id="approving">{{ $signatory['full_name'] }}</div>
        @endif
        @if($signatory['label'] === "Verified By")
            <div class="content" id="noted">{{ $signatory['full_name'] }}</div>
        @endif
    @endforeach

</body>
</html>
