<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <title>Gerenciador de contas</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    
    <style type="text/css">body{overflow-x:hidden}main{min-height:83.1vh;padding-bottom:3rem}footer,header,main{padding-left:240px}@media only screen and (max-width:992px){footer,header,main{padding-left:0}}h4{margin-top:6rem}</style>
  </head>
  <body>
    <div id="app"></div>
    <script src="{{ mix('/js/app.js') }}"></script>
    
  </body>
</html>
