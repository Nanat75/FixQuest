<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>FixQuest | Login</title>
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



  .transition-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: #ffffff;
    opacity: 0;
    transition: opacity 0.5s ease;
    z-index: 9999;
    pointer-events: none;
  }

  .transition-overlay.active {
    opacity: 1;
  }

.scene-wrapper {
  display: flex;
  gap: 80px;
  align-items: flex-end; /* you can change this if needed */
  justify-content: center;
  margin-bottom: 60px;
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 1s ease, transform 1s ease;
  z-index: 5;
}


  .scene-wrapper.show {
    opacity: 1;
    transform: translateY(0);
  }


  /* Mascot Box */
.pixel-monitor {
  width: 450px;
  background: #111;
  border: 10px solid #333;
  border-radius: 12px 12px 6px 6px;
  box-shadow: 0 0 20px #000;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 40px;
  position: relative;
}

.pixel-monitor .monitor-screen {
  background: radial-gradient(circle at center, #000 60%, #111 100%);
  width: 100%;
  height: 260px;
  padding: 12px;
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  border-bottom: 4px solid #222;
  position: relative;
  overflow: hidden;
}

.pixel-monitor .monitor-screen::after {
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

.pixel-monitor .screen-header {
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

.pixel-monitor .screen-content {
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


.pixel-monitor .screen-content img {
  width: 210px;
    height: auto;
  margin-top: 70px;
}

.pixel-monitor .speech-bubble {
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
  left: -40px;   
  top: 60px;

}

.pixel-monitor .speech-bubble::after {
  content: "";
  position: absolute;
  left: -10px;
  top: 20px;
  width: 0;
  height: 0;
  border: 8px solid transparent;
  border-right-color: #fff;
}


.pixel-monitor .monitor-stand {
  width: 60px;
  height: 25px;
  background: #333;
  border: 4px solid #000;
  border-radius: 2px;
  margin-top: 4px;
}


  .mascot-scene {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
  }

  .mascot-terminal {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.monitor-table {
  width: 800px;
  height: 20px;
  background: #a97d4d;
  border: 4px solid #000;
  box-shadow: inset 0 -4px 0 #754c29, 4px 4px 0 #000;
  border-radius: 4px;
  margin-top: -4px; /* connect visually to monitor */
}

  .pixel-desk {
    width: 180px;
    height: 40px;
    background: #d3a762;
    border: 4px solid #000;
    box-shadow: inset 0 -6px 0 #a97d4d, 4px 4px 0 #000;
    border-radius: 4px;
    margin-top: -10px;
    z-index: 2;
  }

  .speech-bubble {
    margin-top: 16px;
    background: #fff;
    border: 2px solid #000;
    border-radius: 10px;
    padding: 12px;
    color: #000;
    font-size: 10px;
    line-height: 1.5;
    text-align: center;
    box-shadow: 3px 3px 0 #000;
    position: relative;
    max-width: 200px;
  }

  .speech-bubble::after {
    content: "";
    position: absolute;
    left: 30%;
    transform: translateX(-50%);
    top: -8px;
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-bottom: 8px solid #fff;
  }

  /* Login Form */
.form-container {
    background: #002244;
    border: 6px solid #000000;
    box-shadow: 6px 6px 0 #000;
    padding: 30px;
    border-radius: 10px;
    position: relative;
    margin-bottom: 40px;      
    margin-top: 40px;         
    margin-left: 120px;        
}

  .login-box {
    color: #fff;
    width: 400px;
    height: 400px;
  }

.login-box h2 {
  text-align: center;
  color: #ffd700;
  margin-bottom: 24px;
  font-size: 16px;
  border-bottom: 2px dashed #ffd700;
  padding-bottom: 10px;
  text-shadow: 1px 1px #000;
}

  label {
    font-size: 12px;
    color: #ffd700;
    margin-bottom: 4px;
    display: block;
  }

  input {
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

.tool-shelf {
  display: flex;
  justify-content: center;
  align-items: flex-end;
  gap: 20px;
  background: #000000; 
  border: 4px solid #000;
  box-shadow: inset 0 -6px 0 #5a5a5a, 4px 4px 0 #000;
  padding: 10px 20px;
  margin-top: 35px;
  border-radius: 4px;
  position: relative;
  width: 360px;
  margin-left: auto;
  margin-right: auto;
}

.boot-progress-container {
  position: relative;
  width: 200px;
  height: 20px;
  background: #222;
  border: 4px solid #000;
  box-shadow: inset 0 -4px 0 #555, 3px 3px 0 #000;
  border-radius: 4px;
  overflow: hidden;
}

.boot-progress-bar {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  background: repeating-linear-gradient(
    45deg,
    #ffd700 0 10px,
    #ffaa00 10px 20px
  );
  width: 0%;
}

@keyframes boot-progress {
  from { width: 0%; }
  to { width: 100%; }
}

.boot-progress-text {
  display: block;
  margin-top: 8px;
  margin-left: 10px; /* 👈 adjust this to move it left/right */
  font-size: 11px;
  color: #fff;
  text-shadow: 1px 1px #000;
  text-align: left;
  width: 100%;
}


@keyframes dots {
  0%   { content: "."; }
  33%  { content: ".."; }
  66%  { content: "..."; }
  100% { content: "."; }
}

.loading-dots::after {
  content: ".";
  animation: dots 1s steps(1, end) infinite;
}

.mascot-image {
  margin-top: -140px;           
  margin-left: 220px;            
  margin-right: auto;
  width: fit-content;          
  position: relative;         
}

.mascot-image img {
  width: 170px;                 
  max-width: 100%;
  height: auto;
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


<body>
  <div class="transition-overlay"></div>

<div class="yes-loading-screen hidden" id="yesLoadingScreen">
  <div class="yes-loading-text">Preparing your Dashboard</div>
</div>

  <div class="pixel-floor"></div>
<div class="scene-wrapper">
<!-- 🦊 Fox inside Pixel Monitor -->
<div class="pixel-monitor">
  <div class="monitor-screen">
    <div class="screen-header">FixQuest System Login</div>
    <div class="screen-content">
  @if ($errors->has('login'))
  <img src="{{ asset('img/mascot sad.png') }}" alt="Sad Mascot" class="mascot">
@else
  <img src="{{ asset('img/mascot talk.png') }}" alt="Fox Mascot" class="mascot">
@endif


     <div class="speech-bubble">
  @if ($errors->has('login'))
    {{ $errors->first('login') }}
  @else 
    Selamat datang kembali! <br>
    Silakan Login untuk melanjutkan.
  @endif
</div>

    </div>
  </div>
  <div class="monitor-stand"></div>
  <div class="monitor-table"></div>
</div>



  <!-- 🔐 Login Terminal -->

  <div class="form-container">
    <div class="login-box">
      <h2>LOGIN FixQuest</h2>
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <label>Email</label>
        <input type="email" name="email" required value="{{ old('email') }}">
        @error('email')<div class="error">{{ $message }}</div>@enderror

        <label>Password</label>
        <input type="password" name="password" required>
        @error('password')<div class="error">{{ $message }}</div>@enderror

        <button type="submit">START</button>
        <a href="{{ route('landing') }}" class="back">← Kembali ke halaman awal</a>
        
<!-- Progress Bar (separated from tool shelf) -->
<div class="boot-progress-container" style="margin: 20px auto 10px; width: 400px; top: 60px">
  <div class="boot-progress-bar"></div>
</div>
<span class="boot-progress-text">System Booting<span class="loading-dots"></span></span>


<div class="tool-shelf">
</div>

<div class="mascot-image">
  <img src="{{ asset('img/mascot sleep.png') }}" alt="Toolbox">
</div>

      </form>
    </div>
  </div>
</div>


  <audio id="whooshSound" src="{{ asset('audio/transition.mp3') }}" preload="auto"></audio>
  <audio id="tingSound" src="{{ asset('audio/ding.mp3') }}" preload="auto"></audio>
  <audio id="clickSound" src="{{ asset('audio/click.mp3') }}" preload="auto"></audio>
<audio id="progressSound" src="{{ asset('audio/progress.mp3') }}" preload="auto"></audio>


<script>
  window.onload = () => {
    const overlay = document.querySelector(".transition-overlay");
    const whoosh = document.getElementById("whooshSound");
    overlay.classList.add("active");
    whoosh.play();

    setTimeout(() => {
      overlay.classList.remove("active");
      document.querySelector(".scene-wrapper").classList.add("show");
    }, 1000);

    // === LOGIN PROGRESS ===
    const emailInput = document.querySelector('input[name="email"]');
    const passwordInput = document.querySelector('input[name="password"]');
    const progressBar = document.querySelector('.boot-progress-bar');
    const bootText = document.querySelector('.boot-progress-text');
    const form = document.querySelector('form');
    const ting = document.getElementById("tingSound");
    const loadingScreen = document.querySelector(".yes-loading-screen");

    const clickSound = document.getElementById("clickSound");
    const progressSound = document.getElementById("progressSound"); // <-- Add this line

    let progress = 0;

    progressBar.style.transition = 'width 0.9s ease';

    function updateProgress() {
      let newProgress = 0;
      if (emailInput.value.trim()) newProgress += 40;
      if (passwordInput.value.trim()) newProgress += 40;
      
      // Play progress sound only if it increases
      if (newProgress > progress) progressSound.play(); // <-- Play progress sound

      progress = newProgress;
      progressBar.style.width = `${progress}%`;
    }

    emailInput.addEventListener('input', updateProgress);
    passwordInput.addEventListener('input', updateProgress);

    form.addEventListener('submit', function(e) {
      clickSound.play();

      if (progress < 80) return e.preventDefault();

      e.preventDefault(); // prevent default submit

      const stages = [
        { text: "Verifying Email…", width: 85 },
        { text: "Authorizing…", width: 92 },
        { text: "Loading Dashboard…", width: 100 }
      ];

      let delay = 0;

      stages.forEach((stage, i) => {
        setTimeout(() => {
          bootText.innerHTML = stage.text + '<span class="loading-dots"></span>';
          progressBar.style.width = stage.width + '%';

          progressSound.play(); // <-- Play during staged progress

          if (i === stages.length - 1) {
            ting.play(); 

            setTimeout(() => {
              loadingScreen.classList.remove("hidden"); 
              void loadingScreen.offsetWidth; 
              loadingScreen.classList.add("visible"); 
            }, 1500); 

            setTimeout(() => {
              form.submit(); 
            }, 1800);
          }
        }, delay);
        delay += 1300;
      });
    });

    // === BACK BUTTON CLICK SOUND ===
const backLink = document.querySelector('a.back');
backLink.addEventListener('click', function(e) {
  e.preventDefault();

  overlay.classList.add("active");
  whoosh.play();

  setTimeout(() => {
    window.location.href = backLink.href;
  }, 1000); 
});

  };
</script>



</body>
</html>
