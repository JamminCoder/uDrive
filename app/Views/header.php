<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name='csrf_value' content="<?= csrf_hash() ?>">
    <meta name='csrf_name' content="<?= csrf_token() ?>">
    <meta name='auth_status' content="<?= auth()->loggedIn() ? '1' : '0' ?>">
    <link rel="stylesheet" href="/css/tailwind.css">
    <base href='/'>
    <title>uDrive</title>
</head>
<body>