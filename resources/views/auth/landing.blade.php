<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FixQuest | Welcome</title>

  <!-- Google pixel font -->
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

  <!-- Your custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
  <style>
  body {
  background: url('{{ asset("img/pixel-workshop-bg.jpg") }}') repeat;
  image-rendering: pixelated;
  background-size: auto;
  font-family: 'Press Start 2P', monospace;
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
  z-index: 1;
}

</style>
</head>

<body><div class="garage-door"></div>
  <div class="garage-panels">
  <div class="panel"></div>
  <div class="panel"></div>
  <div class="panel"></div>
  <div class="panel"></div>
  <div class="panel"></div>
  <div class="panel"></div>
</div>


<div class="handunit">
  <div class="handunit-handle">
    <!-- handle decoration, you could even add grip lines with CSS later -->
  </div>
  <div class="handunit-body">
<div class="handunit-screen">
  <div class="screen-content">
    <p class="screen-text">FixQuest System Ready</p>
    <div class="handunit-chat">
      <div class="mascot">
        <img src="{{ asset('img/mascot.png') }}" alt="Mascot">
      </div>
      <div class="speech-bubble">
        <p>Hi user! Apa yang ingin Anda lakukan?</p>
      </div>
    </div>
  </div>
</div>
<div class="handunit-buttons">
  <button onclick="goLogin()">Login</button>
  <button onclick="goRegister()">Register</button>
</div>
  </div>
  </div>
  
   <div class="pixel-floor"></div>

  <audio id="doorSound" src="{{ asset('audio/garage-door.mp3') }}" preload="auto"></audio>

  <script>
    function goLogin() {
      // handunit goes down
      document.querySelector('.handunit').classList.add('slide-down');
      // garage door opens
      document.querySelector('.garage-panels').classList.add('open');
      document.getElementById('doorSound').play();

      // after short delay redirect to login
      setTimeout(() => {
        window.location.href = "{{ route('login') }}";
      }, 2000);
    }

    function goRegister() {
      document.querySelector('.handunit').classList.add('slide-down');
      document.querySelector('.garage-panels').classList.add('open');
      document.getElementById('doorSound').play();
      setTimeout(() => {
        window.location.href = "{{ route('register') }}";
      }, 2000);
    }
    
    // make the handunit show up on load
window.onload = () => {
  document.querySelector('.handunit').classList.add('show');
};

  </script>
</body>
</html>
