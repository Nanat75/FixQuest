<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NotaExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NotaController extends Controller
{
    // Export by selected month
    public function exportByMonth(Request $request)
    {
        $month = $request->input('month'); // format: YYYY-MM

        if (!$month) {
            return back()->with('error', 'Bulan harus dipilih!');
        }

        // Split into year and month
        [$year, $monthNumber] = explode('-', $month);

        $notas = Nota::whereYear('tanggal_masuk', $year)
                    ->whereMonth('tanggal_masuk', $monthNumber)
                    ->orderBy('tanggal_masuk', 'asc')
                    ->get();

        if ($notas->isEmpty()) {
            return back()->with('error', 'Tidak ada data pada bulan tersebut.');
        }

        $fileName = "notas_{$year}_{$monthNumber}.xlsx";
        return Excel::download(new NotaExport($notas), $fileName);
    }

    // Teknisi index with search + filter
public function teknisiIndex(Request $request)
{
    $query = Nota::query();

    // Only load data if any filter is used
    if ($request->filled('keyword') || $request->filled('status') || $request->filled('month')) {

        // Keyword search
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_unit', 'like', '%' . $request->keyword . '%')
                  ->orWhere('nama_driver', 'like', '%' . $request->keyword . '%')
                  ->orWhere('kerusakan', 'like', '%' . $request->keyword . '%');
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Month filter
        if ($request->filled('month')) {
            [$year, $month] = explode('-', $request->month);
            $query->whereYear('tanggal_masuk', $year)
                  ->whereMonth('tanggal_masuk', $month);
        }

        $notas = $query->orderBy('created_at', 'desc')->get();
    } else {
        // If no filter, return empty collection
        $notas = collect(); // Empty collection
    }

    return view('dashboard.teknisi', compact('notas'));
}


    // Admin index with same logic
   public function adminIndex(Request $request)
{
    $query = Nota::query();

    // Only load data if any filter is used
    if ($request->filled('keyword') || $request->filled('status') || $request->filled('month')) {

        // Keyword search
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_unit', 'like', '%' . $request->keyword . '%')
                  ->orWhere('nama_driver', 'like', '%' . $request->keyword . '%')
                  ->orWhere('kerusakan', 'like', '%' . $request->keyword . '%');
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Month filter
        if ($request->filled('month')) {
            [$year, $month] = explode('-', $request->month);
            $query->whereYear('tanggal_masuk', $year)
                  ->whereMonth('tanggal_masuk', $month);
        }

        $notas = $query->orderBy('created_at', 'desc')->get();
    } else {
        // If no filter, return empty collection
        $notas = collect(); // Empty collection
    }

    return view('dashboard.admin', compact('notas'));
}
// Store new Nota
public function store(Request $request)
{
    $validated = $request->validate([
        'tanggal_masuk' => ['required', 'date'],
        'kode_unit'     => ['required', 'string', 'max:255'],
        'nama_driver'   => ['required', 'string', 'max:255'],
        'status'        => ['required', 'in:Belum,Dalam Proses,Selesai'],
        'kerusakan'     => ['required','array','min:1'],
        'kerusakan.*'   => ['required','string','max:1000'],
        'harga'         => ['required','array','min:1'],
        'harga.*'       => ['required','numeric','min:0'],
    ]);

    // Combine into items
    $items = [];
    $total = 0;
    foreach ($validated['kerusakan'] as $i => $k) {
        $h = isset($validated['harga'][$i]) ? (float)$validated['harga'][$i] : 0;
        $items[] = [
            'kerusakan' => $k,
            'qty'       => 1, // default
            'harga'     => $h
        ];
        $total += $h;
    }

    // === Generate sequential "no" ===

$lastNota = Nota::orderBy('created_at', 'desc')->first();
if ($lastNota && is_numeric($lastNota->no)) {
    $seq = (int) $lastNota->no + 1;
} else {
    $seq = 1;
}
$newNo = str_pad($seq, 2, '0', STR_PAD_LEFT);

    // ================================

    $nota = new Nota();
    $nota->no            = $newNo; // assign the sequential number
    $nota->tanggal_masuk = $validated['tanggal_masuk'];
    $nota->kode_unit     = $validated['kode_unit'];
    $nota->nama_driver   = $validated['nama_driver'];
    $nota->status        = $validated['status'];

    // Compatibility: keep flat columns too
    $nota->kerusakan = implode(', ', array_map(fn($it) => $it['kerusakan'], $items));
    $nota->harga     = $total;

    $nota->items     = $items; // auto-casted to JSON
    $nota->save();

    return back()->with('success', 'Nota berhasil disimpan.');
}



    // Export all data
   public function export()
{
    $notas = Nota::orderBy('created_at', 'desc')->get();
    return Excel::download(new NotaExport($notas), 'laporan_nota.xlsx');
}


    // Update Nota
 public function update(Request $request, Nota $nota)
    {
        $validated = $request->validate([
            'tanggal_masuk' => ['required', 'date'],
            'kode_unit'     => ['required', 'string', 'max:255'],
            'nama_driver'   => ['required', 'string', 'max:255'],
            'status'        => ['required', 'in:Belum,Dalam Proses,Selesai'],
            'kerusakan'     => ['required','array','min:1'],
            'kerusakan.*'   => ['required','string','max:1000'],
            'harga'         => ['required','array','min:1'],
            'harga.*'       => ['required','numeric','min:0'],
        ]);

        $items = [];
        $total = 0;
        foreach ($validated['kerusakan'] as $i => $k) {
            $h = isset($validated['harga'][$i]) ? (float)$validated['harga'][$i] : 0;
            $items[] = [
              'kerusakan' => $k,
              'qty'       => 1, // default
              'harga'     => $h
];

            $total += $h;
        }

        $nota->tanggal_masuk = $validated['tanggal_masuk'];
        $nota->kode_unit     = $validated['kode_unit'];
        $nota->nama_driver   = $validated['nama_driver'];
        $nota->status        = $validated['status'];

        $nota->kerusakan = implode(', ', array_map(fn($it) => $it['kerusakan'], $items));
        $nota->harga     = $total;

        $nota->items     = $items;
        $nota->save();

        return back()->with('success', 'Nota berhasil diperbarui.');
    }

    public function printAll()
{
    $notas = Nota::orderBy('tanggal_masuk', 'asc')->get();
    return view('notas.print', compact('notas'));
}

public function printOverlay($no)
{
    $nota = Nota::findOrFail($no);

    // Ambil dari kolom JSON items
    $items = $nota->items ?? [];

    // Pastikan qty default 1
    foreach ($items as &$item) {
        if (!isset($item['qty'])) {
            $item['qty'] = 1;
        }
    }
    unset($item);

    return view('notas.print_overlay', compact('nota', 'items'));
}

public function printListByMonth(Request $request)
{
    $month = $request->input('month'); // format: YYYY-MM
    if (!$month) {
        return back()->with('error', 'Bulan harus dipilih!');
    }

    [$year, $monthNumber] = explode('-', $month);

    $notas = Nota::whereYear('tanggal_masuk', $year)
                ->whereMonth('tanggal_masuk', $monthNumber)
                ->orderBy('tanggal_masuk', 'asc')
                ->get();

    if ($notas->isEmpty()) {
        return back()->with('error', 'Tidak ada data pada bulan tersebut.');
    }

    return view('notas.print', compact('notas', 'month'));
}

}



