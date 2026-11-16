<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class StametServiceController extends Controller
{
    /**
     * Data master layanan khusus STAMET (Stasiun Meteorologi BMKG)
     */
    public static function getServicesCatalog(): array
    {
        return [
            [
                'id' => 1,
                'slug' => 'cuaca-penerbangan',
                'code' => 'STAMET-AV-01',
                'title' => 'Layanan Dokumen Cuaca Penerbangan (Flight Documentation)',
                'short_title' => 'Cuaca Penerbangan (METAR / TAF)',
                'icon' => 'fa-plane-departure',
                'category' => 'aviasi',
                'category_label' => 'Aviasi & Bandara',
                'badge' => '24/7 Operasional',
                'badge_color' => '#38bdf8',
                'tariff_type' => 'pnbp',
                'tariff_label' => 'Sesuai PP PNBP BMKG / Rp 0 untuk Militer & SAR',
                'sla' => 'Real-time (H-2 jam sebelum ETD)',
                'deliverable' => 'Flight Folder / Dokumen Digital Ber-QR Code',
                'legal_basis' => 'UU No. 1 Tahun 2009 tentang Penerbangan & ICAO Annex 3 Meteorological Service for International Air Navigation.',
                'target_applicants' => 'Maskapai Penerbangan, Pilot, Flight Operation Officer (FOO), Operator Bandara / Helipad, AirNav Indonesia.',
                'summary' => 'Penyediaan dokumen briefing cuaca penerbangan rute domestik dan internasional meliputi pengamatan rutin METAR, laporan cuaca mendadak SPECI, prakiraan aerodrome TAF, peringatan fenomena bahaya SIGMET, peta angin dan suhu udara atas WAFS (Wind-Temp Chart), serta Aerodrome Warning.',
                'requirements' => [
                    'Formulir permohonan briefing cuaca penerbangan resmi dari maskapai / operator.',
                    'Identitas resmi pemohon (Lisensi FOO / Lisensi Pilot / Kartu Tanda Anggota Maskapai).',
                    'Flight Plan lengkap meliputi Call Sign, registrasi pesawat, rute penerbangan, bandara alternatif (alternate aerodrome), dan Estimated Time of Departure (ETD).',
                    'Bukti penyelesaian administrasi PNBP jasa navigasi/cuaca aviasi (kecuali penerbangan dinas kenegaraan, SAR, militer, atau penerbangan kemanusiaan darurat).'
                ],
                'flow_steps' => [
                    [
                        'step' => 1,
                        'title' => 'Pengajuan Flight Plan & Jadwal',
                        'desc' => 'FOO atau kru penerbang mengajukan jadwal keberangkatan dan rute via sistem briefing online Stamet atau Ruang Briefing Meteorologi Bandara H-2 jam sebelum take-off.'
                    ],
                    [
                        'step' => 2,
                        'title' => 'Analisis Forecaster Stamet',
                        'desc' => 'Forecaster on duty Stamet menganalisis dinamika atmosfer rute terbang, citra satelit cuaca, radar cuaca Doppler, peta angin atas WAFS, dan potensi turbulensi atau icing.'
                    ],
                    [
                        'step' => 3,
                        'title' => 'Penerbitan Flight Folder',
                        'desc' => 'Dokumen Flight Documentation diterbitkan secara resmi dengan validasi QR-Code digital atau cetak resmi stempel dinas Stasiun Meteorologi.'
                    ],
                    [
                        'step' => 4,
                        'title' => 'Briefing & Penyerahan Berkas',
                        'desc' => 'Penjelasan lisan briefing cuaca rute oleh forecaster dan penandatanganan formulir tanda terima dokumen penerbangan.'
                    ]
                ],
                'template_doc' => [
                    'title' => 'Formulir Permohonan Dokumen Cuaca Penerbangan',
                    'content' => "FORMULIR PERMOHONAN DOKUMEN CUACA PENERBANGAN (FLIGHT DOCUMENTATION)\nKepada Yth. Kepala Stasiun Meteorologi Kelas I BMKG\n\nNama Pemohon / FOO: [Nama Lengkap]\nNomor Lisensi FOO / Pilot: [Nomor Lisensi]\nMaskapai / Operator: [Nama Maskapai / General Aviation]\nNomor Penerbangan: [Contoh: GA-123 / PK-ABC]\nRute Penerbangan: [Bandara Asal] -> [Bandara Tujuan]\nBandara Alternatif: [Alternate Aerodrome]\nEstimated Time of Departure (ETD): [Tanggal & Jam UTC]\nKebutuhan Dokumen: [ ] METAR/TAF [ ] WAFS Wind-Temp [ ] SIGMET [ ] En-route Weather"
                ],
                'faqs' => [
                    [
                        'q' => 'Berapa lama masa berlaku prakiraan cuaca TAF?',
                        'a' => 'TAF (Terminal Aerodrome Forecast) diterbitkan oleh Stasiun Meteorologi dengan periode validitas 24 jam atau 30 jam, dan diperbarui secara berkala setiap 6 jam (pukul 00, 06, 12, 18 UTC) atau diterbitkan TAF AMD jika terjadi perubahan signifikan.'
                    ],
                    [
                        'q' => 'Bagaimana bila terjadi perubahan cuaca buruk mendadak di bandara?',
                        'a' => 'Stasiun Meteorologi akan segera mengeluarkan laporan cuaca khusus SPECI dan peringatan cuaca bandara (Aerodrome Warning / Windshear Alert) yang langsung didistribusikan ke tower ATC AirNav dan operator penerbangan.'
                    ],
                    [
                        'q' => 'Apakah penerbangan darurat medis atau SAR dikenakan tarif?',
                        'a' => 'Tidak. Berdasarkan peraturan perundangan BMKG, penerbangan penanggulangan bencana, pencarian dan pertolongan (SAR), misi kemanusiaan medis darurat, serta penerbangan kenegaraan (VVIP/Militer) dibebaskan dari tarif PNBP (Tarif Rp 0,-).'
                    ]
                ],
                'whatsapp_draft' => 'Halo Petugas Pelayanan Stamet BMKG, saya ingin mengajukan konsultasi/permohonan terkait Layanan Dokumen Cuaca Penerbangan (Flight Documentation). Mohon informasinya. Terima kasih.'
            ],
            [
                'id' => 2,
                'slug' => 'cuaca-khusus-event',
                'code' => 'STAMET-EV-02',
                'title' => 'Layanan Informasi Cuaca Khusus Kegiatan / Event Luar Ruang',
                'short_title' => 'Cuaca Khusus Event & Proyek Outdoor',
                'icon' => 'fa-calendar-check',
                'category' => 'event',
                'category_label' => 'Event & Luar Ruang',
                'badge' => 'Mikro Lokasi',
                'badge_color' => '#f59e0b',
                'tariff_type' => 'pnbp',
                'tariff_label' => 'Sesuai PP Tarif PNBP BMKG Jasa Khusus',
                'sla' => '1 - 2 Hari Kerja sebelum acara',
                'deliverable' => 'Buletin Prakiraan Cuaca Mikro Per Jam & Grup Koordinasi Nowcasting',
                'legal_basis' => 'Peraturan Pemerintah No. 47 Tahun 2018 tentang Jenis dan Tarif atas Jenis PNBP yang Berlaku pada BMKG.',
                'target_applicants' => 'Event Organizer (EO), Panitia Konser / Festival Musik, Pengurus Acara Olahraga (PON / Maraton), Instansi Pemerintah, Kontraktor Konstruksi Luar Ruangan.',
                'summary' => 'Prakiraan cuaca spesifik mikro dengan resolusi per jam di titik koordinat acara outdoor. Sangat penting untuk memitigasi risiko keselamatan panggung, peralatan tata suara, kerumunan penonton, dan jadwal rangkaian acara dari potensi hujan lebat, kilat/petir, serta hembusan angin kencang.',
                'requirements' => [
                    'Surat permohonan resmi bertanda tangan pimpinan panitia / direktur perusahaan pengaju.',
                    'Rundown lengkap acara dan jadwal kegiatan (tanggal dan jam dimulainya hingga berakhirnya acara).',
                    'Titik koordinat lokasi acara yang presisi (Koordinat GPS Latitude dan Longitude tempat kegiatan berlangsung).',
                    'Fotokopi KTP / Identitas penanggung jawab acara.',
                    'Bukti pembayaran PNBP kas negara melalui kode billing SIMPONI BMKG.'
                ],
                'flow_steps' => [
                    [
                        'step' => 1,
                        'title' => 'Surat Permohonan & Koordinat Lokasi',
                        'desc' => 'Pemohon mengirimkan surat permohonan resmi dilampiri rundown acara dan titik koordinat GPS ke PTSP Stamet minimal H-3 sebelum acara dimulai.'
                    ],
                    [
                        'step' => 2,
                        'title' => 'Verifikasi & Penerbitan Kode Billing PNBP',
                        'desc' => 'Petugas PTSP Stamet menghitung tarif PNBP resmi sesuai regulasi dan menerbitkan kode billing SIMPONI untuk disetor ke kas negara.'
                    ],
                    [
                        'step' => 3,
                        'title' => 'Pembayaran PNBP',
                        'desc' => 'Pemohon menyetor pembayaran PNBP melalui teller bank, ATM, atau mobile banking (M-Banking) dan mengirimkan bukti transfer.'
                    ],
                    [
                        'step' => 4,
                        'title' => 'Penerbitan Buletin & Pendampingan Cuaca',
                        'desc' => 'Forecaster Stamet menerbitkan buletin prakiraan cuaca per jam serta memberikan update cuaca mendadak (nowcasting) selama acara berlangsung.'
                    ]
                ],
                'template_doc' => [
                    'title' => 'Contoh Surat Permohonan Informasi Cuaca Khusus Event',
                    'content' => "KOP SURAT PANITIA / INSTANSI\nNomor: ... / PAN / ... / 2026\nPerihal: Permohonan Informasi Prakiraan Cuaca Khusus Kegiatan\n\nKepada Yth.\nKepala Stasiun Meteorologi Kelas I BMKG\n\nDengan hormat,\nSehubungan dengan rencana pelaksanaan kegiatan:\nNama Acara: [Contoh: Festival Musik Budaya Jabar 2026]\nHari / Tanggal: [Tanggal Pelaksanaan]\nWaktu: [Jam Mulai] s.d. [Jam Selesai] WIB\nLokasi Acara: [Nama Tempat / Alamat Lengkap]\nTitik Koordinat: Lat [...], Long [...]\nJumlah Peserta: [Estimasi Jumlah Orang]\n\nKami bermaksud mengajukan permohonan penyediaan informasi prakiraan cuaca khusus (per jam) untuk kelancaran dan keselamatan kegiatan kami.\nDemikian surat permohonan ini kami sampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.\n\n[Kota, Tanggal]\nKetua Panitia Pelaksana,\n\n(Tanda Tangan & Stempel)\n[Nama Lengkap & No. HP]"
                ],
                'faqs' => [
                    [
                        'q' => 'Berapa hari paling lambat surat permohonan diajukan sebelum acara?',
                        'a' => 'Surat permohonan disarankan diajukan minimal H-3 atau H-5 hari kerja sebelum tanggal pelaksanaan kegiatan agar tim forecaster Stamet dapat menganalisis perkembangan dinamika atmosfer dan pergerakan awan konvektif secara akurat.'
                    ],
                    [
                        'q' => 'Apakah pemohon mendapatkan pembaruan live saat acara berlangsung?',
                        'a' => 'Ya. Tim forecaster Stamet menyediakan pemantauan radar cuaca aktif dan dapat memberikan update peringatan dini kilat (nowcasting) langsung ke kontak panitia atau WhatsApp koordinator keselamatan acara.'
                    ]
                ],
                'whatsapp_draft' => 'Halo Petugas Pelayanan Stamet BMKG, saya panitia event ingin berkonsultasi mengenai Layanan Informasi Cuaca Khusus Kegiatan Luar Ruang. Mohon panduan alur dan persyaratannya. Terima kasih.'
            ],
            [
                'id' => 3,
                'slug' => 'data-penelitian-gratis',
                'code' => 'STAMET-EDU-03',
                'title' => 'Layanan Data Historis Cuaca untuk Riset & Skripsi Mahasiswa',
                'short_title' => 'Data Riset & Skripsi (Gratis Rp 0,-)',
                'icon' => 'fa-graduation-cap',
                'category' => 'akademis',
                'category_label' => 'Riset & Pendidikan',
                'badge' => 'GRATIS (Rp 0,-)',
                'badge_color' => '#22c55e',
                'tariff_type' => 'free',
                'tariff_label' => 'Rp 0,- (GRATIS Berdasarkan Perka BMKG)',
                'sla' => '1 - 3 Hari Kerja setelah berkas diverifikasi',
                'deliverable' => 'File Dataset Historis (Excel / CSV Resmi Bertanda Tangan Digital)',
                'legal_basis' => 'Peraturan Kepala BMKG No. 12 Tahun 2019 tentang Tata Cara Pengenaan Tarif Rp 0,- atas Jenis PNBP untuk Kegiatan Pendidikan dan Penelitian Non-Komersial.',
                'target_applicants' => 'Mahasiswa D3, S1, S2, S3, Guru, Dosen, serta Peneliti Lembaga Pendidikan Terakreditasi.',
                'summary' => 'Penyediaan rekaman data meteorologi historis stasiun (curah hujan harian/jam, suhu udara rata-rata/min/max, kelembapan relatif, arah & kecepatan angin, penyinaran matahari, serta tekanan udara) untuk keperluan penulisan Tugas Akhir, Skripsi, Tesis, Disertasi, atau Riset Akademis murni.',
                'requirements' => [
                    'Kartu Tanda Mahasiswa (KTM) atau Kartu Tanda Pengenal Dosen yang masih berlaku.',
                    'Surat Pengantar Resmi dari Dekan Fakultas / Ketua Program Studi / Kepala Lembaga Penelitian dengan kop surat resmi kampus.',
                    'Proposal penelitian / sinopsis ringkas yang memuat judul penelitian, parameter data yang dibutuhkan, lokasi stasiun meteorologi, dan rentang tahun pengamatan.',
                    'Surat Pernyataan Kesanggupan bermaterai Rp 10.000 untuk: (1) Menggunakan data semata-mata untuk riset non-komersial, (2) Mencantumkan BMKG sebagai sumber data, dan (3) Menyerahkan 1 salinan hasil karya ilmiah ke perpustakaan Stamet.'
                ],
                'flow_steps' => [
                    [
                        'step' => 1,
                        'title' => 'Persiapan Berkas Kampus',
                        'desc' => 'Mahasiswa menyiapkan Surat Pengantar dari Dekan/Kaprodi dan ringkasan proposal penelitian yang mencantumkan parameter data yang diminta.'
                    ],
                    [
                        'step' => 2,
                        'title' => 'Verifikasi Berkas PTSP Stamet',
                        'desc' => 'Petugas PTSP Stamet memverifikasi keabsahan surat pengantar dan memastikan kesesuaian parameter data dengan stasiun pengamatan.'
                    ],
                    [
                        'step' => 3,
                        'title' => 'Penetapan Tarif Rp 0,- (Bebas PNBP)',
                        'desc' => 'Petugas menerbitkan penetapan tarif Rp 0,- sesuai Perka BMKG untuk pendidikan dan penelitian ilmiah.'
                    ],
                    [
                        'step' => 4,
                        'title' => 'Ekstraksi & Penyerahan Dataset',
                        'desc' => 'Tim data Stamet mengekstrak dataset dari pangkalan data meteorologi dan menyerahkan file CSV/Excel resmi ber-QR Code via email/download.'
                    ]
                ],
                'template_doc' => [
                    'title' => 'Format Surat Pengantar Kampus untuk Permohonan Data Cuaca',
                    'content' => "KOP SURAT FAKULTAS / UNIVERSITAS\nNomor: ... / UN / FT / ... / 2026\nLampiran: 1 (satu) Berkas Proposal\nPerihal: Permohonan Data Meteorologi untuk Penyusunan Skripsi / Tesis\n\nKepada Yth.\nKepala Stasiun Meteorologi Kelas I BMKG\n\nDengan hormat,\nBersama surat ini kami menerangkan bahwa mahasiswa di bawah ini:\nNama Lengkap: [Nama Mahasiswa]\nNomor Induk Mahasiswa (NIM): [NIM]\nProgram Studi / Jurusan: [Contoh: Teknik Lingkungan / Sipil / Geografi]\nFakultas / Universitas: [Nama Kampus]\n\nSedang melaksanakan penelitian tugas akhir / skripsi dengan judul:\n\"[Tuliskan Judul Skripsi / Penelitian Secara Lengkap]\"\n\nUntuk keperluan analisis tersebut, kami memohon bantuan perkenan Bapak/Ibu memberikan data meteorologi Stasiun Meteorologi Kelas I BMKG berupa:\n1. Parameter Data: [Contoh: Curah Hujan Harian, Suhu Rata-rata, Kelembapan]\n2. Periode Data: [Contoh: Tahun 2018 - 2025]\n3. Stasiun: [Nama Stasiun Meteorologi]\n\nData tersebut murni digunakan untuk kepentingan akademis non-komersial. Mahasiswa bersangkutan sanggup mematuhi ketentuan BMKG.\nDemikian permohonan ini kami sampaikan. Atas bantuan dan kerjasama Bapak/Ibu, kami sampaikan terima kasih.\n\n[Kota, Tanggal]\nDekan / Ketua Program Studi,\n\n(Tanda Tangan & Cap Fakultas)\n[Nama Pejabat & NIP]"
                ],
                'faqs' => [
                    [
                        'q' => 'Apakah mahasiswa benar-benar tidak dipungut biaya apapun?',
                        'a' => 'BENAR, 100% GRATIS (Tarif Rp 0,-). Berdasarkan Peraturan Kepala BMKG No. 12 Tahun 2019, permohonan data cuaca untuk kepentingan penelitian tugas akhir, skripsi, tesis, dan disertasi mahasiswa dibebaskan sepenuhnya dari tarif PNBP.'
                    ],
                    [
                        'q' => 'Berapa tahun rentang data historis cuaca yang dapat diperoleh?',
                        'a' => 'Umumnya mahasiswa dapat mengajukan rentang data historis antara 5 hingga 10 tahun terakhir sesuai kebutuhan metode statistik atau pemodelan hidrologi yang diajukan dalam proposal skripsi.'
                    ],
                    [
                        'q' => 'Berapa lama proses verifikasi hingga data diterima?',
                        'a' => 'Jika dokumen surat pengantar kampus dan proposal lengkap, data diproses dalam waktu 1 hingga 3 hari kerja dan dikirim langsung ke alamat email pemohon.'
                    ]
                ],
                'whatsapp_draft' => 'Halo Petugas Pelayanan Stamet BMKG, saya mahasiswa ingin mengajukan permohonan data historis cuaca untuk keperluan skripsi/penelitian (Tarif Rp 0,-). Mohon arahan verifikasi berkasnya. Terima kasih.'
            ],
            [
                'id' => 4,
                'slug' => 'asuransi-hukum',
                'code' => 'STAMET-FOR-04',
                'title' => 'Layanan Analisis Cuaca Ekstrem untuk Asuransi & Keterangan Hukum',
                'short_title' => 'Keterangan Cuaca Asuransi & Hukum',
                'icon' => 'fa-shield-halved',
                'category' => 'legal',
                'category_label' => 'Legal & Asuransi',
                'badge' => 'Forensic Weather',
                'badge_color' => '#ef4444',
                'tariff_type' => 'pnbp',
                'tariff_label' => 'Sesuai PP PNBP BMKG Jasa Informasi Khusus',
                'sla' => '2 - 3 Hari Kerja',
                'deliverable' => 'Surat Keterangan Resmi Kepala Stasiun Meteorologi ber-TTE & Stempel Dinas',
                'legal_basis' => 'UU No. 31 Tahun 2009 tentang Meteorologi, Klimatologi, dan Geofisika & Kitab Undang-Undang Hukum Acara Pidana/Perdata (Alat Bukti Keterangan Ahli/Surat).',
                'target_applicants' => 'Pemilik Polis Asuransi, Perusahaan Asuransi / Loss Adjuster, Kepolisian RI, Kejaksaan, Pengadilan, Lembaga Bantuan Hukum.',
                'summary' => 'Penerbitan Surat Keterangan Resmi Kepala Stasiun Meteorologi tentang verifikasi kejadian fenomena cuaca ekstrem (angin kencang, puting beliung, sambaran petir, hujan sangat lebat penyebab genangan/banjir mendadak, pohon tumbang) pada tanggal, jam, dan lokasi spesifik sebagai bukti klaim asuransi kerugian atau penyelidikan hukum.',
                'requirements' => [
                    'Fotokopi KTP Pemohon / Surat Kuasa bermaterai jika dikuasakan.',
                    'Surat Permohonan Resmi Keterangan Kejadian Cuaca Ekstrem.',
                    'Fotokopi Polis Asuransi atau Surat Permintaan Verifikasi dari Pihak Asuransi / Surat Permintaan dari Kepolisian.',
                    'Laporan Kejadian / Berita Acara Kerusakan beserta dokumentasi foto kerusakan di lokasi.',
                    'Keterangan waktu kejadian secara rinci (Hari, Tanggal, Perkiraan Jam Insiden) dan alamat lengkap tempat kejadian.',
                    'Bukti penyetoran PNBP SIMPONI ke kas negara.'
                ],
                'flow_steps' => [
                    [
                        'step' => 1,
                        'title' => 'Pengajuan Surat Permohonan & Kronologi',
                        'desc' => 'Pemohon melampirkan kronologi kejadian insiden cuaca ekstrem, waktu detail kejadian, dan foto kerusakan aset.'
                    ],
                    [
                        'step' => 2,
                        'title' => 'Penerbitan Billing PNBP SIMPONI',
                        'desc' => 'Petugas PTSP Stamet menerbitkan kode billing resmi kas negara untuk jasa informasi cuaca khusus.'
                    ],
                    [
                        'step' => 3,
                        'title' => 'Rekonstruksi & Analisis Forensik Cuaca',
                        'desc' => 'Forecaster menganalisis rekaman sensor AWS, deteksi sambaran petir (Lightning Detector), dan pantauan radar cuaca pada jam insiden.'
                    ],
                    [
                        'step' => 4,
                        'title' => 'Penerbitan Surat Keterangan Resmi',
                        'desc' => 'Kepala Stasiun Meteorologi menandatangani Surat Keterangan Kejadian Cuaca Ekstrem berkekuatan hukum dengan stempel dinas / TTE ber-QR Code.'
                    ]
                ],
                'template_doc' => [
                    'title' => 'Format Surat Permohonan Keterangan Cuaca untuk Klaim Asuransi',
                    'content' => "SURAT PERMOHONAN KETERANGAN KEJADIAN CUACA EKSTREM\nKepada Yth.\nKepala Stasiun Meteorologi Kelas I BMKG\n\nSaya yang bertanda tangan di bawah ini:\nNama Lengkap: [Nama Pemohon / Tertanggung]\nNIK / No. KTP: [Nomor KTP]\nAlamat Lengkap: [Alamat Domisili]\nNo. HP / WhatsApp: [Nomor WhatsApp]\nNomor Polis Asuransi: [Nomor Polis]\nNama Perusahaan Asuransi: [Nama Asuransi]\n\nDengan ini memohon diterbitkan Surat Keterangan Resmi Kejadian Cuaca Ekstrem sehubungan dengan klaim asuransi kerugian atas aset berupa [Rumah / Mobil / Pabrik] akibat:\nFenomena: [Contoh: Hujan Badai / Angin Puting Beliung / Sambaran Petir]\nWaktu Kejadian: [Hari, Tanggal, Jam WIB]\nLokasi Kejadian: [Alamat Lengkap Lokasi Insiden]\n\nBersama ini saya lampirkan foto dokumentasi kerusakan dan fotokopi polis asuransi.\nDemikian permohonan ini saya buat dengan sebenar-benarnya.\n\n[Kota, Tanggal]\n(Tanda Tangan Pemohon)\n[Nama Lengkap]"
                ],
                'faqs' => [
                    [
                        'q' => 'Apakah surat keterangan BMKG diterima oleh seluruh perusahaan asuransi?',
                        'a' => 'Ya. Surat Keterangan Resmi yang diterbitkan oleh Kepala Stasiun Meteorologi BMKG merupakan dokumen forensik cuaca primer berkekuatan hukum resmi yang diakui dan dipersyaratkan oleh seluruh perusahaan asuransi umum serta kantor loss adjuster di Indonesia.'
                    ],
                    [
                        'q' => 'Apakah sambaran petir pada jam tertentu bisa diverifikasi BMKG?',
                        'a' => 'Ya. Stasiun Meteorologi memiliki akses jaringan Lightning Detector BMKG yang dapat melacak dan memverifikasi koordinat sambaran petir Cloud-to-Ground (CG) beserta waktu presisi kejadian (detik/menit) di area terdampak.'
                    ]
                ],
                'whatsapp_draft' => 'Halo Petugas Pelayanan Stamet BMKG, saya ingin mengajukan permohonan Surat Keterangan Kejadian Cuaca Ekstrem untuk keperluan klaim asuransi / keterangan hukum. Mohon informasi kelengkapan berkasnya. Terima kasih.'
            ],
            [
                'id' => 5,
                'slug' => 'kunjungan-edukasi',
                'code' => 'STAMET-VISIT-05',
                'title' => 'Layanan Kunjungan Edukasi & Wisata Cuaca ke Taman Alat Stamet',
                'short_title' => 'Kunjungan Edukasi Taman Alat (Sekolah)',
                'icon' => 'fa-school',
                'category' => 'edukasi',
                'category_label' => 'Edukasi & Sekolah',
                'badge' => 'GRATIS / Terbuka',
                'badge_color' => '#a855f7',
                'tariff_type' => 'free',
                'tariff_label' => 'Rp 0,- (GRATIS Edukasi Publik BMKG)',
                'sla' => 'Konfirmasi jadwal dalam 1 - 2 Hari Kerja',
                'deliverable' => 'Sesi Edukasi Interaktif, Tur Taman Alat Meteorologi & Sertifikat Kunjungan',
                'legal_basis' => 'Program Literasi Kebencanaan dan Iklim Badan Meteorologi, Klimatologi, dan Geofisika (BMKG Goes to School).',
                'target_applicants' => 'Siswa TK, SD, SMP, SMA, SMK, Mahasiswa, Komunitas Pecinta Lingkungan & Sains.',
                'summary' => 'Kegiatan pembelajaran luar kelas (field trip / study tour) ke Stasiun Meteorologi dan Taman Alat Pengamatan Cuaca. Siswa dan guru diajak melihat serta mempraktikkan cara kerja Sangkar Meteorologi, Termometer Bola Basah/Kering, Panci Penguapan, Penakar Hujan Hellmann/OBS, Anemometer, Campbell Stokes, Barometer, hingga radar cuaca dan ruang operasional forecaster.',
                'requirements' => [
                    'Surat permohonan kunjungan resmi bertanda tangan Kepala Sekolah / Pimpinan Institusi (diajukan minimal H-7 sebelum tanggal kunjungan yang diinginkan).',
                    'Daftar estimasi jumlah siswa dan jumlah guru pendamping (disarankan 30 hingga 50 orang per rombongan agar edukasi berjalan kondusif).',
                    'Menyertakan nomor WhatsApp guru penanggung jawab / koordinator kunjungan untuk koordinasi teknis.',
                    'Mematuhi tata tertib keselamatan selama berada di area operasional taman alat meteorologi.'
                ],
                'flow_steps' => [
                    [
                        'step' => 1,
                        'title' => 'Kirim Surat Permohonan Kunjungan',
                        'desc' => 'Pihak sekolah mengirimkan surat permohonan kunjungan H-7 ke PTSP Stamet via website / WhatsApp / email resmi.'
                    ],
                    [
                        'step' => 2,
                        'title' => 'Pengecekan Kalender Kunjungan Stamet',
                        'desc' => 'Petugas PTSP mencocokkan tanggal yang diajukan dengan kalender kegiatan stasiun dan menerbitkan Surat Balasan Konfirmasi Kunjungan.'
                    ],
                    [
                        'step' => 3,
                        'title' => 'Penerimaan & Paparan Pengantar',
                        'desc' => 'Rombongan diterima di Aula Stasiun Meteorologi untuk pemaparan animasi interaktif pengenalan fenomena cuaca dan mitigasi bencana.'
                    ],
                    [
                        'step' => 4,
                        'title' => 'Tur Taman Alat & Ruang Forecaster',
                        'desc' => 'Peserta diajak berkeliling taman alat cuaca dipandu oleh instruktur pengamat Stamet dan berfoto bersama di sangkar meteo.'
                    ]
                ],
                'template_doc' => [
                    'title' => 'Contoh Surat Permohonan Kunjungan Edukasi Sekolah',
                    'content' => "KOP SURAT RESMI SEKOLAH\nNomor: ... / SEK / ... / 2026\nPerihal: Permohonan Kunjungan Edukasi / Field Trip ke Stasiun Meteorologi\n\nKepada Yth.\nKepala Stasiun Meteorologi Kelas I BMKG\n\nDengan hormat,\nDalam rangka meningkatkan wawasan siswa mengenai ilmu cuaca, iklim, dan kesiapsiagaan mitigasi bencana alam, kami dari [Nama Sekolah] bermaksud mengadakan kegiatan Kunjungan Edukasi ke Stasiun Meteorologi BMKG yang Bapak/Ibu pimpin pada:\n\nHari / Tanggal: [Hari, Tanggal yang Diajukan]\nWaktu: Pukul 09.00 s.d. 12.00 WIB\nJumlah Peserta: [Contoh: 40 Siswa & 4 Guru Pendamping]\nJenjang Kelas: [Contoh: Kelas 5 SD / Kelas 8 SMP]\n\nBesar harapan kami Bapak/Ibu dapat memberikan izin dan memfasilitasi rombongan kami.\nDemikian surat permohonan ini kami sampaikan. Atas perkenan dan kerjasama Bapak/Ibu, kami ucapkan terima kasih.\n\n[Kota, Tanggal]\nKepala Sekolah,\n\n(Tanda Tangan & Stempel Resmi)\n[Nama Lengkap Kepala Sekolah & NIP]"
                ],
                'faqs' => [
                    [
                        'q' => 'Apakah kunjungan sekolah ke stasiun meteorologi berbayar?',
                        'a' => 'Sama sekali TIDAK BERBAYAR (100% GRATIS). Kunjungan edukasi merupakan bagian dari pelayanan sosial BMKG Goes to School untuk mencerdaskan generasi muda mengenai sains cuaca dan keselamatan bencana.'
                    ],
                    [
                        'q' => 'Hari apa saja yang dibuka untuk jadwal kunjungan?',
                        'a' => 'Kunjungan dibuka setiap hari kerja (Senin s.d. Jumat) dengan dua sesi: Sesi Pagi (09.00 - 11.30 WIB) dan Sesi Siang (13.30 - 15.00 WIB) sesuai konfirmasi ketersediaan jadwal.'
                    ]
                ],
                'whatsapp_draft' => 'Halo Petugas Pelayanan Stamet BMKG, kami dari pihak sekolah ingin mengajukan permohonan Kunjungan Edukasi / Field Trip Siswa ke Taman Alat Meteorologi. Mohon informasi ketersediaan jadwal kunjungan. Terima kasih.'
            ],
            [
                'id' => 6,
                'slug' => 'rekomendasi-alat-aws',
                'code' => 'STAMET-TEC-06',
                'title' => 'Layanan Rekomendasi Teknis & Konsultasi Sensor Cuaca / AWS Mandiri',
                'short_title' => 'Rekomendasi Sensor AWS Mandiri',
                'icon' => 'fa-tower-broadcast',
                'category' => 'teknis',
                'category_label' => 'Konsultasi Teknis',
                'badge' => 'Standar WMO',
                'badge_color' => '#06b6d4',
                'tariff_type' => 'pnbp',
                'tariff_label' => 'Sesuai PP PNBP Jasa Konsultasi Meteorologi',
                'sla' => '3 - 5 Hari Kerja',
                'deliverable' => 'Surat Rekomendasi Teknis Penempatan Sensor Berstandar WMO No. 8',
                'legal_basis' => 'Peraturan BMKG tentang Standar Peralatan dan Penempatan Instrumen Meteorologi Otomatis serta Panduan WMO Guide to Meteorological Instruments and Methods of Observation (WMO-No. 8).',
                'target_applicants' => 'Perusahaan Swasta, Perkebunan Kelapa Sawit/Karet, Industri Kimia/Pabrik, Pengelola Jalan Tol, Universitas / Lembaga Riset Mandiri.',
                'summary' => 'Layanan survei kelayakan tapak, verifikasi spesifikasi sensor, dan penerbitan rekomendasi resmi tata letak Automatic Weather Station (AWS) mandiri agar bebas dari efek halangan gedung, pantulan panas aspal, atau turbulensi buatan sehingga data cuaca yang dihasilkan valid dan akurat secara ilmiah.',
                'requirements' => [
                    'Surat permohonan konsultasi teknis dari direksi pimpinan perusahaan / institusi.',
                    'Lembar spesifikasi teknis sensor AWS (merk, tipe sensor temperatur, kelembapan, anemometer ultrasonik/propeller, penakar hujan tipping bucket, radiasi matahari Pyranometer).',
                    'Denah tapak rencana pemasangan sensor (Site Plan) lengkap dengan koordinat GPS dan foto 360 derajat rintangan sekitarnya.',
                    'Profil perusahaan dan NPWP badan usaha pengaju.',
                    'Bukti pembayaran PNBP kas negara melalui kode billing SIMPONI.'
                ],
                'flow_steps' => [
                    [
                        'step' => 1,
                        'title' => 'Pengajuan Spesifikasi & Site Plan',
                        'desc' => 'Pemohon mengirimkan spesifikasi teknis peralatan AWS dan denah titik tapak koordinat yang direncanakan.'
                    ],
                    [
                        'step' => 2,
                        'title' => 'Billing PNBP & Telaah Dokumen',
                        'desc' => 'Petugas menerbitkan kode billing SIMPONI. Tim teknisi instrumentasi Stamet menelaah parameter sensor sesuai kaidah WMO No. 8.'
                    ],
                    [
                        'step' => 3,
                        'title' => 'Survei Verifikasi Tapak (Jika Diperlukan)',
                        'desc' => 'Jika diperlukan, teknisi Stamet melakukan inspeksi tapak untuk mengukur jarak bebas rintangan (obstruction ratio).'
                    ],
                    [
                        'step' => 4,
                        'title' => 'Penerbitan Rekomendasi Teknis',
                        'desc' => 'Stasiun Meteorologi menerbitkan Dokumen Rekomendasi Teknis Penempatan Sensor Meteorologi resmi berstandar nasional.'
                    ]
                ],
                'template_doc' => [
                    'title' => 'Contoh Permohonan Rekomendasi Teknis Sensor Cuaca AWS',
                    'content' => "KOP SURAT PERUSAHAAN / LEMBAGA\nNomor: ... / DIR / ... / 2026\nPerihal: Permohonan Rekomendasi Teknis Penempatan Sensor AWS Mandiri\n\nKepada Yth.\nKepala Stasiun Meteorologi Kelas I BMKG\n\nDengan hormat,\nDalam rangka pemantauan kondisi cuaca operasional di area proyek kami [Nama Perusahaan / Proyek], kami berencana memasang 1 (satu) unit stasiun cuaca otomatis (Automatic Weather Station - AWS) mandiri di lokasi:\nLokasi Proyek: [Alamat Lengkap]\nKoordinat: Lat [...], Long [...]\n\nAgar penempatan sensor cuaca tersebut memenuhi standar baku World Meteorological Organization (WMO No. 8) dan BMKG, kami bermaksud memohon rekomendasi teknis serta konsultasi penempatan sensor dari Stasiun Meteorologi BMKG.\nBersama surat ini kami lampirkan lembar spesifikasi teknis peralatan dan denah tapak pemasangan.\nDemikian permohonan ini kami ajukan. Atas kerjasama dan bimbingan teknis Bapak/Ibu kami sampaikan terima kasih.\n\n[Kota, Tanggal]\nDirektur / Manajer Operasional,\n\n(Tanda Tangan & Stempel Perusahaan)\n[Nama Lengkap & Jabatan]"
                ],
                'faqs' => [
                    [
                        'q' => 'Mengapa stasiun cuaca swasta harus mengikuti standar penempatan BMKG?',
                        'a' => 'Sensor temperatur atau angin yang dipasang terlalu dekat dengan dinding gedung, generator, atau pohon rimbun akan mengalami bias data parah (contoh: angin terhalang hingga 70% atau suhu terbaca terlalu panas akibat radiasi dinding beton). Rekomendasi BMKG menjamin akurasi dan kredibilitas data yang dihasilkan.'
                    ],
                    [
                        'q' => 'Apakah BMKG melayani kalibrasi sensor cuaca milik swasta?',
                        'a' => 'Ya, BMKG melayani kalibrasi laboratorium untuk sensor suhu, kelembapan, barometer tekanan udara, dan penakar hujan dengan sertifikat kalibrasi resmi berstandar KAN.'
                    ]
                ],
                'whatsapp_draft' => 'Halo Petugas Pelayanan Stamet BMKG, perusahaan kami ingin berkonsultasi mengenai Layanan Rekomendasi Teknis & Penempatan Sensor AWS Mandiri. Mohon informasi tahapannya. Terima kasih.'
            ]
        ];
    }

    /**
     * Web view: Laman Fitur Layanan Stamet
     */
    public function indexView()
    {
        $services = self::getServicesCatalog();
        $whatsappNumber = SiteSetting::get('stamet_whatsapp', '6285777776751');
        $stametName = SiteSetting::get('stamet_name', 'Stasiun Meteorologi Citeko - Puncak Bogor (BMKG)');
        $officeHours = SiteSetting::get('stamet_office_hours', 'Senin - Jumat: 08:00 - 15:00 WIB (Layanan PTSP) | Operasional Cuaca: 24 Jam');

        return view('services', compact('services', 'whatsappNumber', 'stametName', 'officeHours'));
    }

    /**
     * API: Daftar seluruh layanan Stamet
     */
    public function getServices()
    {
        $services = self::getServicesCatalog();
        $whatsapp = SiteSetting::get('stamet_whatsapp', '6285777776751');
        $stametName = SiteSetting::get('stamet_name', 'Stasiun Meteorologi Citeko - Puncak Bogor (BMKG)');

        return response()->json([
            'success' => true,
            'data' => [
                'services' => $services,
                'stamet_name' => $stametName,
                'whatsapp' => $whatsapp,
                'office_hours' => SiteSetting::get('stamet_office_hours', 'Senin - Jumat: 08:00 - 15:00 WIB'),
            ]
        ]);
    }

    /**
     * API: Auto-Answer Engine untuk Layanan Stamet
     * Mencocokkan query pemohon secara cerdas dengan basis pengetahuan resmi Stamet.
     * Bila tidak cocok atau memerlukan tindak lanjut khusus, menyediakan direct link WhatsApp ke Admin.
     */
    public function autoAnswer(Request $request)
    {
        $query = trim(strtolower($request->input('query', '')));
        $serviceSlug = $request->input('service_slug');
        $whatsappNumber = SiteSetting::get('stamet_whatsapp', '6285777776751');

        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan masukkan pertanyaan Anda.'
            ], 422);
        }

        $services = self::getServicesCatalog();
        $foundAnswer = null;
        $matchedService = null;
        $confidence = 0;

        // Filter service jika user memilih spesifik
        $targetServices = $services;
        if (!empty($serviceSlug)) {
            $filtered = array_filter($services, fn($s) => $s['slug'] === $serviceSlug);
            if (!empty($filtered)) {
                $targetServices = array_values($filtered);
            }
        }

        // Knowledge Matching Rules
        foreach ($targetServices as $svc) {
            // Cek FAQ
            foreach ($svc['faqs'] as $faq) {
                $qText = strtolower($faq['q']);
                $aText = strtolower($faq['a']);
                
                // Hitung kemiripan kata kunci
                $keywords = explode(' ', $query);
                $hits = 0;
                foreach ($keywords as $kw) {
                    if (strlen($kw) > 2 && (str_contains($qText, $kw) || str_contains($aText, $kw))) {
                        $hits++;
                    }
                }

                if ($hits >= 2 || (count($keywords) === 1 && $hits === 1)) {
                    $foundAnswer = [
                        'type' => 'faq',
                        'service' => $svc['short_title'],
                        'service_slug' => $svc['slug'],
                        'question' => $faq['q'],
                        'answer' => $faq['a'],
                        'sla' => $svc['sla'],
                        'tariff' => $svc['tariff_label'],
                    ];
                    $matchedService = $svc;
                    $confidence = 0.85;
                    break 2;
                }
            }
        }

        // Keyword Rules Khusus Stamet
        if (!$foundAnswer) {
            if (str_contains($query, 'skripsi') || str_contains($query, 'gratis') || str_contains($query, 'mahasiswa') || str_contains($query, 'riset') || str_contains($query, 'kuliah') || str_contains($query, 'kampus')) {
                $svc = $services[2]; // Riset Skripsi
                $foundAnswer = [
                    'type' => 'topic',
                    'service' => $svc['short_title'],
                    'service_slug' => $svc['slug'],
                    'question' => 'Apakah data cuaca untuk skripsi / tugas akhir mahasiswa benar-benar gratis?',
                    'answer' => 'Ya, 100% GRATIS (Tarif Rp 0,-). Sesuai Peraturan Kepala BMKG No. 12 Tahun 2019, permohonan data cuaca untuk kepentingan penelitian tugas akhir mahasiswa (D3, S1, S2, S3) dibebaskan dari pungutan PNBP. Cukup melampirkan Surat Pengantar resmi dari Dekan/Kaprodi dan ringkasan proposal penelitian.',
                    'sla' => $svc['sla'],
                    'tariff' => $svc['tariff_label'],
                ];
                $matchedService = $svc;
                $confidence = 0.90;
            } elseif (str_contains($query, 'penerbangan') || str_contains($query, 'pesawat') || str_contains($query, 'metar') || str_contains($query, 'taf') || str_contains($query, 'pilot') || str_contains($query, 'bandara') || str_contains($query, 'aviasi')) {
                $svc = $services[0]; // Cuaca Penerbangan
                $foundAnswer = [
                    'type' => 'topic',
                    'service' => $svc['short_title'],
                    'service_slug' => $svc['slug'],
                    'question' => 'Bagaimana prosedur pengambilan dokumen cuaca penerbangan (Flight Documentation)?',
                    'answer' => 'Petugas FOO atau maskapai mengajukan flight plan dan jadwal penerbangan paling lambat H-2 jam sebelum waktu keberangkatan (ETD). Dokumen mencakup laporan METAR, prakiraan aerodrome TAF, peta angin WAFS, dan SIGMET, yang disahkan ber-QR Code digital oleh Forecaster on Duty Stamet.',
                    'sla' => $svc['sla'],
                    'tariff' => $svc['tariff_label'],
                ];
                $matchedService = $svc;
                $confidence = 0.90;
            } elseif (str_contains($query, 'asuransi') || str_contains($query, 'klaim') || str_contains($query, 'puting beliung') || str_contains($query, 'petir') || str_contains($query, 'hukum') || str_contains($query, 'polisi') || str_contains($query, 'tumbang')) {
                $svc = $services[3]; // Asuransi & Hukum
                $foundAnswer = [
                    'type' => 'topic',
                    'service' => $svc['short_title'],
                    'service_slug' => $svc['slug'],
                    'question' => 'Bagaimana cara memperoleh surat keterangan cuaca ekstrem untuk klaim asuransi?',
                    'answer' => 'Pemohon mengajukan surat permohonan resmi disertai kronologi kejadian, perkiraan jam insiden, fotokopi polis asuransi, dan foto kerusakan aset. Tim analis forensik Stamet akan merekonstruksi rekaman AWS, citra radar Doppler, dan detektor petir di lokasi kejadian, lalu menerbitkan Surat Keterangan Resmi Kepala Stasiun berstempel dinas / TTE.',
                    'sla' => $svc['sla'],
                    'tariff' => $svc['tariff_label'],
                ];
                $matchedService = $svc;
                $confidence = 0.90;
            } elseif (str_contains($query, 'kunjungan') || str_contains($query, 'sekolah') || str_contains($query, 'study tour') || str_contains($query, 'field trip') || str_contains($query, 'taman alat') || str_contains($query, 'murid')) {
                $svc = $services[4]; // Kunjungan Edukasi
                $foundAnswer = [
                    'type' => 'topic',
                    'service' => $svc['short_title'],
                    'service_slug' => $svc['slug'],
                    'question' => 'Bagaimana prosedur permohonan kunjungan sekolah ke taman alat meteorologi?',
                    'answer' => 'Pihak sekolah mengirimkan surat permohonan resmi dari Kepala Sekolah minimal H-7 sebelum hari kunjungan, dengan mencantumkan jumlah peserta (maksimal 30-50 siswa per sesi). Kegiatan kunjungan ini 100% GRATIS (tidak dipungut biaya) dan dibuka setiap hari kerja pukul 09.00 - 14.00 WIB.',
                    'sla' => $svc['sla'],
                    'tariff' => $svc['tariff_label'],
                ];
                $matchedService = $svc;
                $confidence = 0.90;
            } elseif (str_contains($query, 'event') || str_contains($query, 'konser') || str_contains($query, 'outdoor') || str_contains($query, 'lapangan') || str_contains($query, 'panggung') || str_contains($query, 'acara')) {
                $svc = $services[1]; // Event Luar Ruang
                $foundAnswer = [
                    'type' => 'topic',
                    'service' => $svc['short_title'],
                    'service_slug' => $svc['slug'],
                    'question' => 'Bagaimana cara mendapatkan informasi cuaca mikro untuk konser / event outdoor?',
                    'answer' => 'Panitia mengajukan surat permohonan resmi minimal H-3 sebelum kegiatan beserta koordinat GPS lokasi acara dan rundown kegiatan. Stasiun Meteorologi akan menerbitkan buletin cuaca mikro per jam serta menyediakan pemantauan nowcasting radar cuaca real-time selama acara berlangsung.',
                    'sla' => $svc['sla'],
                    'tariff' => $svc['tariff_label'],
                ];
                $matchedService = $svc;
                $confidence = 0.90;
            } elseif (str_contains($query, 'aws') || str_contains($query, 'alat') || str_contains($query, 'sensor') || str_contains($query, 'kalibrasi') || str_contains($query, 'otomatis')) {
                $svc = $services[5]; // AWS Sensor Mandiri
                $foundAnswer = [
                    'type' => 'topic',
                    'service' => $svc['short_title'],
                    'service_slug' => $svc['slug'],
                    'question' => 'Bagaimana mendapatkan rekomendasi penempatan sensor cuaca AWS mandiri?',
                    'answer' => 'Perusahaan mengajukan surat permohonan konsultasi teknis dilampiri spesifikasi sensor AWS dan denah tapak pemasangan (Site Plan). Tim instrumentasi Stamet akan menelaah dan menerbitkan Dokumen Rekomendasi Teknis Penempatan Sensor sesuai standar baku World Meteorological Organization (WMO No. 8).',
                    'sla' => $svc['sla'],
                    'tariff' => $svc['tariff_label'],
                ];
                $matchedService = $svc;
                $confidence = 0.90;
            }
        }

        // Siapkan Link WhatsApp Resmi
        $serviceNameForWa = $matchedService ? $matchedService['short_title'] : 'Layanan Stasiun Meteorologi BMKG';
        $waMessage = "Halo Petugas PTSP Stamet BMKG,\nSaya pemohon layanan ingin berkonsultasi langsung mengenai:\n- Layanan: {$serviceNameForWa}\n- Pertanyaan: \"{$query}\"\n\nMohon arahan dan petunjuk teknis tindak lanjutnya. Terima kasih.";
        $encodedWa = rawurlencode($waMessage);
        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$encodedWa}";

        if ($foundAnswer) {
            return response()->json([
                'success' => true,
                'matched' => true,
                'confidence' => $confidence,
                'data' => $foundAnswer,
                'whatsapp_url' => $whatsappUrl,
                'whatsapp_number' => $whatsappNumber,
                'can_escalate' => true,
                'escalate_label' => 'Belum puas dengan jawaban otomatis? Chat Petugas Stamet via WhatsApp'
            ]);
        }

        // Jika tidak terjawab otomatis: Beri jawaban sopan dan arahkan LANGSUNG ke WhatsApp Admin
        return response()->json([
            'success' => true,
            'matched' => false,
            'confidence' => 0.0,
            'data' => [
                'type' => 'unmatched',
                'question' => $query,
                'answer' => 'Pertanyaan spesifik Anda memerlukan pemeriksaan berkas atau verifikasi langsung oleh Tim Forecaster / Petugas PTSP Stasiun Meteorologi BMKG. Silakan langsung terhubung dengan petugas kami melalui WhatsApp untuk mendapatkan asistensi instan.',
                'service' => $serviceNameForWa,
            ],
            'requires_admin' => true,
            'whatsapp_url' => $whatsappUrl,
            'whatsapp_number' => $whatsappNumber,
            'escalate_label' => 'Chat Langsung Petugas PTSP Stamet di WhatsApp'
        ]);
    }
}
