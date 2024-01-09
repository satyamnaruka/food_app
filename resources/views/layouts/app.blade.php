<!DOCTYPE html>
<html lang="en">
   <head>
      <title>@yield('title') |  Urban Clap</title>
      <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}" />
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="title" content="@yield('title')" />
      <meta name="description" content="@yield('meta_description')" />
      <meta name="keywords" content="@yield('meta_keywords')" />
      <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
   </head>

<body class="home-1">

  
    @yield('content')
      
    

    @stack('custom_js')


</body>

</html>