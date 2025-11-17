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
        width: 25%;
        height: 22px;
        top: 40.5mm;
        left: 67%;
    }
    #date_requested {
        width: 20%;
        height: 20px;
        top: 54.5mm;
        left: 71%;
    }
    #requesting_office {
        width: 50%;
        height: 22px;
        top: 98mm;
        left: 37%;
    }

    #requested_date {
        width: 50%;
        height: 22px;
        top: 106mm;
        left: 37%;
    }

    #requester_signature {
        width: 15%;
        height: 60px;
        top: 230mm;
        left: 25%;
        text-transform: uppercase;
        font-weight: bold;
        text-align: center;
    }

    #requester {
        width: 35%;
        height: 22px;
        top: 244mm;
        left: 10%;
        text-align: center;
        font-weight: bold;
    }

    #approving {
        width: 35%;
        height: 22px;
        top: 244mm;
        left: 56%;
        text-align: center;
        font-weight: bold;
    }


    #approving_position {
        width: 35%;
        height: 20px;
        top: 251mm;
        left: 56%;
        text-align: center;
    }
  </style>
</head>
<body>

    <img src="{{ public_path('images/Request-for-Entry-to-DSWD-Premises.jpg') }}" style="position:absolute; top:0; left:0; width:215.9mm; height:330.2mm; z-index:-1000;" alt="form">

    <div class="content" id="control_number">{{ $control_number }}</div>
    <div class="content" id="date_requested">{{ date("F j, Y",strtotime($date_requested)) }}</div>
    <div class="content" id="requesting_office">{{ $requesting_office }}</div>
    <div class="content" id="requested_date">{{ date("F j, Y",strtotime($requested_date)) }}</div>

    @foreach ( $guests as $index => $guest )
        @if($index == 0)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 6) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 6) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
        @if($index == 1)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 6) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 6) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
        @if($index == 2)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.8) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.8) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
        @if($index == 3)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.7) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.7) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
        @if($index == 4)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.6) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.6) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
        @if($index == 5)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.6) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.6) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
        @if($index == 6)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.6) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.6) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
        @if ($index == 7)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
        @if ($index == 8)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
        @if ($index == 9)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
        @if ($index == 10)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
        @if ($index == 11)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
        @if ($index == 12)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
        @if ($index == 13)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
        @if ($index == 14)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
        @if ($index == 15)
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 12.5%;">{{ $guest['full_name']}}</div>
        <div class="content" style="width: 37%; height: 20px; top: {{ 132 + ($index * 5.55) }}mm; left: 50.5%;">{{ $guest['purpose']}}</div>
        @endif
    @endforeach

    @foreach ($fileable as $index => $files)
        @if ($files['label'] === 'Signature')
            <div class="content" id="requester_signature"><img src="{{ public_path('images/saved/'.$files['path']) }}" alt="" width="110" height="58"></div>
        @endif
    @endforeach

    <div class="content" id="requester">{{ $requester_name }}</div>
<div class="content" style="background-color: white; width: 30%; height: 50px; top:251mm; left: 58%;"></div>
    @foreach($signable as $index => $signatory)
        @if($signatory['label'] === "Approved By")
            <div class="content" id="approving">{{ $signatory['full_name'] }}</div>
            <div class="content" id="approving_position">{{ $signatory['position'] }}</div>
        @endif
    @endforeach


</body>
</html>
