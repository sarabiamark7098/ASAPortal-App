<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @page {
            size: 8.5in 13in;
            font-size: 11pt;
            footer: page-footer;
            margin: 1.25cm;
            margin-top: 90pt;
        }

        @page :first {
            header: page-header;
        }
        body{
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1;
            letter-spacing: -0.2pt;
        }
    </style>
</head>
<body>
    
    <htmlpageheader name="page-header" style="display:none">
        <div>
            Header
        </div>
    </htmlpageheader>
    <div id="pdf-body">

    </div>
</body>
</html>