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
        height: 22px;
        top: 40mm;
        left: 67%;
    }
    #date_received {
        width: 25%;
        height: 22px;
        top: 61mm;
        left: 72.5%;
    }
    #requesting_office {
        width: 60%;
        height: 22px;
        top: 69mm;
        left: 37%;
    }
    #purpose {
        width: 60%;
        height: 22px;
        top: 76mm;
        left: 37%;
    }
    #count_utility {
        width: 20%;
        height: 22px;
        top: 84mm;
        left: 37%;
    }
    #date_needed {
        width: 45%;
        height: 22px;
        top: 99mm;
        left: 37%;
    }
    #location {
        width: 45%;
        height: 22px;
        top: 106mm;
        left: 37%;
    }
    #fund_source {
        width: 45%;
        height: 22px;
        top: 115mm;
        left: 50%;
    }
    #requester {
        width: 35%;
        height: 22px;
        top: 138mm;
        left: 10%;
        text-transform: uppercase;
        font-weight: bold;
        text-align: center;
    }
    #requester_position {
        width: 35%;
        height: 22px;
        top: 144mm;
        left: 10%;
        text-align: center;
    }
    #approving {
        width: 35%;
        height: 22px;
        top: 138mm;
        left: 53%;
        text-transform: uppercase;
        font-weight: bold;
        text-align: center;
    }
    #approving_position {
        width: 35%;
        height: 22px;
        top: 144mm;
        left: 53%;
        text-align: center;
        background-color: white;
    }
    #bg-white {
        width: 35%;
        height: 22px;
        top: 150mm;
        left: 53%;
        text-align: center;
        background-color: white;
    }
    #noted_by {
        width: 40%;
        height: 22px;
        top: 167mm;
        left: 10%;
        text-transform: uppercase;
        font-weight: bold;
        text-align: center;
        background-color: white;
    }
    #office_head {
        width: 35%;
        height: 22px;
        top: 254mm;
        left: 56%;
        text-transform: uppercase;
        font-weight: bold;
        text-align: center;
    }

  </style>
</head>
<body>

  <!-- Page 1 -->
    <img src="{{ public_path('images/Request-for-Janitorial-Services.jpg') }}" style="position:absolute; top:0; left:0; width:215.9mm; height:330.2mm; z-index:-1000;" alt="form">

    <div class="content" id="control_number">{{ $control_number }}</div>
    <div class="content" id="date_received">{{ date("F j, Y",strtotime($updated_at)) }}</div>
    <div class="content" id="requesting_office">{{ $requesting_office }}</div>
    <div class="content" id="fund_source">{{ $fund_source }}</div>
    <div class="content" id="purpose">{{ $purpose }}</div>
    <div class="content" id="count_utility">{{ $count_utility }}</div>
    <div class="content" id="location">{{ $location }}</div>
    <div class="content" id="date_needed">{{ date("F j, Y",strtotime($requested_date)) }} - {{ date("h:m A",strtotime($requested_time)) }}</div>
    <div class="content" id="requester">{{ $requester_name }}</div>
    <div class="content" id="requester_position">{{ $requester_position }}</div>
    @foreach($signable as $index => $signatory)
        @if($signatory['label'] === "Approving Officer")
            <div class="content" id="approving">{{ $signatory['full_name'] }}</div>
            <div class="content" id="approving_position">{{ $signatory['position'] }}</div>
            <div class="content" id="bg-white"></div>
        @endif
    @endforeach
    @foreach($signable as $index => $signatory)
        @if($signatory['label'] === "Noted by")
            <div class="content" id="noted_by">{{ $signatory['full_name'] }}</div>
        @endif
    @endforeach
    @foreach ($janitorable as $index => $janitor)
        <div class="content" style="width: 60%; height: 22px; top: {{ 218 + ($index * 8) }}mm; left: 14%;">{{ $janitor['full_name'] }}</div>
    @endforeach
    <div class="content" id="office_head">{{ $office_head }}</div>
</body>
</html>
