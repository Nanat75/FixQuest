@extends('layouts.pixel')

@section('content')
 <div class="transition-overlay"></div>
<div class="dashboard-container">

<!-- 🎮 Pixel-style Title Area -->
<div class="pixel-title-bar">
    <span class="title-text">Fix Quest</span>

    <!-- 🎵 Background Music Control -->
    <div class="music-control">
        <audio id="bg-music" loop autoplay>
    <source src="{{ asset('audio/background.mp3') }}" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>
       <div class="pixel-music-container">
    <button id="music-toggle" class="pixel-music-btn">
        🔊
    </button>
</div>
    </div>

    <span class="user-name">
        @auth
            | {{ Auth::user()->name }}
        @endauth
    </span>
</div>

    @if(session('success'))
  <div class="alert-success" id="successAlert">
    ✅ {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div class="alert-error" id="errorAlert">
    ❌ {{ session('error') }}
  </div>
@endif


    <!-- 🧱 Floor appears here -->
    <div class="pixel-floor"></div>

  <!-- 🔹 Door (Top Left) -->
  <img src="{{ asset('img/door1.png') }}" alt="Exit" class="icon door" onclick="confirmExit()">

    <img src="{{ asset('img/mascot print.png') }}"
     alt="print"
     class="icon print"
     onclick="playClickSound(); openPrintMenu()">

       <!-- Print choice modal -->
<div class="pixel-modal" id="printChoiceModal" style="display:none;">
  <div class="pixel-modal-content">
    <h3>Pilih Jenis Print</h3>

    <!-- Speech bubble -->
    <div class="speech-bubble">
      Pilih jenis print yang kamu butuhkan~
    </div>

    <!-- Buttons -->
    <div class="btn-row">
      <button type="button" onclick="openPrintNotaOverlayModal()">
        🖨️ Print 1 Nota (Template)
      </button>
    </div>

    <div style="margin-top:10px;">
      <button type="button" class="btn-cancel" onclick="playClickSound(); closePrintMenu()">Tutup</button>
    </div>

  <!-- Mascot -->
  <div class="mascot-box1">
    <div class="mascot1"></div>
     </div>

  </div>
</div>

<!-- Ask for Nota ID modal -->
<div class="pixel-modal" id="printNotaIdModal" style="display:none;">
  <div class="pixel-modal-content">
    <h3>Print Nota (Template)</h3>

    <div class="speech-bubble">
      Masukkan ID nota yang mau diprint~
    </div>

    <div class="form-group">
      <label for="print_nota_id">Masukkan ID Nota:</label>
      <input type="number" id="print_nota_id" placeholder="Contoh: 01">
    </div>

    <div class="btn-row2">
      <button type="button" onclick="doPrintNotaOverlay()">Print</button>
      <button type="button" class="btn-cancel" onclick="playClickSound(); closePrintNotaId()">Batal</button>
    </div>
  </div>
</div>


<div class="omori-dialog">
  <div class="dialog-box">
    <div class="character-column">
      <img src="{{ asset('img/teknisi2.png') }}" class="dialog-portrait" />
    </div>
    <div class="dialog-content">
      <div class="dialog-text" id="dialogText">
Selamat datang di FixQuest, Teknisi! Ingin tur singkat tentang fitur sistem?
      </div>
      <div class="dialog-options">
        <button onclick="playClickSound(); handleOption('ya')"> Ya</button>

        <button onclick="playClickSound(); handleOption('tidak')"> Tidak</button>
      </div>
    </div>
  </div>
</div>


  <!-- 🔹 Main Interactive Area -->
  <div class="interaction-area">
    <!-- PC -->
    <img src="{{ asset('img/computer1.png') }}" alt="Computer" class="icon pc" onclick="openNotaMenu()">
    
    <!-- Modal menu -->
    <div class="modal" id="notaModal">
      <div class="modal-content">
        <h3>Menu Nota</h3>
        <button onclick="openFormNota()">📝 Form Nota Digital</button>
        <button onclick="playClickSound(); closeNotaMenu()">❌ Close</button>
      </div>
    </div>
  </div>

<!-- 📥 Form Nota Modal -->
<div class="modal" id="formNotaModal" style="display: none;">
  <div class="modal-content">
    <h3 class="modal-title">📝 Input Nota</h3>
    <form id="notaForm" method="POST" action="{{ route('notas.store') }}">
      @csrf

      <div class="form-group">
        <label for="tanggal_masuk">Tanggal Masuk:</label>
        <input type="date" name="tanggal_masuk" id="tanggal_masuk" required>
      </div>

      <div class="form-group">
        <label for="kode_unit">Kode Unit:</label>
        <input type="text" name="kode_unit" id="kode_unit" required>
      </div>

      <div class="form-group">
        <label for="nama_driver">Nama Driver:</label>
        <input type="text" name="nama_driver" id="nama_driver" required>
      </div>

    <!-- 🔧 Kerusakan & Harga (multi) -->
<div class="form-group kerusakan-harga-group">
  <label>Kerusakan & Harga:</label>

  <div id="items_container" class="kerusakan-items">
    <!-- initial row -->
    <div class="kerusakan-row">
      <input type="text"   name="kerusakan[]" placeholder="Kerusakan" required>
      <input type="number" name="harga[]"     placeholder="Harga"     required>
      <button type="button" onclick="removeItemRow(this)">❌</button>
    </div>
  </div>

  <div class="kerusakan-add-btn">
    <button type="button" onclick="addItemRow('items_container')">+ Tambah Kerusakan</button>
  </div>
</div>

<div class="form-group">
  <label>Total (auto):</label>
  <input type="number" id="total_harga" name="total_preview" value="0" readonly>
</div>


      <div class="form-group" style="display:none;">
        <!-- server expects total in 'harga' column -->
        <input type="hidden" id="total_harga_hidden" name="harga[]">
      </div>

      <div class="form-group">
        <label for="status">Status:</label>
        <select name="status" id="status" required>
          <option value="Belum" {{ old('status') == 'Belum' ? 'selected' : '' }}>❌ Belum</option>
          <option value="Dalam Proses" {{ old('status') == 'Dalam Proses' ? 'selected' : '' }}>🔧 Proses</option>
          <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>✅ Selesai</option>
        </select>
      </div>

      <div class="btn-row">
        <button type="submit" class="btn-save" onclick="syncTotalsBeforeSubmit('items_container','total_harga','total_harga_hidden')">✅ Simpan</button>
        <button type="button" class="btn-cancel" onclick="playClickSound(); closeFormNota()">❌ Batal</button>
      </div>
    </form>
  </div>
</div>

<!-- 🚪 Custom Exit Confirmation Box -->
<div id="exitConfirmBox" class="pixel-exit-box hidden">
  <p class="exit-question">Yakin ingin keluar dari sistem?</p>
  <div class="exit-buttons">
    <button onclick="exitSystem()">Ya</button>
    <button onclick="playClickSound(); closeExitBox()"> Tidak</button>
  </div>
</div>


  <!-- 🔹 Dashboard Board -->
<div class="dashboard-board popout-shadow">
  <h3 class="dashboard-title"> Dashboard</h3>

  <form method="GET" action="{{ url()->current() }}" class="filter-form">
    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder=" Cari data..." />
    <select name="status">
      <option value="">Semua</option>
      <option value="Belum" {{ request('status') == 'Belum' ? 'selected' : '' }}>❌ Belum</option>
      <option value="Dalam Proses" {{ request('status') == 'Dalam Proses' ? 'selected' : '' }}>🔧 Proses</option>
      <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>✅ Selesai</option>
    </select>

    <!-- 📅 Filter by Month -->
  <input type="month" name="month" value="{{ request('month') }}" />

    <button type="submit" class="btn-search">Cari</button>
  </form>


    <!-- 📋 Nota List -->
   
  <div class="scrollable-data">
    @forelse ($notas as $nota)
      <div class="data-box animated-card">
        <small>{{ $nota->tanggal_masuk }}</small><br>
        <b>ID:</b><strong> {{ $nota->no }}</strong><br>
        <b>Unit:</b> {{ $nota->kode_unit }}<br>
        <b>Driver:</b> {{ $nota->nama_driver }}<br>
        <b>Kerusakan:</b> {{ $nota->kerusakan }}<br>
        <b>Status:</b> 
       @if($nota->status == 'Belum') Belum
       @elseif($nota->status == 'Dalam Proses') Proses
       @elseif($nota->status == 'Selesai') Selesai
       @else ⚠️ Unknown
       @endif
        <br>
      </div>
  @empty
  @if (!request()->hasAny(['keyword', 'status', 'month']))
    <p>🔍 Gunakan filter atau cari sesuatu untuk melihat data.</p>
  @else
    <p>❌ Tidak ada data ditemukan dengan filter saat ini.</p>
  @endif
@endforelse

  </div>
</div>

  </div>
</div>

 <audio id="whooshSound" src="{{ asset('audio/transition.mp3') }}" preload="auto"></audio>
 <audio id="clickSound" src="{{ asset('audio/click.mp3') }}" preload="auto"></audio>
 <audio id="modalOpenSound" src="{{ asset('audio/modal.mp3') }}" preload="auto"></audio>

@endsection

@push('scripts')
<script>
function openNotaMenu() {
  const modal = document.getElementById('notaModal');
  modal.classList.remove('closing', 'hidden');
  modal.classList.add('show');
  playModalSound();
}

function closeNotaMenu() {
  const modal = document.getElementById('notaModal');
  modal.classList.remove('show');
  modal.classList.add('closing');
  setTimeout(() => {
    modal.classList.add('hidden');
  }, 300); 
}

function confirmExit() {
  playClickSound();
  const exitBox = document.getElementById('exitConfirmBox');
  exitBox.classList.remove('hidden', 'closing');
  exitBox.classList.add('show');
}

function closeExitBox() {
  const exitBox = document.getElementById('exitConfirmBox');
  exitBox.classList.remove('show');
  exitBox.classList.add('closing');

  setTimeout(() => {
    exitBox.classList.add('hidden');
    exitBox.classList.remove('closing');
  }, 300); // match tv-off animation duration
}

function exitSystem() {
  const overlay = document.querySelector(".transition-overlay");
  const whoosh = document.getElementById("whooshSound");

  overlay.classList.add("hidden");
  overlay.style.display = "block";
  void overlay.offsetWidth;
  overlay.classList.remove("hidden");
  whoosh.play();

  setTimeout(() => {
    window.location.href = "{{ route('landing') }}";
  }, 1000);
}

function handleOption(option) {
  playClickSound();
  const dialogText = document.getElementById('dialogText');
  const dialogOptions = document.querySelector('.dialog-options');

  const dialogMap = {
 ya: {
  text: "Bagus! Ayo mulai hari ini dengan semangat! Mau aku jelaskan fitur-fitur sistem ini?",
  options: [
    { label: " Input Nota", value: "fitur_input" },
    { label: " Print Nota", value: "fitur_print" },
    { label: " Dashboard", value: "fitur_dashboard" },
    { label: " Logout/Keluar", value: "keluar" },
    { label: " Selesai", value: "tidak" },
  ]
},
    tidak: {
      text: "Ok! Kalau berubah pikiran, klik tombol di bawah ini ya untuk lihat fitur kembali.",
      options: [
        { label: "Tampilkan Penjelasan", value: "ya" }
      ]
    },
    fitur_input: {
 text: "📌 Klik komputer, lalu pilih <strong>Form Nota Digital</strong> untuk mulai membuat nota.\n\n📝 <strong>Input Nota:</strong>\n - Masukkan informasi kendaraan seperti No Nota, Tanggal Masuk, Kode Unit, Nama Driver, dan detail Kerusakan.\n\n - Kamu juga dapat memilih status pengerjaan: Belum, Dalam Proses, atau Selesai.",
  options: [{ label: " Kembali", value: "reset" }]
},

fitur_print: {
  text: "🖨️ <strong>Print Satu Nota:</strong>\n\nJika ingin mencetak, klik maskot <strong>Riki</strong> di sebelah kanan layar. Setelah diklik, pilih opsi <strong>Print Satu Nota</strong>.\n\n - Fitur ini akan mencetak hanya satu nota sesuai dengan ID yang dipilih.\n\nTips: Pastikan printer sudah terhubung sebelum mencetak.",
  options: [{ label: " Kembali", value: "reset" }]
},


fitur_dashboard: {
  text: "📊 <strong>Dashboard & Pencarian:</strong>\nMenampilkan daftar seluruh nota.\n\n- Kamu bisa mencari nota berdasarkan Kode Unit, Nama Driver, Status, atau memfilter berdasarkan bulan tertentu.",
  options: [{ label: " Kembali", value: "reset" }]
},

keluar: {
  text: "🚪 <strong>Keluar dari Sistem:</strong><br>Jika kamu sudah selesai menggunakan sistem ini, kamu bisa keluar dengan menekan pintu yang ada di sebelah kiri layar.",
  options: [
    { label: " Kembali", value: "reset" }
  ]
},


 reset: {
  text: "Oke! Silakan pilih fitur yang ingin kamu pelajari lagi:",
  options: [
    { label: " Input Nota", value: "fitur_input" },
    { label: " Print Nota", value: "fitur_print" },
    { label: " Dashboard", value: "fitur_dashboard" },
    { label: " Logout/Keluar", value: "keluar" },
    { label: " Selesai", value: "tidak" },
  ]
}
  };

  const current = dialogMap[option] || {
    text: "🤖 Pilihan tidak dikenali.",
    options: [{ label: "🔁 Kembali", value: "reset" }]
  };


  // Format text for final HTML then type plain text safely
typeDialogText(current.text.replace(/\n/g, "<br>"));

  // Clear and recreate options
  dialogOptions.innerHTML = "";
  current.options.forEach(opt => {
    const btn = document.createElement('button');
    btn.className = 'option-btn';
    btn.textContent = opt.label;
    btn.onclick = () => handleOption(opt.value);
    dialogOptions.appendChild(btn);
  });
}


function openFormNota() {
  playClickSound();
  console.log("FormNota triggered!");
  const modal = document.getElementById('formNotaModal');
  modal.classList.remove('closing', 'hidden');
  modal.classList.add('show');
}

function closeFormNota() {
  const modal = document.getElementById('formNotaModal');
  modal.classList.remove('show');
  modal.classList.add('closing');

  setTimeout(() => {
    modal.classList.remove('closing');
    modal.classList.add('hidden');
  }, 300); // ⏳ Match this duration to your `@keyframes tv-off` time
}


setTimeout(() => {
  const alert = document.getElementById('successAlert');
  if (alert) alert.style.display = 'none';

  const error = document.getElementById('errorAlert');
  if (error) error.style.display = 'none';
}, 5000); // Hide after 5 seconds

  window.addEventListener("DOMContentLoaded", function () {
    const fadeInElement = document.querySelector(".fade-in-container");
    if (fadeInElement) {
      fadeInElement.classList.add("visible");
    }
  });

    window.onload = () => {
  const overlay = document.querySelector(".transition-overlay");
  const whoosh = document.getElementById("whooshSound");

  void overlay.offsetWidth;
  playModalSound(); // Play sound first
  overlay.classList.add("hidden");

  // Optional: completely remove overlay after fade-out
  setTimeout(() => {
    overlay.style.display = "none";
  }, 1000); // Must match the transition time in CSS
};

function playClickSound() {
  const click = document.getElementById("clickSound");
  if (click) click.play();
}

function playModalSound() {
  const modalSound = document.getElementById("modalOpenSound");
  if (modalSound) modalSound.play();
}

 window.addEventListener('load', () => {
    const dialog = document.querySelector('.omori-dialog');
    if (dialog) {
      dialog.classList.add('pop-in');
      dialog.style.pointerEvents = 'auto'; // re-enable interactions if needed
    }
  });

   
// --- typing helpers ---
let _typingTimer = null;
let _typingInProgress = false;

function stripHtml(html) {
  const tmp = document.createElement('div');
  tmp.innerHTML = html;
  return tmp.textContent || tmp.innerText || '';
}

function typeDialogText(htmlString, speed = 30, callback) {
  const el = document.getElementById('dialogText');
  if (!el) return;

  // cancel previous typing
  if (_typingTimer) {
    clearTimeout(_typingTimer);
    _typingTimer = null;
  }

  _typingInProgress = true;
  // Disable option buttons while typing
  setDialogOptionsEnabled(false);

  // normalize: replace \n with <br> for the final HTML, but produce plain text for typing
  const htmlWithBr = htmlString.replace(/\n/g, '<br>');
  const plain = stripHtml(htmlWithBr).replace(/\r/g, '');

  el.textContent = '';                 // type into textContent (safe)
  el.style.whiteSpace = 'pre-wrap';    // preserve newlines while typing

  let i = 0;
  function tick() {
    if (i < plain.length) {
      el.textContent += plain.charAt(i);
      i++;
      _typingTimer = setTimeout(tick, speed);
    } else {
      // finished typing -> set final HTML (allow <strong>, emojis, <br> etc.)
      el.innerHTML = htmlWithBr;
      _typingInProgress = false;
      setDialogOptionsEnabled(true);
      if (callback) callback();
    }
  }
  tick();
}

function setDialogOptionsEnabled(enabled) {
  const opts = document.querySelectorAll('.dialog-options button, .dialog-options .option-btn');
  opts.forEach(b => b.disabled = !enabled);
}


function shakeDialog() {
  const dialogText = document.getElementById('dialogText');
  dialogText.classList.add('shake');
  setTimeout(() => dialogText.classList.remove('shake'), 400);
}

function calcTotal(containerId, totalInputId) {
  const c = document.getElementById(containerId);
  const totalInput = document.getElementById(totalInputId);
  let sum = 0;
  c.querySelectorAll('input[name="harga[]"]').forEach(inp => {
    const v = parseFloat(inp.value);
    if (!isNaN(v)) sum += v;
  });
  if (totalInput) totalInput.value = Math.round(sum);
}

function syncTotalsBeforeSubmit(containerId, totalId, hiddenId) {
  calcTotal(containerId, totalId);
  const totalInput = document.getElementById(totalId);
  const hidden = document.getElementById(hiddenId);
  if (hidden) hidden.value = totalInput ? totalInput.value : 0;
}

// Basic HTML escaper to avoid breaking attributes when injecting
function escapeHtml(s) {
  return String(s)
    .replace(/&/g,'&amp;')
    .replace(/"/g,'&quot;')
    .replace(/</g,'&lt;')
    .replace(/>/g,'&gt;');
}

// --- open 'Tambah Nota' prefills ---
document.addEventListener('DOMContentLoaded', ()=>{
  // ensure 1 starter row in "Tambah Nota" is present and wired
  calcTotal('items_container','total_harga');
});


function addItemRow(containerId, data = { kerusakan: '', harga: '' }) {
  const c = document.getElementById(containerId);
  const row = document.createElement('div');
  row.className = 'kerusakan-row';
  row.style.display = 'flex';
  row.style.flexDirection = 'row'; // 👈 keep inputs in one row
  row.style.gap = '8px';
  row.style.alignItems = 'center';

  row.innerHTML = `
    <input type="text"   name="kerusakan[]" placeholder="Kerusakan" required style="flex:2;" value="${escapeHtml(data.kerusakan ?? '')}">
    <input type="number" name="harga[]"     placeholder="Harga"     required style="flex:1;" value="${data.harga ?? ''}">
    <button type="button" onclick="removeItemRow(this)">❌</button>
  `;

  c.appendChild(row);

  // recalc when inputs change
  const inputs = row.querySelectorAll('input[name="harga[]"]');
  inputs.forEach(inp => inp.addEventListener('input', () => {
    if (containerId === 'items_container') calcTotal('items_container', 'total_harga');
    if (containerId === 'edit_items_container') calcTotal('edit_items_container', 'edit_total_harga');
  }));
}

function removeItemRow(btn) {
  const container = btn.closest('.kerusakan-row').parentElement.id;
  btn.parentElement.remove();
  if (container === 'items_container') calcTotal('items_container', 'total_harga');
  if (container === 'edit_items_container') calcTotal('edit_items_container', 'edit_total_harga');
}

// --- PRINT MENU LOGIC ---

function openPrintMenu() {
  const m = document.getElementById('printChoiceModal');
  m.classList.remove('closing', 'hidden'); m.style.display = 'block';
  m.classList.add('show');
  playModalSound();
}
function closePrintMenu() {
  const m = document.getElementById('printChoiceModal');
  m.classList.remove('show'); m.classList.add('closing');
  setTimeout(() => { m.classList.remove('closing'); m.style.display = 'none'; }, 300);
}

function openPrintNotaOverlayModal() {
  closePrintMenu();
  const m = document.getElementById('printNotaIdModal');
  m.classList.remove('closing', 'hidden'); m.style.display = 'block';
  m.classList.add('show');
  playModalSound();
}
function closePrintNotaId() {
  const m = document.getElementById('printNotaIdModal');
  m.classList.remove('show'); m.classList.add('closing');
  setTimeout(() => { m.classList.remove('closing'); m.style.display = 'none'; }, 300);
}

function doPrintNotaOverlay() {
  const no = (document.getElementById('print_nota_id').value || '').trim();
  if (!no) { alert('Masukkan Nomor Nota dulu ya.'); return; }

  const templateUrl = "{{ route('notas.print.overlay', ['no' => 'NO_PLACEHOLDER']) }}";
  const url = templateUrl.replace('NO_PLACEHOLDER', encodeURIComponent(no));

  window.open(url, '_blank');
}

document.addEventListener("DOMContentLoaded", function () {
    const audio = document.getElementById("bg-music");
    const btn = document.getElementById("music-toggle");

    // Restore mute state from localStorage
    let isMuted = localStorage.getItem("bg-music-muted") === "true";
    audio.muted = isMuted;
    btn.textContent = isMuted ? "🔇" : "🔊";

    btn.addEventListener("click", function () {
        audio.muted = !audio.muted;
        localStorage.setItem("bg-music-muted", audio.muted);
        btn.textContent = audio.muted ? "🔇" : "🔊";
    });
});


</script>
@endpush
