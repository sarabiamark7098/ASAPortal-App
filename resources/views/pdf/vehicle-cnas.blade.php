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
        width: 35%;
        height: 20px;
        top: 35mm;
        left: 60%;
    }
    #requesting_office {
        width: 45%;
        height: 32px;
        top: 84mm;
        left: 45%;
    }
    #purpose {
        width: 45%;
        height: 36px;
        top: 93mm;
        left: 45%;
    }
    #destination {
        width: 45%;
        height: 35px;
        top: 103mm;
        left: 45%;
    }
    #dates {
        width: 45%;
        height: 32px;
        top: 113mm;
        left: 45%;
    }
    #supervising {
        width: 50%;
        height: 22px;
        top: 161mm;
        left: 12%;
        font-weight: bold;
    }
    #supervising_position {
        width: 50%;
        height: 16px;
        top: 167mm;
        left: 12%;
    }
  </style>
</head>
<body>

    <img src="{{ public_path('images/CNAS - Vehicle.jpg') }}" style="position:absolute; top:0; left:0; width:215.9mm; height:330.2mm; z-index:-1000;" alt="form">

    <div class="content" id="control_number">{{ 'Control Number: '. $control_number }}</div>
    <div class="content" id="requesting_office">{{ $requesting_office }}</div>
    <div class="content" id="destination">{{ $destination }}</div>
    <div class="content" id="dates">{{ date("M j, Y",strtotime($requested_start)) . " - " . date("M j, Y",strtotime($requested_end)) }}</div>
    <div class="content" id="purpose">{{ $purpose }}</div>

    @foreach($signable as $index => $signatory)
        @if($signatory['label'] === "CNAS Approving")
            <div class="content" id="supervising">{{ $signatory['full_name'] }}</div>
            <div class="content" id="supervising_position">{{ $signatory['position'] }}</div>
        @endif
    @endforeach

</body>
</html>
