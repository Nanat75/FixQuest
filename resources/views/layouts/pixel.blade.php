<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fix Quest</title>
    <link rel="stylesheet" href="{{ asset('css/pixel.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

      <style>
  body {
  background: url('{{ asset("img/pixel-workshop-bg.jpg") }}') repeat;
  image-rendering: pixelated;
  background-size: auto;
  font-family: 'Press Start 2P', monospace;
   overflow: hidden;
  }

.pixel-floor {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 60px;
  background: repeating-linear-gradient(
    45deg,
    #222 0 8px,
    #111 8px 16px
  );
  border-top: 4px solid #000;
  box-shadow: inset 0 8px 0 #555, inset 0 -4px 0 #000;
  z-index: 10;
}

</style>

    @stack('scripts')
</head>
<body>
    @yield('content')
</body>
</html>

