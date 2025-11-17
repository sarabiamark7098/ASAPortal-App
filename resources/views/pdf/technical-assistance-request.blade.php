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
    #date_received {
        width: 25%;
        height: 22px;
        top: 59mm;
        left: 27%;
    }
    #requesting_office {
        width: 60%;
        height: 22px;
        top: 73mm;
        left: 29%;
    }
    #details {
        width: 83%;
        height: 54px;
        top: 173mm;
        left: 9%;
    }
    #requester {
        width: 41.5%;
        height: 22px;
        top: 206mm;
        left: 10%;
        text-transform: uppercase;
        font-weight: bold;
        text-align: center;
    }
    #requester_signature {
        width: 15%;
        height: 60px;
        top: 190mm;
        left: 25%;
        text-transform: uppercase;
        font-weight: bold;
        text-align: center;
    }
    #requester_position {
        width: 34%;
        height: 22px;
        top: 212mm;
        left: 17.7%;
    }
    #approving {
        width: 41.5%;
        height: 22px;
        top: 241mm;
        left: 10%;
        text-transform: uppercase;
        font-weight: bold;
        text-align: center;
    }
    #approving_position {
        width: 41.5%;
        height: 22px;
        top: 247.5mm;
        left: 10%;
        text-align: center;
        background-color: white;
    }
    #control_number {
        width: 41.5%;
        height: 33px;
        top: 258mm;
        left: 10%;
        text-align: center;
    }


  </style>
</head>
<body>

  <!-- Page 1 -->
    <img src="{{ public_path('images/Request-for-Technical-Assistance.jpg') }}" style="position:absolute; top:0; left:0; width:215.9mm; height:330.2mm; z-index:-1000;" alt="form">

    <div class="content" id="control_number">TA No. :{{ $control_number }}</div>
    <div class="content" id="date_received">{{ date("F j, Y",strtotime($updated_at)) }}</div>
    <div class="content" id="requesting_office">{{ $requesting_office }}</div>

    @foreach ( $request_type as $type )
        @if($type == "Repair and Maintenance")
            <div style="position: absolute; top: 93mm; left: 21mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($type == "Replacement")
            <div style="position: absolute; top: 98.5mm; left: 21mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($type == "Installation")
            <div style="position: absolute; top: 104mm; left: 21mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($type == "Fabrication")
            <div style="position: absolute; top: 109.5mm; left: 21mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($type == "Renovation/Improvement")
            <div style="position: absolute; top: 115mm; left: 21mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($type == "Construction")
            <div style="position: absolute; top: 120.5mm; left: 21mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($type == "Technical/Material Specification")
            <div style="position: absolute; top: 126mm; left: 21mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($type == "Layout/Plans")
            <div style="position: absolute; top: 131.5mm; left: 21mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($type == "Decoration/Arrangement")
            <div style="position: absolute; top: 137mm; left: 21mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($type == "Assistance/Supervision")
            <div style="position: absolute; top: 142.5mm; left: 21mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($type == "Other")
            <div style="position: absolute; top: 148mm; left: 21mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
            <div style="position: absolute; top: 154.5mm; left: 34mm; width: 33%;">{{ $other_nature }}</div>
        @endif
    @endforeach
    @foreach ( $request_nature as $nature )
        @if($nature == "Air-conditioning")
            <div style="position: absolute; top: 93mm; left: 109mm; font-family: 'dejavusans'; font-size:x-large;">✔</div>
        @endif
        @if($nature == "Audio-Visual")
            <div style="position: absolute; top: 98.5mm; left: 109mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($nature == "Carpentry")
            <div style="position: absolute; top: 104mm; left: 109mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($nature == "Drafting/Art Work")
            <div style="position: absolute; top: 109.5mm; left: 109mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($nature == "Electrical")
            <div style="position: absolute; top: 115mm; left: 109mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($nature == "Masonry")
            <div style="position: absolute; top: 120.5mm; left: 109mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($nature == "Plumbing")
            <div style="position: absolute; top: 126mm; left: 109mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($nature == "Steelworks")
            <div style="position: absolute; top: 131.5mm; left: 109mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($nature == "Technical Staff/Document")
            <div style="position: absolute; top: 137mm; left: 109mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($nature == "Telecommunication")
            <div style="position: absolute; top: 142.5mm; left: 109mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($nature == "Varnishing/Painting")
            <div style="position: absolute; top: 142.5mm; left: 109mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
        @endif
        @if($nature == "Other")
            <div style="position: absolute; top: 148mm; left: 109mm; font-family: 'dejavusans'; font-size:x-large">✔</div>
            <div style="position: absolute; top: 154.5mm; left: 128mm; width: 30%;">{{ $other_type }}</div>
        @endif
    @endforeach
    <div class="content" id="details">{{ $details }}</div>
    @foreach ($fileable as $index => $files)
        @if ($files['label'] === 'Signature')
            <div class="content" id="requester_signature"><img src="{{ public_path('images/saved/'.$files['path']) }}" alt="" width="110" height="58"></div>
        @endif
    @endforeach
    <div class="content" id="requester">{{ $requester_name }}</div>
    <div class="content" id="requester_position">{{ $requester_position }}</div>
    @foreach($signable as $index => $signatory)
        @if($signatory['label'] === "Approving Officer")
            <div class="content" id="approving">{{ $signatory['full_name'] }}</div>
            <div class="content" id="approving_position">{{ $signatory['position'] }}</div>
        @endif
    @endforeach
</body>
</html>
