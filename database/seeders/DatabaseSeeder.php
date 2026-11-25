<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\CompanyProfile;
use App\Models\Service;
use App\Models\TermsSection;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = (string) env('ADMIN_DEFAULT_PASSWORD', 'MerahPutih2026!');

        $admin = User::updateOrCreate(
            ['email' => 'admin@merahputih.co.id'],
            [
                'name' => 'Administrator Utama',
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
                'password' => Hash::make($defaultPassword),
            ]
        );

        CompanyProfile::updateOrCreate(
            ['id' => 1],
            [
                'updated_by' => $admin->id,
                'company_name' => 'CV. Merah Putih',
                'tagline' => 'Solusi Transportasi & Rental Mobil Terpercaya di Depok',
                'description' => 'CV. Merah Putih adalah perusahaan penyedia jasa sewa dan rental kendaraan roda empat yang berpusat di Jalan Jati No. 23, Depok. Kami berkomitmen menghadirkan armada kendaraan yang terawat, bersih, nyaman, serta didukung oleh pilihan layanan fleksibel baik dengan sopir profesional maupun lepas kunci untuk kebutuhan keluarga, bisnis, wisata, dan operasional perusahaan.',
                'address' => 'Jalan Jati No. 23, Depok, Jawa Barat 16411',
                'phone' => '0812-8899-2323',
                'whatsapp' => '6281288992323',
                'email' => 'info@cvmerahputih-rental.co.id',
                'operating_hours' => 'Senin - Minggu: 07.00 - 22.00 WIB (Layanan Darurat 24 Jam)',
                'vision' => 'Menjadi perusahaan jasa rental mobil terdepan di Kota Depok dan Jabodetabek yang dikenal karena kualitas armada prima, pelayanan ramah, dan transparansi informasi.',
                'missions' => [
                    'Menyediakan unit kendaraan keluaran terbaru dengan perawatan berkala di bengkel resmi.',
                    'Memberikan layanan pengemudi yang berpengalaman, sopan, dan menguasai rute Jabodetabek maupun luar kota.',
                    'Menyajikan informasi ketersediaan unit dan tarif sewa secara jelas, jujur, dan mudah diakses masyarakat.',
                    'Mengutamakan keselamatan, kebersihan kabin, serta ketepatan waktu dalam setiap layanan.',
                ],
                'maps_url' => 'https://maps.google.com/?q=Jalan+Jati+No.+23+Depok+Jawa+Barat+16411',
                'logo_url' => '',
                'hero_image_url' => '/images/hero-garage.jpg',
                'about_image_url' => '/images/hero-garage.jpg',
            ]
        );

        $vehicles = [
            [
                'name' => 'Toyota Avanza Veloz 1.5 Q',
                'category' => 'MPV Keluarga',
                'transmission' => 'Matic',
                'seats' => 7,
                'year' => 2023,
                'fuel' => 'Bensin',
                'engine' => '1.5L Dual VVT-i CVT',
                'price_per_day' => 450000,
                'status' => 'tersedia',
                'image_url' => '/images/car-avanza-veloz.jpg',
                'description' => 'MPV keluarga paling diminati di Depok dengan kabin lega 7 penumpang, suspensi empuk, serta fitur keselamatan aktif Toyota Safety Sense. Ideal untuk perjalanan keluarga, kondangan, maupun dinas harian.',
                'features' => [
                    'AC Double Blower',
                    'Kamera 360 & Sensor Parkir',
                    'Head Unit Layar Sentuh + CarPlay',
                    'Kabin Bersih & Bebas Asap Rokok',
                    'Perawatan Bengkel Resmi Berkala',
                ],
                'featured' => true,
            ],
            [
                'name' => 'Honda Brio RS CVT',
                'category' => 'City Car',
                'transmission' => 'Matic',
                'seats' => 5,
                'year' => 2023,
                'fuel' => 'Bensin',
                'engine' => '1.2L i-VTEC CVT',
                'price_per_day' => 350000,
                'status' => 'tersedia',
                'image_url' => '/images/car-honda-brio.jpg',
                'description' => 'City car lincah dan sangat hemat bahan bakar untuk mobilitas harian di Depok, Margonda, hingga Jakarta Selatan. Mudah diparkir dan sangat nyaman dikendarai secara lepas kunci.',
                'features' => [
                    'Sangat Irit BBM',
                    'Transmisi CVT Halus',
                    'Bluetooth Audio & USB Charger',
                    'Airbag Ganda & ABS',
                    'Cocok untuk Lepas Kunci',
                ],
                'featured' => true,
            ],
            [
                'name' => 'Mitsubishi Xpander Cross',
                'category' => 'Crossover MPV',
                'transmission' => 'Matic',
                'seats' => 7,
                'year' => 2023,
                'fuel' => 'Bensin',
                'engine' => '1.5L MIVEC CVT',
                'price_per_day' => 500000,
                'status' => 'tersedia',
                'image_url' => '/images/car-xpander-cross.jpg',
                'description' => 'Crossover MPV tangguh dengan ground clearance tinggi dan suspensi terbaik di kelasnya. Sangat nyaman melibas rute Puncak, Bandung, hingga perjalanan luar kota bersama keluarga besar.',
                'features' => [
                    'Ground Clearance Tinggi 220mm',
                    'AC Digital Double Blower',
                    'Cruise Control',
                    'Bagasi Luas & Fleksibel',
                    'Peredaman Kabin Senyap',
                ],
                'featured' => true,
            ],
            [
                'name' => 'Toyota Kijang Innova Zenix G',
                'category' => 'Medium MPV',
                'transmission' => 'Matic',
                'seats' => 7,
                'year' => 2024,
                'fuel' => 'Bensin',
                'engine' => '2.0L TNGA Dynamic Force',
                'price_per_day' => 700000,
                'status' => 'disewa',
                'image_url' => '/images/car-innova-zenix.jpg',
                'description' => 'Medium MPV eksekutif dengan platform TNGA yang sangat stabil dan kabin luas berkelas. Pilihan utama untuk tamu VIP, kunjungan direksi, dan perjalanan dinas instansi.',
                'features' => [
                    'Kabin Eksekutif Sangat Lega',
                    'Captain Seat / Ergonomic Row',
                    'AC Digital & Rear Console',
                    'Peredaman Premium',
                    'Tersedia Paket Dengan Sopir Profesional',
                ],
                'featured' => true,
            ],
            [
                'name' => 'Toyota HiAce Commuter',
                'category' => 'Minibus Wisata',
                'transmission' => 'Manual',
                'seats' => 15,
                'year' => 2022,
                'fuel' => 'Solar / Diesel',
                'engine' => '2.8L Turbo Diesel',
                'price_per_day' => 1200000,
                'status' => 'tersedia',
                'image_url' => '/images/car-hiace-commuter.jpg',
                'description' => 'Minibus pariwisata berkapasitas hingga 15 penumpang dengan plafon tinggi dan kursi reclining yang nyaman. Solusi terbaik untuk outing kantor, ziarah, wisata rombongan, dan antar-jemput bandara.',
                'features' => [
                    'Kapasitas 15 Kursi Reclining',
                    'AC Plafon Merata Setiap Baris',
                    'Audio Karaoke & Port USB',
                    'Bagasi Luas untuk Koper',
                    'Wajib Dengan Sopir Berpengalaman',
                ],
                'featured' => false,
            ],
            [
                'name' => 'Daihatsu Terios R MT',
                'category' => 'SUV Keluarga',
                'transmission' => 'Manual',
                'seats' => 7,
                'year' => 2022,
                'fuel' => 'Bensin',
                'engine' => '1.5L Dual VVT-i RWD',
                'price_per_day' => 425000,
                'status' => 'tersedia',
                'image_url' => '/images/car-xpander-cross.jpg',
                'description' => 'SUV 7 penumpang berpenggerak roda belakang (RWD) yang andal di tanjakan dan rute luar kota. Ekonomis, bertenaga, dan siap menemani perjalanan kerja lapangan maupun liburan.',
                'features' => [
                    'Penggerak Roda Belakang (RWD)',
                    'Tangguh di Tanjakan Puncak',
                    'Keyless Entry & Push Start',
                    'AC Double Blower Dingin',
                    'Harga Sewa Sangat Kompetitif',
                ],
                'featured' => false,
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::updateOrCreate(
                ['name' => $vehicle['name']],
                array_merge($vehicle, ['created_by' => $admin->id])
            );
        }

        $servicesData = [
            [
                'title' => 'Rental Mobil Dengan Sopir',
                'subtitle' => 'Paling Praktis',
                'icon' => 'UserCheck',
                'description' => 'Nikmati perjalanan bebas lelah ditemani pengemudi profesional CV. Merah Putih yang ramah, rapi, dan menguasai rute Depok, Jabodetabek, hingga luar kota.',
                'highlights' => [
                    'Pengemudi berlisensi SIM A/B1 Umum & berpengalaman',
                    'Tanpa perlu deposit jaminan kendaraan',
                    'Cocok untuk kunjungan bisnis, wisata keluarga, dan acara resmi',
                    'Pilihan paket 12 jam atau Full Day (dalam/luar kota)',
                ],
                'sort_order' => 1,
            ],
            [
                'title' => 'Rental Mobil Tanpa Sopir (Lepas Kunci)',
                'subtitle' => 'Privasi Maksimal',
                'icon' => 'KeyRound',
                'description' => 'Kebebasan penuh mengatur jadwal dan rute perjalanan Anda sendiri dengan unit kendaraan terawat dan wangi.',
                'highlights' => [
                    'Syarat verifikasi dokumen mudah & transparan',
                    'Unit siap pakai dengan kondisi bahan bakar terukur',
                    'Layanan darurat teknis 24 jam di area Jabodetabek',
                    'Tersedia pilihan transmisi Matic maupun Manual',
                ],
                'sort_order' => 2,
            ],
            [
                'title' => 'Antar-Jemput Bandara & Stasiun',
                'subtitle' => 'Tepat Waktu',
                'icon' => 'Plane',
                'description' => 'Layanan drop-off dan pick-up dari wilayah Depok (Jl. Jati & sekitarnya) menuju Bandara Soekarno-Hatta, Halim Perdanakusuma, maupun Stasiun Gambir/KCIC.',
                'highlights' => [
                    'Penjemputan tepat waktu sesuai jadwal penerbangan/kereta',
                    'Tarif paket jelas sudah termasuk jasa pengemudi',
                    'Bantuan penanganan bagasi penumpang',
                    'Armada bersih dan nyaman setelah perjalanan jauh',
                ],
                'sort_order' => 3,
            ],
            [
                'title' => 'Sewa Kontrak Perusahaan (Bulanan)',
                'subtitle' => 'Korporat & Instansi',
                'icon' => 'Building2',
                'description' => 'Solusi kendaraan operasional jangka panjang untuk perusahaan, instansi pemerintah, maupun proyek di wilayah Depok dan Jakarta.',
                'highlights' => [
                    'Bebas biaya perawatan rutin, pajak STNK, dan asuransi',
                    'Tersedia unit pengganti apabila kendaraan masuk bengkel',
                    'Administrasi faktur lengkap & resmi atas nama CV. Merah Putih',
                    'Harga sewa bulanan jauh lebih hemat dan terukur',
                ],
                'sort_order' => 4,
            ],
        ];

        $seededServices = [];
        foreach ($servicesData as $service) {
            $seededServices[] = Service::updateOrCreate(
                ['title' => $service['title']],
                array_merge($service, ['created_by' => $admin->id])
            );
        }

        $termsSections = [
            [
                'service_id' => $seededServices[1]->id ?? null,
                'title' => '1. Syarat Sewa Lepas Kunci (Tanpa Sopir)',
                'items' => [
                    'Memiliki e-KTP asli dan SIM A yang masih berlaku.',
                    'Menyerahkan dokumen pendukung identitas (NPWP / Kartu Keluarga / ID Kerja).',
                    'Bersedia dilakukan proses verifikasi data oleh tim admin sebelum serah terima unit.',
                    'Durasi hitung sewa per hari adalah 24 jam sejak serah terima kendaraan.',
                ],
                'sort_order' => 1,
            ],
            [
                'service_id' => $seededServices[0]->id ?? null,
                'title' => '2. Ketentuan Sewa Dengan Sopir',
                'items' => [
                    'Tarif sewa unit belum termasuk biaya BBM, tol, parkir, dan makan/inap sopir (kecuali paket All-In).',
                    'Pemakaian dalam kota maksimal 12 jam atau sesuai kesepakatan paket Full Day.',
                    'Kelebihan waktu pemakaian (overtime) dikenakan biaya 10% dari tarif harian per jam.',
                    'Konfirmasi ketersediaan armada dan jadwal penjemputan dilakukan melalui admin resmi CV. Merah Putih.',
                ],
                'sort_order' => 2,
            ],
        ];

        foreach ($termsSections as $term) {
            TermsSection::updateOrCreate(
                ['title' => $term['title']],
                array_merge($term, ['updated_by' => $admin->id])
            );
        }

        $articles = [
            [
                'title' => 'Promo Akhir Pekan: Diskon 15% Sewa Mobil Keluarga di Depok',
                'category' => 'Promo Spesial',
                'excerpt' => 'Rencanakan liburan keluarga ke Puncak atau Bandung dengan lebih hemat menggunakan armada Avanza Veloz dan Xpander Cross dari CV. Merah Putih.',
                'content' => "Liburan akhir pekan bersama keluarga kini semakin praktis dan hemat bersama CV. Merah Putih Depok. Sepanjang bulan ini, kami menghadirkan program Promo Akhir Pekan dengan potongan harga 15% untuk penyewaan minimal 2 hari pada armada MPV keluarga pilihan seperti Toyota Avanza Veloz 1.5 Q dan Mitsubishi Xpander Cross.\n\nSeluruh unit telah melewati pemeriksaan menyeluruh sebelum berangkat, mulai dari tekanan ban, kondisi rem, kebersihan kabin, hingga kesejukan AC double blower agar perjalanan Anda menuju Puncak, Bogor, maupun Bandung berjalan lancar tanpa kendala.\n\nUntuk memanfaatkan promo ini, Anda cukup menghubungi tim admin kami melalui WhatsApp minimal H-2 sebelum jadwal keberangkatan agar unit dapat kami jadwalkan secara khusus untuk keluarga Anda.",
                'image_url' => '/images/blog-puncak-trip.jpg',
                'published_at' => '2026-11-15',
                'author' => 'Admin CV. Merah Putih',
                'status' => 'published',
            ],
            [
                'title' => 'Syarat & Tips Mudah Sewa Mobil Lepas Kunci Bagi Pemula',
                'category' => 'Panduan Layanan',
                'excerpt' => 'Ingin menyewa mobil tanpa sopir untuk pertama kalinya? Simak kelengkapan dokumen dan tips serah terima unit agar perjalanan Anda aman dan nyaman.',
                'content' => "Layanan sewa mobil lepas kunci memberikan fleksibilitas dan privasi penuh bagi Anda yang ingin mengatur jadwal perjalanan sendiri. Agar proses verifikasi di CV. Merah Putih berlangsung cepat, siapkan dokumen asli berupa e-KTP, SIM A aktif, serta satu dokumen pendukung seperti Kartu Keluarga atau ID Karyawan.\n\nSaat serah terima kendaraan di garasi Jalan Jati No. 23 Depok maupun pengantaran ke alamat Anda, luangkan waktu 5 menit bersama petugas kami untuk memeriksa kondisi bodi kendaraan, indikator bahan bakar, serta kelengkapan STNK dan alat darurat.\n\nDokumentasikan serah terima dengan jelas dan simpan nomor layanan darurat 24 jam CV. Merah Putih. Dengan persiapan singkat ini, pengalaman sewa mobil lepas kunci pertama Anda dijamin aman, transparan, dan menyenangkan.",
                'image_url' => '/images/car-honda-brio.jpg',
                'published_at' => '2026-11-08',
                'author' => 'Tim Operasional Depok',
                'status' => 'published',
            ],
            [
                'title' => '5 Destinasi Wisata Ramah Keluarga Dekat Depok yang Wajib Dikunjungi',
                'category' => 'Tips Perjalanan',
                'excerpt' => 'Tidak perlu menempuh perjalanan terlalu jauh untuk menyegarkan pikiran. Berikut rekomendasi tempat wisata edukatif dan alam yang mudah dijangkau dari Depok.',
                'content' => "Berangkat dari Kota Depok, banyak destinasi wisata alam dan edukatif yang dapat ditempuh dalam waktu 45 hingga 90 menit menggunakan mobil keluarga. Pertama, Kebun Raya Bogor yang selalu sejuk untuk piknik pagi. Kedua, Taman Wisata Alam Sentul dan kawasan curug yang mudah diakses lewat Tol Jagorawi.\n\nKetiga, Taman Safari Indonesia Cisarua yang menjadi favorit anak-anak sepanjang masa. Keempat, kawasan wisata kuliner dan agrowisata di Cibubur serta Mekarsari. Kelima, pantai dan taman rekreasi di Jakarta Utara untuk variasi liburan singkat tanpa menginap.\n\nJika Anda ingin bersantai sepenuhnya tanpa lelah menghadapi kemacetan akhir pekan, layanan Rental Mobil Dengan Sopir CV. Merah Putih siap mengantar keluarga Anda dengan aman sampai kembali ke rumah.",
                'image_url' => '/images/car-avanza-veloz.jpg',
                'published_at' => '2026-11-01',
                'author' => 'Tim Redaksi Merah Putih',
                'status' => 'published',
            ],
        ];

        foreach ($articles as $article) {
            Article::updateOrCreate(
                ['title' => $article['title']],
                array_merge($article, ['admin_id' => $admin->id])
            );
        }
    }
}