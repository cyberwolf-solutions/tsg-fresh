<!DOCTYPE html>
<html>

<head>
    <title>Redirecting to PayHere...</title>
</head>

<body onload="document.forms['payhereForm'].submit()">
    <p>Please wait, redirecting to PayHere...</p>
    <form name="payhereForm" method="POST" action="{{ $payhereUrl }}">
        @foreach ($data as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>
</body>

</html>
