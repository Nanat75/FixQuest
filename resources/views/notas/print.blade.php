<!DOCTYPE html>
<html>
<head>
    <title>Daftar Nota Bulan {{ $month }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body onload="window.print()">
    <h2>Daftar Nota - Bulan {{ $month }}</h2>
   
      <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Tanggal Masuk</th>
        <th>Kode Unit</th>
        <th>Driver</th>
        <th>Kerusakan</th>
        <th>Status</th>
        <th>Total Harga</th>
      </tr>
    </thead>
    <tbody>
      @foreach($notas as $i => $nota)
      <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ \Carbon\Carbon::parse($nota->tanggal_masuk)->format('d-m-Y') }}</td>
        <td>{{ $nota->kode_unit }}</td>
        <td>{{ $nota->nama_driver }}</td>
        <td>{{ $nota->kerusakan }}</td>
        <td>{{ $nota->status }}</td>
        <td>{{ number_format($nota->harga, 0, ',', '.') }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>