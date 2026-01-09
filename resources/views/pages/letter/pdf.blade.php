<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $letter->template->code }} - {{ $letter->letter_number }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            margin: 0;
            padding: 40px;
        }
        h2, h3 {
            margin: 0;
        }
        table {
            border-collapse: collapse;
        }
        td {
            vertical-align: top;
            padding: 2px 0;
        }
        .qr-code {
            text-align: center;
        }
        .signature {
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    {!! $content !!}
</body>
</html>
