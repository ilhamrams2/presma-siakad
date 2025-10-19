<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard SIAKAD | SMK Prestasi Prima</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-white text-orange-800 antialiased">

  <!-- === Top Bar === -->
  <div class="w-full bg-orange-600 text-white text-sm">
    <div class="max-w-screen-xl mx-auto flex items-center justify-end px-4 py-1 space-x-6">
      <div class="flex items-center space-x-2">
        <i class="ri-phone-line"></i>
        <span>0895 - 9943 - 9033</span>
      </div>
      <div class="flex items-center space-x-2">
        <i class="ri-mail-line"></i>
        <span>halo@smkprestasiprima.ac.id</span>
      </div>
    </div>
  </div>

  <!-- === Navbar === -->
  <nav class="bg-white/90 backdrop-blur-md border-b border-orange-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-screen-xl mx-auto flex items-center justify-between px-6 py-3">
      <div class="flex items-center space-x-3">
        <img src="{{ asset('assets/logo-smk.png') }}" class="h-10" alt="Logo SMK Prestasi Prima">
        <h1 class="text-xl font-bold text-orange-600 tracking-wide">SMK Prestasi Prima</h1>
      </div>

      <ul class="hidden md:flex items-center space-x-8 font-medium text-orange-700">
        <li><a href="#jadwal" class="hover:text-orange-500 transition">Jadwal</a></li>
        <li><a href="#absensi" class="hover:text-orange-500 transition">Absensi</a></li>
        <li><a href="#pengumuman" class="hover:text-orange-500 transition">Pengumuman</a></li>
      </ul>

      <button id="dropdownButton" class="rounded-full hover:ring-2 hover:ring-orange-200 transition">
        <img class="w-9 h-9 rounded-full object-cover"
          src="https://flowbite.com/docs/images/people/profile-picture-3.jpg" alt="User Photo">
      </button>

      <div id="dropdownMenu"
        class="hidden absolute right-6 mt-56 w-52 bg-white rounded-2xl shadow-lg border border-orange-100 overflow-hidden">
        <div class="px-4 py-3 bg-orange-50">
          <span class="block text-sm font-semibold text-orange-700">Ardy Albanna</span>
          <span class="block text-xs text-orange-600 truncate">ardy@student.prestasiprima.ac.id</span>
        </div>
        <div class="border-t border-orange-100"></div>
        <a href="#"
          class="flex items-center gap-2 px-4 py-2.5 text-sm text-orange-700 hover:bg-orange-50 transition-all">
          <i class="ri-logout-box-r-line text-base"></i> Logout
        </a>
      </div>
    </div>
  </nav>

  <!-- === Hero Section === -->
  <section class="bg-gradient-to-b from-orange-50 to-white py-20 text-center">
    <div class="max-w-screen-xl mx-auto px-6">
      <h1 class="text-4xl font-bold text-orange-800">Selamat Datang, <span class="text-orange-600">Ardy Albanna!</span></h1>
      <p class="mt-3 text-orange-700">Berikut ringkasan kegiatan belajarmu di SMK Prestasi Prima</p>

      <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-10">
        <div class="bg-white shadow-lg rounded-3xl p-6 border border-orange-100 hover:shadow-xl hover:scale-105 transition">
          <h3 class="text-3xl font-bold text-orange-600">64</h3>
          <p class="text-sm font-medium mt-1">Jam Pelajaran / Minggu</p>
        </div>
        <div class="bg-white shadow-lg rounded-3xl p-6 border border-orange-100 hover:shadow-xl hover:scale-105 transition">
          <h3 class="text-3xl font-bold text-orange-600">15</h3>
          <p class="text-sm font-medium mt-1">Mata Pelajaran</p>
        </div>
        <div class="bg-white shadow-lg rounded-3xl p-6 border border-orange-100 hover:shadow-xl hover:scale-105 transition">
          <h3 class="text-3xl font-bold text-orange-600">156</h3>
          <p class="text-sm font-medium mt-1">Hadir</p>
        </div>
        <div class="bg-white shadow-lg rounded-3xl p-6 border border-orange-100 hover:shadow-xl hover:scale-105 transition">
          <h3 class="text-3xl font-bold text-orange-600">5</h3>
          <p class="text-sm font-medium mt-1">Pengumuman Baru</p>
        </div>
      </div>
    </div>
  </section>

  <!-- === Jadwal Pelajaran === -->
  <section id="jadwal" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-12">
        <i class="ri-calendar-event-line text-orange-600 text-3xl mb-2"></i>
        <h2 class="text-3xl font-bold">Jadwal Pelajaran Hari Ini</h2>
        <p class="text-orange-700">Berikut daftar pelajaran yang akan kamu ikuti hari ini.</p>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ([
          ['mapel'=>'Matematika','guru'=>'Ibu Siti','jam'=>'07.00 - 08.30'],
          ['mapel'=>'Bahasa Indonesia','guru'=>'Pak Rahman','jam'=>'08.40 - 10.10'],
          ['mapel'=>'Produktif RPL','guru'=>'Pak Dedi','jam'=>'10.30 - 12.00'],
          ['mapel'=>'Pendidikan Agama','guru'=>'Ustadz Fajar','jam'=>'13.00 - 14.30'],
          ['mapel'=>'Bahasa Inggris','guru'=>'Bu Wina','jam'=>'14.40 - 16.00'],
        ] as $j)
        <div class="bg-gradient-to-br from-orange-50 to-white p-6 rounded-3xl border border-orange-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
          <div class="flex items-center justify-between mb-3">
            <i class="ri-book-open-line text-orange-600 text-2xl"></i>
            <span class="text-sm text-orange-700">{{ $j['jam'] }}</span>
          </div>
          <h3 class="font-semibold text-lg">{{ $j['mapel'] }}</h3>
          <p class="text-sm">Guru: {{ $j['guru'] }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- === Absensi === -->
  <section id="absensi" class="py-20 bg-orange-50">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <i class="ri-user-check-line text-orange-600 text-3xl mb-2"></i>
      <h2 class="text-3xl font-bold mb-10">Rekap Absensi</h2>

      <div class="grid md:grid-cols-3 gap-8">
        @foreach ([
          ['title'=>'Hadir','icon'=>'ri-user-smile-line','count'=>18],
          ['title'=>'Izin','icon'=>'ri-user-shared-line','count'=>2],
          ['title'=>'Alfa','icon'=>'ri-user-unfollow-line','count'=>1],
        ] as $a)
        <div class="bg-white rounded-3xl shadow-md p-8 hover:shadow-xl hover:scale-105 transition transform duration-300 border-t-4 border-orange-600">
          <i class="{{ $a['icon'] }} text-5xl text-orange-500 mb-4"></i>
          <h3 class="font-semibold text-xl mb-2">{{ $a['title'] }}</h3>
          <p class="text-lg">{{ $a['count'] }} Hari</p>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- === Pengumuman === -->
  <section id="pengumuman" class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-6">
      <div class="text-center mb-12">
        <i class="ri-megaphone-line text-orange-600 text-3xl mb-2"></i>
        <h2 class="text-3xl font-bold">Pengumuman Sekolah</h2>
        <p class="text-orange-700">Informasi terbaru dari pihak sekolah.</p>
      </div>

      <ol class="relative border-l-4 border-orange-200 pl-6">
        @foreach ([
          ['judul'=>'Lomba Desain Web Antar SMK','tgl'=>'18 Oktober 2025','isi'=>'Segera daftarkan tim kalian di ruang TU.'],
          ['judul'=>'Libur Maulid Nabi','tgl'=>'22 Oktober 2025','isi'=>'Kegiatan KBM ditiadakan selama 1 hari.'],
          ['judul'=>'Try Out Akhir Semester','tgl'=>'5 November 2025','isi'=>'Dilaksanakan di ruang LAB RPL.'],
        ] as $p)
        <li class="mb-10 relative">
          <span class="absolute -left-4 flex items-center justify-center w-8 h-8 bg-orange-100 rounded-full">
            <i class="ri-notification-2-line text-orange-600"></i>
          </span>
          <div class="bg-orange-50 hover:bg-orange-100 p-5 rounded-3xl shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between mb-2">
              <h3 class="font-semibold text-lg">{{ $p['judul'] }}</h3>
              <time class="text-sm text-orange-700">{{ $p['tgl'] }}</time>
            </div>
            <p class="text-sm">{{ $p['isi'] }}</p>
          </div>
        </li>
        @endforeach
      </ol>

      <div class="text-center mt-10">
        <a href="#" class="inline-flex items-center gap-2 px-6 py-3 bg-orange-600 text-white rounded-2xl hover:bg-orange-700 transition">
          <span>Lihat Semua Pengumuman</span>
          <i class="ri-arrow-right-line"></i>
        </a>
      </div>
    </div>
  </section>

  <!-- === Footer === -->
  <footer class="bg-orange-600 text-white py-6 text-center text-sm tracking-wide">
    © 2025 SMK Prestasi Prima — Sistem Akademik SIAKAD Student Portal
  </footer>

  <script>
    const button = document.getElementById('dropdownButton');
    const menu = document.getElementById('dropdownMenu');
    button.addEventListener('click', () => menu.classList.toggle('hidden'));
    document.addEventListener('click', (e) => {
      if (!button.contains(e.target) && !menu.contains(e.target)) menu.classList.add('hidden');
    });
  </script>

</body>
</html>
