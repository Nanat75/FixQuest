<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>FixQuest | Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
  <style>
body {
  background: url('{{ asset("img/pixel-workshop-bg.jpg") }}') repeat;
  image-rendering: pixelated;
  background-size: auto;
  font-family: 'Press Start 2P', monospace;
  height: 100vh;
  margin: 0;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: background-color 1s ease;
   min-height: 100vh;
  overflow-y: auto;
  overflow-x: hidden;
}

.transition-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: #fefefe;
  opacity: 0;
  transition: opacity 0.6s ease;
  z-index: 9999;
  pointer-events: none;
}

.transition-overlay.active {
  opacity: 1;
}

.pixel-floor {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 60px;
  background: repeating-linear-gradient(45deg, #222 0 8px, #111 8px 16px);
  border-top: 4px solid #000;
  box-shadow: inset 0 8px 0 #555, inset 0 -4px 0 #000;
  z-index: 10;
}

.scene-wrapper {
  display: flex;
  gap: 200px;
  align-items: flex-end;
  justify-content: center;
  margin-bottom: 60px;
  opacity: 0;
  transform: translateY(30px); /* Start slightly below */
  transition: opacity 0.8s ease, transform 0.8s ease;
  z-index: 5;
  flex-direction: row;
}

.scene-wrapper.show {
  opacity: 1;
  transform: translateY(0);
}


.pixel-monitor {
  width: 500px;
  background: #111;
  border: 10px solid #333;
  border-radius: 12px 12px 6px 6px;
  box-shadow: 0 0 20px #000;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 150px;
  position: relative;
}

.monitor-screen {
  background: radial-gradient(circle at center, #000 60%, #111 100%);
  width: 100%;
  height: 260px;
  padding: 12px;
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  border-bottom: 4px solid #222;
  overflow: hidden;
}

.monitor-screen::after {
  content: "";
  position: absolute;
  top: 0; left: 0;
  width: 100%;
  height: 100%;
  background-image: repeating-linear-gradient(
    rgba(255, 255, 255, 0.05) 0px,
    rgba(255, 255, 255, 0.05) 1px,
    transparent 1px,
    transparent 3px
  );
  pointer-events: none;
}

.screen-header {
  position: absolute;
  top: 8px;
  left: 50%;
  transform: translateX(-50%);
  font-size: 10px;
  color: #ffffff;
  animation: blink 1.5s step-start infinite;
}

@keyframes blink {
  50% { opacity: 0; }
}

.screen-content {
  margin-top: 28px;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  justify-content: flex-start;
  gap: 20px;
  padding-left: 20px;
  z-index: 2;
  position: relative;
}

.screen-content img {
  width: 210px;
  height: auto;
  margin-top: 70px;
}

.speech-bubble {
  background: #fff;
  border: 2px solid #000;
  border-radius: 10px;
  padding: 10px 12px;
  color: #000;
  font-size: 10px;
  line-height: 1.4;
  box-shadow: 3px 3px 0 #000;
  position: relative;
  width: 180px;
  left: -20px;
  top: 70px;
}

.speech-bubble::after {
  content: "";
  position: absolute;
  left: -20px;
  top: 20px;
  width: 0;
  height: 0;
  border: 8px solid transparent;
  border-right-color: #fff;
}

.monitor-stand {
  width: 60px;
  height: 25px;
  background: #333;
  border: 4px solid #000;
  border-radius: 2px;
  margin-top: 4px;
}

.monitor-table {
  width: 800px;
  height: 20px;
  background: #a97d4d;
  border: 4px solid #000;
  box-shadow: inset 0 -4px 0 #754c29, 4px 4px 0 #000;
  border-radius: 4px;
  margin-top: -4px;
}

/* Register Form Container */
.form-container {
  background: #002244;
  border: 6px solid #000;
  box-shadow: 6px 6px 0 #000;
  padding: 30px;
  border-radius: 10px;
  margin-bottom: 40px;
  margin-top: 40px;
  margin-left: 120px;
  position: relative;
}

.register-box {
  color: #fff;
  width: 400px;
}

.register-terminal {
  background: #1a1a2e;
  border: 6px solid #000;
  width: 450px;
  box-shadow: 8px 8px 0 #000;
  border-radius: 12px;
  padding: 0;
  margin-bottom: 40px;
  margin-top: 40px;
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
   height: 580px; /* fixed height for consistency */
  overflow: hidden; 
}

.register-device-top {
  width: 100%;
  height: 30px;
  background: #000;
  border-bottom: 3px solid #222;
  display: flex;
  justify-content: start;
  gap: 10px;
  align-items: center;
  padding: 0 10px;
  border-radius: 10px 10px 0 0;
}

.light-indicator {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: #444;
  box-shadow: 0 0 5px #000;
}

.light-indicator.red { background: #ff4d4d; }
.light-indicator.yellow { background: #ffcc00; }
.light-indicator.green { background: #33cc33; }

.register-device-screen {
  background: #002244;
  width: 100%;
  padding: 30px 20px;
  box-sizing: border-box;
  border-top: 4px solid #000;
  border-bottom: 4px solid #000;
   max-height: 500px;  /* 👈 only this part scrolls */
  overflow-y: auto;
  overflow-x: hidden;
}

.register-device-stand {
  width: 60px;
  height: 20px;
  background: #222;
  border: 4px solid #000;
  border-radius: 4px;
  margin-top: 8px;
}

.register-box h2 {
  text-align: center;
  color: #ffd700;
  margin-bottom: 24px;
  font-size: 16px;
  border-bottom: 2px dashed #ffd700;
  padding-bottom: 10px;
  text-shadow: 1px 1px #000;
}

.register-device-screen::-webkit-scrollbar {
  width: 10px;
}

.register-device-screen::-webkit-scrollbar-track {
  background: #001f3f; /* dark blue background to match the device */
  border-left: 2px solid #000;
}

.register-device-screen::-webkit-scrollbar-thumb {
  background-color: #ffd700; /* gold thumb */
  border: 2px solid #000;
  border-radius: 4px;
  box-shadow: inset 0 0 2px #000;
}


#token-label,
#token-input {
  max-height: 0;
  opacity: 0;
  overflow: hidden;
  visibility: hidden;
  margin-bottom: 0;
  transition: all 0.3s ease;
}

#token-label.show,
#token-input.show {
  max-height: 200px;
  opacity: 1;
  visibility: visible;
  margin-bottom: 20px;
}


label {
  font-size: 12px;
  color: #ffd700;
  margin-bottom: 4px;
  display: block;
}

input, select {
  display: block;
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  font-size: 14px;
  font-family: 'Press Start 2P', monospace;
  border: 2px solid #ffd700;
  background: #fff;
  color: #000;
  outline: none;
  box-shadow: inset 2px 2px 0 #000;
  box-sizing: border-box;
}

button {
  background: #ffd700;
  border: 2px solid #000;
  color: #000;
  font-family: 'Press Start 2P', monospace;
  padding: 12px;
  width: 100%;
  cursor: pointer;
  box-shadow: 4px 4px 0 #000;
  transition: transform 0.2s, background 0.3s;
}

button:hover {
  background: #fff;
  color: #002244;
  transform: translateY(-2px);
}

a.back {
  display: block;
  margin-top: 15px;
  text-align: center;
  color: #9b9b9b;
  text-decoration: none;
  font-size: 10px;
}

a.back:hover {
  color: #fff;
}

.error {
  color: #ff8080;
  font-size: 10px;
  margin-top: -10px;
  margin-bottom: 10px;
}

@keyframes blink-light {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.3; }
}

.blink {
  animation: blink-light 0.6s infinite;
}

.yes-loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: #cce2ff;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
  font-size: 1rem;
  color: #000;
  font-family: 'Press Start 2P', cursive;
  image-rendering: pixelated;
  opacity: 0;
  transition: opacity 0.6s ease;
  pointer-events: none; 
}

.yes-loading-screen.visible {
  opacity: 1;
  pointer-events: auto;
}

.yes-loading-screen.hidden {
  display: none;
}

.yes-loading-text {
  padding: 20px;
  background: #fcfff0;
  border: 4px solid #000;
  box-shadow: 6px 6px 0 #7b99bd;
  position: relative;
  text-align: center;
}

.yes-loading-text::after {
  content: " ";
  animation: loadingDots 1.2s steps(3, end) infinite;
  display: inline-block;
  margin-left: 0.3em;
}

@keyframes loadingDots {
  0%   { content: " "; }
  33%  { content: "."; }
  66%  { content: ".."; }
  100% { content: "..."; }
}

.loading-dots::after {
  content: ".";
  animation: dots 1.8s steps(1, end) infinite; /* 👈 slowed down */
}

  </style>
</head>
<body>

<div class="transition-overlay" id="overlay"></div>

<div class="yes-loading-screen hidden" id="yesLoadingScreen">
  <div class="yes-loading-text">Setting up your profile</div>
</div>

<div class="scene-wrapper">
  
<!-- REGISTER TERMINAL DEVICE (left side) -->
<div class="register-terminal">
  <div class="register-device-top">
<div class="light-indicator red" id="light-red"></div>
<div class="light-indicator yellow" id="light-yellow"></div>
<div class="light-indicator green" id="light-green"></div>
  </div>

  <div class="register-device-screen">
    <div class="register-box">
      <h2>REGISTER FixQuest</h2>
      <form method="POST" action="{{ route('register') }}">
        @csrf

        <label>Nama</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
        @error('name') <div class="error">{{ $message }}</div> @enderror

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email') <div class="error">{{ $message }}</div> @enderror

        <label>Password</label>
        <input type="password" name="password" required>
        @error('password') <div class="error">{{ $message }}</div> @enderror

        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" required>

        <label>Role</label>
        <select name="role" required>
          <option value="">-- Pilih Role --</option>
          <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="teknisi" {{ old('role') == 'teknisi' ? 'selected' : '' }}>Teknisi</option>
        </select>
        @error('role') <div class="error">{{ $message }}</div> @enderror

        <label id="token-label">Token (Khusus Admin)</label>
<input type="text" name="token" id="token-input" placeholder="Isi jika memilih Admin">

        <button type="submit">DAFTAR</button>
        <a href="{{ route('landing') }}" class="back">← Kembali ke halaman awal</a>
      </form>
    </div>
  </div>

  <div class="register-device-stand"></div>
</div>


  <!-- MONITOR (right side) -->
  <div class="pixel-monitor">
    <div class="monitor-screen">
      <div class="screen-header">FixQuest System Register</div>
      <div class="screen-content">
@if ($errors->any())
  {{-- Any error (token or general) --}}
  <img src="{{ asset('img/mascot sad.png') }}" alt="Sad Mascot" class="mascot">
@else
  {{-- Default mascot --}}
  <img src="{{ asset('img/mascot clipboard.png') }}" alt="Fox Mascot" class="mascot">
@endif

<div class="speech-bubble">
  @if ($errors->has('token'))
    {{ $errors->first('token') }}
  @elseif ($errors->any())
    Uh OH! Ada yang tidak beres. 
    Silakan periksa Input Anda dan coba lagi.
  @else
    Selamat Datang! <br>
    Silakan register untuk melanjutkan.
  @endif
</div>


      </div>
    </div>
    <div class="monitor-stand"></div>
    <div class="monitor-table"></div>
  </div>

</div>

<!-- Floor stays outside -->
<div class="pixel-floor"></div>


  <!-- AUDIO -->
  <audio id="whooshSound" src="{{ asset('audio/transition.mp3') }}" preload="auto"></audio>
  <audio id="clickSound" src="{{ asset('audio/click.mp3') }}" preload="auto"></audio>
  <audio id="redLightSound" src="{{ asset('audio/error.mp3') }}" preload="auto"></audio>
<audio id="yellowLightSound" src="{{ asset('audio/progress.mp3') }}" preload="auto"></audio>
<audio id="greenLightSound" src="{{ asset('audio/success.mp3') }}" preload="auto"></audio>


<script>
  const overlay = document.getElementById('overlay');
  const whoosh = document.getElementById('whooshSound');
  const clickSound = document.getElementById('clickSound');

  // Light sounds
  const redSound = document.getElementById('redLightSound');
  const yellowSound = document.getElementById('yellowLightSound');
  const greenSound = document.getElementById('greenLightSound');

  // Token show/hide based on role
  const roleSelect = document.querySelector('select[name="role"]');
  const tokenInput = document.getElementById('token-input');
  const tokenLabel = document.getElementById('token-label');

  // Light indicators
  const redLight = document.getElementById('light-red');
  const yellowLight = document.getElementById('light-yellow');
  const greenLight = document.getElementById('light-green');

  // Helper to reset lights
  function resetLights() {
    redLight.style.background = '#444';
    yellowLight.style.background = '#444';
    greenLight.style.background = '#444';
    redLight.classList.remove('blink');
    yellowLight.classList.remove('blink');
    greenLight.classList.remove('blink');
  }

window.addEventListener('load', () => {
  // Overlay intro transition
  requestAnimationFrame(() => {
    overlay.classList.add("active");
    whoosh.play();

    setTimeout(() => {
      overlay.classList.remove("active");
      document.querySelector(".scene-wrapper").classList.add("show");
    }, 1000);
  });

    // ✅ Show/hide token input based on role
    const isAdmin = roleSelect.value === 'admin';
    tokenInput.classList.toggle('show', isAdmin);
    tokenLabel.classList.toggle('show', isAdmin);

    roleSelect.addEventListener('change', () => {
      const isAdmin = roleSelect.value === 'admin';
      tokenInput.classList.toggle('show', isAdmin);
      tokenLabel.classList.toggle('show', isAdmin);
    });

    // ✅ Token error sound/light
    @if ($errors->has('token'))
      resetLights();
      redLight.style.background = '#ff4d4d';
      redLight.classList.add('blink');
      redSound.play();
      setTimeout(() => redLight.classList.remove('blink'), 2000);
    @endif

    // ✅ General error (for other fields)
    const hasErrors = document.querySelectorAll('.error').length > 0;
    if (hasErrors && !@json($errors->has('token'))) {
      resetLights();
      redLight.style.background = '#ff4d4d';
      redLight.classList.add('blink');
      redSound.play();
      setTimeout(() => redLight.classList.remove('blink'), 2000);
    }
  });

  // ✅ Back button transition
  const backLink = document.querySelector('a.back');
  backLink.addEventListener('click', function(e) {
    e.preventDefault();
    overlay.classList.add('active');
    whoosh.play();
    setTimeout(() => {
      window.location.href = backLink.href;
    }, 1000);
  });

  // ✅ Register form animation
  const form = document.querySelector('form');
  form.addEventListener('submit', function (e) {
    e.preventDefault(); // prevent immediate submission
    resetLights();

    clickSound.play(); 

    // Step 1: Red blink
    redLight.classList.add('blink');
    redLight.style.background = '#ff4d4d';
    yellowSound.play();
    
    setTimeout(() => {
      redLight.classList.remove('blink');
      redLight.style.background = '#444';

      // Step 2: Yellow blink
      yellowLight.style.background = '#ffcc00';
      yellowLight.classList.add('blink');
      yellowSound.play();
    }, 1000);

    setTimeout(() => {
      yellowLight.classList.remove('blink');
      yellowLight.style.background = '#444';

      // Step 3: Green blink
      greenLight.style.background = '#33cc33';
      greenLight.classList.add('blink');
      greenSound.play();

      // Show loading screen
      const loadingScreen = document.getElementById("yesLoadingScreen");
      loadingScreen.classList.remove("hidden");
      void loadingScreen.offsetWidth;
      loadingScreen.classList.add("visible");
    }, 1500);

    // ✅ Final delay before real submit
    setTimeout(() => {
      greenLight.classList.remove('blink');
      form.submit(); // submit after animation
    }, 4000);
  });
</script>




</body>

</html>
