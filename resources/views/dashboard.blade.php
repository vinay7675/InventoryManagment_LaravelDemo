<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite('resources/js/dashboard.js')
</head>
<body>
    <div id="app"></div>
</body>
</html>
