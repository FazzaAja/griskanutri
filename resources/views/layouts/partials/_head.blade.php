<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
{{-- Judul bisa dinamis, dengan fallback jika tidak di-set --}}
<title>@yield('title', 'GiskaNutri Admin')</title>

<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="language" content="en-EN">
<meta name="author" content="Fazza">

{{-- TAMBAHKAN KODE FAVICON DI SINI --}}
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">


<link href="https://fonts.googleapis.com/icon?family=Poppins" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/font-awesome-line-awesome/css/all.min.css" integrity="sha512-dC0G5HMA6hLr/E1TM623RN6qK+sL8sz5vB+Uc68J7cBon68bMfKcvbkg6OqlfGHo1nMmcCxO5AinnRTDhWbWsA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.4/css/bulma.min.css" integrity="sha512-HqxHUkJM0SYcbvxUw5P60SzdOTy/QVwA1JJrvaXJv4q7lmbDZCmZaqz01UPOaQveoxfYRv1tHozWGPMcuTBuvQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
{{-- Ganti path CSS ini menggunakan helper asset() Laravel --}}
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
