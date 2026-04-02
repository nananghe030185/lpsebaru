<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="referer" content="origin">
    <title>LPSE Indonesia</title>
</head>
<body>
    <script>
        document.referer = "{{ $referer }}";
        window.location.href = "{{ $target }}";
    </script>
</body>
</html>