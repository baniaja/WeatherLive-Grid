<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Rekapan Meteorologi BMKG Jawa Barat — WeatherLive-Grid</title>
<style>
  @page { size: A4; margin: 15mm; }
  body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #1e293b; background: #fff; margin: 0; padding: 24px; font-size: 12px; line-height: 1.5; }
  .header { display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #0284c7; padding-bottom: 16px; margin-bottom: 20px; }
  .logo-block { display: flex; align-items: center; gap: 14px; }
  .logo-icon { width: 52px; height: 52px; background: #0284c7; color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 26px; font-weight: bold; }
  .logo-text h1 { margin: 0; font-size: 18px; color: #0f172a; font-weight: 800; letter-spacing: -0.5px; }
  .logo-text p { margin: 2px 0 0; font-size: 11px; color: #64748b; font-weight: 500; }
  .doc-meta { text-align: right; font-size: 11px; color: #475569; }
  .badge { display: inline-block; padding: 3px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
  .badge-active { background: #dcfce7; color: #15803d; }
  .badge-danger { background: #fee2e2; color: #b91c1c; }
  .badge-warning { background: #fef3c7; color: #b45309; }
  h2 { font-size: 14px; color: #0284c7; margin: 24px 0 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 6px; font-weight: 700; }
  table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 11px; }
  th { background: #f1f5f9; color: #334155; font-weight: 700; text-align: left; padding: 8px 10px; border: 1px solid #cbd5e1; }
  td { padding: 7px 10px; border: 1px solid #e2e8f0; color: #334155; }
  tr:nth-child(even) { background: #f8fafc; }
  .summary-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
  .summary-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; text-align: center; }
  .summary-val { font-size: 22px; font-weight: 800; color: #0284c7; margin-bottom: 2px; }
  .summary-lbl { font-size: 10px; color: #64748b; font-weight: 600; text-transform: uppercase; }
  .footer { margin-top: 36px; padding-top: 14px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; font-size: 10px; color: #94a3b8; }
  .print-btn { position: fixed; top: 16px; right: 16px; background: #0284c7; color: white; padding: 10px 18px; border-radius: 8px; font-weight: 700; cursor: pointer; border: none; font-size: 13px; box-shadow: 0 4px 12px rgba(2,132,199,0.3); }
  @media print { .print-btn { display: none; } body { padding: 0; } }
</style>
</head>
<body>

<button class="print-btn" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>

<div class="header">
  <div class="logo-block">
    <div class="logo-icon">🌤️</div>
    <div class="logo-text">
      <h1>BADAN METEOROLOGI, KLIMATOLOGI, DAN GEOFISIKA</h1>
      <p>Stasiun Pemantauan Wilayah II Jawa Barat · WeatherLive-Grid Enterprise 2.0</p>
    </div>
  </div>
  <div class="doc-meta">
    <div><strong>No. Laporan:</strong> WL-BMKG-{{ date('Ymd-His') }}</div>
    <div><strong>Waktu Terbit:</strong> {{ now()->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB</div>
    <div><strong>Status:</strong> Dokumen Resmi Terverifikasi</div>
  </div>
</div>

<div class="summary-grid">
  <div class="summary-card">
    <div class="summary-val">{{ $stations->count() }}</div>
    <div class="summary-lbl">Stasiun Cuaca</div>
  </div>
  <div class="summary-card">
    <div class="summary-val">{{ $alerts->where('status','active')->count() }}</div>
    <div class="summary-lbl">Peringatan Aktif</div>
  </div>
  <div class="summary-card">
    <div class="summary-val">{{ $sensors->count() }}</div>
    <div class="summary-lbl">Sensor IoT Atmosfer</div>
  </div>
  <div class="summary-card">
    <div class="summary-val">{{ $users->count() }}</div>
    <div class="summary-lbl">Pengguna Terdaftar</div>
  </div>
</div>

<h2>1. Daftar Stasiun Cuaca Aktif (Jawa Barat)</h2>
<table>
  <thead>
    <tr>
      <th style="width:40px;">#</th>
      <th>Nama Stasiun</th>
      <th>Kode Stasiun</th>
      <th>Wilayah / Lokasi</th>
      <th>Koordinat (Lat, Lng)</th>
      <th>Tipe</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @forelse($stations as $index => $st)
    <tr>
      <td>{{ $index + 1 }}</td>
      <td><strong>{{ $st->name }}</strong></td>
      <td><code>{{ $st->code }}</code></td>
      <td>{{ $st->location?->name ?? 'Jawa Barat' }}</td>
      <td>{{ $st->latitude }}, {{ $st->longitude }}</td>
      <td>{{ $st->type ?? 'AWS' }}</td>
      <td><span class="badge {{ $st->status === 'active' ? 'badge-active' : 'badge-warning' }}">{{ $st->status }}</span></td>
    </tr>
    @empty
    <tr><td colspan="7" style="text-align:center;">Tidak ada data stasiun cuaca.</td></tr>
    @endforelse
  </tbody>
</table>

<h2>2. Rekapan Peringatan Dini Cuaca Ekstrem Terkini</h2>
<table>
  <thead>
    <tr>
      <th style="width:40px;">#</th>
      <th>Judul Peringatan</th>
      <th>Tipe Bencana</th>
      <th>Keparahan</th>
      <th>Wilayah Cakupan</th>
      <th>Status</th>
      <th>Berlaku Hingga</th>
    </tr>
  </thead>
  <tbody>
    @forelse($alerts as $index => $al)
    <tr>
      <td>{{ $index + 1 }}</td>
      <td><strong>{{ $al->title }}</strong></td>
      <td>{{ $al->alert_type }}</td>
      <td>
        <span class="badge {{ in_array($al->severity, ['extreme','danger']) ? 'badge-danger' : 'badge-warning' }}">
          {{ strtoupper($al->severity) }}
        </span>
      </td>
      <td>{{ $al->location?->name ?? 'Seluruh Jawa Barat' }}</td>
      <td>{{ ucfirst($al->status) }}</td>
      <td>{{ $al->effective_until ? $al->effective_until->format('d/m/Y H:i') : 'Selesai Penanganan' }}</td>
    </tr>
    @empty
    <tr><td colspan="7" style="text-align:center;">Tidak ada data peringatan aktif saat ini. Kondisi aman.</td></tr>
    @endforelse
  </tbody>
</table>

<h2>3. Data Pengguna & Otorisasi Sistem</h2>
<table>
  <thead>
    <tr>
      <th style="width:40px;">#</th>
      <th>Nama Lengkap</th>
      <th>Email</th>
      <th>Role / Hak Akses</th>
      <th>Status Akun</th>
      <th>Terdaftar</th>
    </tr>
  </thead>
  <tbody>
    @forelse($users as $index => $u)
    <tr>
      <td>{{ $index + 1 }}</td>
      <td><strong>{{ $u->name }}</strong></td>
      <td>{{ $u->email }}</td>
      <td>{{ $u->role?->name ?? 'Masyarakat' }}</td>
      <td><span class="badge {{ $u->is_active ? 'badge-active' : 'badge-danger' }}">{{ $u->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
      <td>{{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}</td>
    </tr>
    @empty
    <tr><td colspan="6" style="text-align:center;">Tidak ada data pengguna.</td></tr>
    @endforelse
  </tbody>
</table>

<div class="footer">
  <div>Dokumen resmi WeatherLive-Grid v3.0 · BMKG Jawa Barat. Digenerate secara otomatis oleh Admin Command Center 2.0.</div>
  <div>Halaman 1 dari 1</div>
</div>

</body>
</html>
