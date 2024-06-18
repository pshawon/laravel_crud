<!DOCTYPE html>
<html>
<head>
    <title>View PDF</title>
    <style>
        iframe {
            width: 100%;
            height: 100vh;
            border: none;
        }
    </style>
</head>
<body>
    <iframe src="{{ asset('uploads/attached/' . $profile->attached) }}"></iframe>
</body>
</html>
