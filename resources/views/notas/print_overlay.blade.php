<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Nota #{{ $nota->no ?? $nota->id }}</title>
  <style>
    :root{ --pad:12mm; --line:#000; }
    @media print {
      @page { size: A4 portrait; margin: 10mm; }
      body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
      .no-print { display: none !important; }
    }
    html, body { margin:0; padding:0; font-family: Arial, Helvetica, sans-serif; }
    .sheet   { width: 210mm; min-height: 297mm; margin: 0 auto; padding: var(--pad); box-sizing: border-box; }
    .head    { display:flex; justify-content: space-between; align-items:flex-start; margin-bottom: 10mm; }
    .brand   { text-align:left; }
    .brand h1{ margin:0; font-size: 20pt; letter-spacing: .5pt; }
    .brand small{ display:block; margin-top:2mm; font-size:10pt; color:#444; }

    .meta    { border:1.5px solid var(--line); border-radius:6px; padding:4mm 6mm; width: 70mm; font-size:10pt; }
    .meta .row { display:flex; justify-content:space-between; margin-bottom:2mm; }
    .meta .row:last-child { margin-bottom:0; }
    .label  { color:#333; margin-right:6mm; white-space:nowrap; }

    .section-title { font-weight:bold; margin: 2mm 0 3mm; }

    table { width:100%; border-collapse: collapse; }
    th, td { border: 1px solid var(--line); padding: 5px 6px; font-size: 10pt; }
    th { text-align:center; }
    td { vertical-align: top; }
    .text-right { text-align:right; }
    .text-center{ text-align:center; }

    /* Footer area */
    .footer-area { display:flex; gap:10mm; margin-top: 8mm; }
    .left-note { flex:1; font-size:9pt; border:1px solid var(--line); padding:4mm; }
    .signs { width: 90mm; display:flex; justify-content:space-between; gap:6mm; }
    .sign { width: 44mm; text-align:center; font-size:10pt; }
    .dots { border-top: 1px dotted var(--line); margin-top: 22mm; }

    /* Totals box */
    .totals { margin-top: 6mm; display:flex; justify-content:flex-end; }
    .totals table { width: 70mm; }
    .totals th, .totals td { font-size:10pt; }
  </style>
</head>
<body onload="window.print()">
  <div class="sheet">

    <div class="head">
      <div class="brand">
        <h1>NOTA FAKTUR</h1>
        <small>(Nama Toko • Alamat Toko)</small>
      </div>

      <div class="meta">
        <div class="row"><span class="label">Nomor</span><span>: {{ $nota->no ?? $nota->id }}</span></div>
        <div class="row"><span class="label">Tanggal</span>
          <span>: {{ \Carbon\Carbon::parse($nota->tanggal_masuk)->translatedFormat('d F Y') }}</span></div>
        <div class="row"><span class="label">Kepada</span><span>: {{ $nota->nama_driver }}</span></div>
        <div class="row"><span class="label">Kode unit</span><span>: {{ $nota->kode_unit }}</span></div>
      </div>
    </div>

    <div class="section-title">NOTA FAKTUR :</div>

@php
    $maxRows = 10;
    $items = is_array($nota->items) ? $nota->items : json_decode($nota->items, true);
    $subtotal = $nota->harga ?? 0; // langsung ambil total harga dari DB
@endphp


    <table>
      <thead>
        <tr>
          <th style="width:14mm">No.</th>
          <th>Kerusakan / Barang</th>
          <th style="width:26mm">Qty</th>
          <th style="width:30mm">Harga (Rp.)</th>
          <th style="width:32mm">Jumlah (Rp.)</th>
        </tr>
      </thead>
      <tbody>
@if(is_array($items))
    @foreach($items as $index => $item)
        @php
            $lineTotal = ($item['qty'] ?? 0) * ($item['harga'] ?? 0);
        @endphp
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $item['kerusakan'] ?? '' }}</td>
            <td class="text-center">{{ $item['qty'] ?? '' }}</td>
            <td class="text-right">{{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($lineTotal, 0, ',', '.') }}</td>
        </tr>
    @endforeach
@endif


        {{-- Empty filler rows --}}
        @for($i = count($nota->items ?? []); $i < $maxRows; $i++)
          <tr>
            <td>&nbsp;</td><td></td><td></td><td></td><td></td>
          </tr>
        @endfor
      </tbody>
    </table>

   <div class="totals">
    <table>
        <tr>
            <th>Total</th>
            <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
        </tr>
    </table>
</div>

    <div class="footer-area">
      <div class="left-note">
        Barang yang sudah dibeli tidak dapat dikembalikan / ditukar kecuali ada perjanjian terlebih dahulu.
      </div>

      <div class="signs">
        <div class="sign">
          Yang Memesan
          <div class="dots"></div>
        </div>
        <div class="sign">
          Terima kasih
          <div class="dots"></div>
        </div>
      </div>
    </div>

    <div class="no-print" style="margin-top:8mm;">
      <button onclick="window.print()">Cetak lagi</button>
    </div>
  </div>
</body>
</html>
