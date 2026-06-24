<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PT. Yoko Fastener Indonesia — Produsen Baut &amp; Mur Presisi</title>
<meta name="description" content="PT. Yoko Fastener Indonesia — produsen baut, mur, dan komponen pengikat logam berkualitas tinggi untuk industri otomotif, konstruksi, dan manufaktur di Tangerang, Banten.">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=JetBrains+Mono:wght@400;500;700&family=Work+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/index-style.css') }}">
</head>
<body>

<!-- ===== Header ===== -->
<header id="siteHeader">
  <div class="nav">
    <a href="#beranda" class="brand">
      <img src="{{ asset('/images/LogoYoko.png') }}" alt="Logo PT. Yoko Fastener Indonesia" class="brand-mark">
      <span class="brand-text">
        <strong>PT. Yoko Fastener</strong>
        <span>BOLTS &amp; SCREWS</span>
      </span>
    </a>

    <nav class="nav-links">
      <a href="#tentang">Tentang</a>
      <a href="#visi-misi">Visi &amp; Misi</a>
      <a href="#fasilitas">Fasilitas</a>
      <a href="#produk">Produk</a>
      <a href="#kontak">Kontak</a>
    </nav>

    <div class="nav-actions">
      <a href="{{ route('login') }}" class="btn btn-login">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        Masuk
      </a>
      <a href="#kontak" class="btn btn-primary">Hubungi Kami</a>
      <button class="burger" id="burgerBtn" aria-label="Buka menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</header>

<!-- mobile nav -->
<div class="mobile-nav" id="mobileNav">
  <a href="#tentang">Tentang</a>
  <a href="#visi-misi">Visi &amp; Misi</a>
  <a href="#fasilitas">Fasilitas</a>
  <a href="#produk">Produk</a>
  <a href="#kontak">Kontak</a>
  <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
</div>

<!-- ===== Hero ===== -->
<section class="hero" id="beranda">
  <div class="hero-bg"></div>
  <div class="hero-scrim"></div>
  <div class="hero-stripe"></div>
  <div class="hero-inner">
    <div class="hero-content">
      <div class="eyebrow">Company Profile — Bolts &amp; Screws</div>
      <h1>Mengikat <em>Kekuatan</em><br>Industri Indonesia</h1>
      <p class="hero-sub">PT. Yoko Fastener Indonesia memproduksi baut, mur, dan komponen pengikat logam presisi tinggi untuk mendukung kebutuhan industri otomotif, konstruksi, dan manufaktur nasional.</p>
      <div class="hero-cta">
        <a href="#produk" class="btn btn-primary">Lihat Produk Kami</a>
        <a href="#tentang" class="btn btn-ghost">Profil Perusahaan</a>
      </div>

      <div class="hero-stats">
        <div>
          <div class="num" data-count="2800"><span class="val">0</span><span class="unit">M²</span></div>
          <div class="label">Luas Pabrik</div>
        </div>
        <div>
          <div class="num"><span class="val" data-count="7">0</span><span class="unit">Unit</span></div>
          <div class="label">Mesin Produksi</div>
        </div>
        <div>
          <div class="num"><span class="val" data-count="200">0</span><span class="unit">Ton/bln</span></div>
          <div class="label">Total Produksi</div>
        </div>
      </div>
    </div>
  </div>
  <div class="scroll-cue"><span>Scroll</span><span class="line"></span></div>
</section>

<div class="thread"></div>

<!-- ===== Salam Pembuka ===== -->
<section class="bg-ink" id="salam">
  <div class="wrap intro reveal">
    <div>
      <div class="intro-quote">
        <span class="quote-mark">&rdquo;</span>
        Kami adalah perusahaan manufaktur baut dan mur yang berkomitmen menghadirkan produk berkualitas tinggi untuk mendukung kebutuhan industri nasional.
      </div>
      <div class="badge-row">
        <span class="badge">Efficient</span>
        <span class="badge">Reliable</span>
        <span class="badge">Transparent</span>
        <span class="badge">Innovative</span>
      </div>
    </div>
    <div class="intro-photo">
      <img src="{{ asset('/images/factory-closeup.png') }}" alt="Mesin produksi baut PT Yoko Fastener" loading="lazy">
      <span class="tag mono">CNC THREAD ROLLING — UNIT 02</span>
    </div>
  </div>
</section>

<!-- ===== Tentang Perusahaan ===== -->
<section class="bg-soft" id="tentang">
  <div class="wrap">
    <div class="split reverse reveal">
      <div class="split-media">
        <img src="{{ asset('/images/factory-hero.png') }}" alt="Fasilitas produksi PT Yoko Fastener" loading="lazy">
      </div>
      <div class="split-text">
        <div class="kicker">Tentang Perusahaan</div>
        <h2 style="font-size:clamp(28px,3.6vw,42px);color:var(--paper);margin-bottom:24px;">Mitra Pengikat Logam Terpercaya</h2>
        <p>PT Yoko Fastener adalah perusahaan manufaktur yang memproduksi baut, mur, dan komponen pengikat logam untuk berbagai kebutuhan industri. Kami berkomitmen menyediakan produk yang berkualitas, presisi, dan terpercaya dengan dukungan teknologi modern dan tenaga kerja berpengalaman.</p>
        <p>Dengan menjaga kualitas, ketepatan, dan pelayanan terbaik, kami terus berupaya menjadi mitra terpercaya bagi pelanggan di seluruh Indonesia.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== Visi & Misi ===== -->
<section class="vm" id="visi-misi">
  <div class="vm-stripe"></div>
  <div class="wrap">
    <div class="vm-grid reveal">
      <div class="vm-card">
        <div class="kicker">Visi</div>
        <h3>Terdepan &amp; Terpercaya</h3>
        <p class="lead">Menjadi produsen baut dan mur terdepan yang mengikat kekuatan industri Indonesia melalui kualitas unggul, inovasi berkelanjutan, dan kepercayaan tanpa batas.</p>
      </div>
      <div class="vm-card">
        <div class="kicker">Misi</div>
        <ul class="misi-list">
          <li>
            <span class="misi-num">1</span>
            <p>Memproduksi baut dan mur berkualitas tinggi dengan teknologi modern dan sistem manajemen mutu yang konsisten.</p>
          </li>
          <li>
            <span class="misi-num">2</span>
            <p>Mengutamakan presisi dan ketahanan produk agar mampu memenuhi kebutuhan berbagai sektor industri seperti otomotif, konstruksi, dan manufaktur.</p>
          </li>
          <li>
            <span class="misi-num">3</span>
            <p>Menerapkan sistem produksi yang efisien dan ramah lingkungan, guna mendukung keberlanjutan usaha jangka panjang.</p>
          </li>
          <li>
            <span class="misi-num">4</span>
            <p>Meningkatkan daya saing melalui inovasi dalam desain, material, dan proses manufaktur.</p>
          </li>
          <li>
            <span class="misi-num">5</span>
            <p>Menjaga komitmen terhadap kualitas, waktu pengiriman, dan kepuasan pelanggan sebagai prioritas utama perusahaan.</p>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<div class="thread flip"></div>

<!-- ===== Fasilitas ===== -->
<section class="bg-soft" id="fasilitas">
  <div class="wrap">
    <div class="facility-wrap reveal">
      <div class="facility-media">
        <img src="{{ asset('/images/factory-hero.png') }}" alt="Fasilitas produksi PT Yoko Fastener" loading="lazy">
      </div>
      <div>
        <div class="kicker">Fasilitas Perusahaan</div>
        <h2 style="font-size:clamp(28px,3.6vw,42px);color:var(--paper);margin-bottom:18px;">Lini Produksi Berstandar Industri</h2>
        <p style="color:var(--paper-dim);font-size:16px;line-height:1.75;">Memiliki luas 2.800 m² dengan jumlah mesin sebanyak 7 unit dan total kapasitas produksi mencapai 200 ton per bulan.</p>

        <ul class="equip-list">
          <li><span class="eq-num">01</span> Lathe</li>
          <li><span class="eq-num">02</span> Wire EDM</li>
          <li><span class="eq-num">03</span> Surface Grinder</li>
          <li><span class="eq-num">04</span> Forklift</li>
        </ul>

        <div class="fact-stats">
          <div class="stat"><div class="num">2.800</div><div class="label">M² Area</div></div>
          <div class="stat"><div class="num">7</div><div class="label">Unit Mesin</div></div>
          <div class="stat"><div class="num">200 Ton</div><div class="label">/ Bulan</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== Kenapa Pilih Kami ===== -->
<section class="bg-ink" id="kenapa">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="kicker">Keunggulan</div>
      <h2>Kenapa Pilih Kami?</h2>
    </div>
  </div>
  <div class="wrap" style="padding:0;">
    <div class="why-grid reveal-stagger">
      <div class="why-card">
        <svg class="why-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6l8-4z"/><path d="M9 12l2 2 4-4"/></svg>
        <h4>Kualitas Terjamin</h4>
        <p>Produk kami diproduksi dengan bahan baku pilihan dan melalui proses kontrol kualitas yang ketat.</p>
      </div>
      <div class="why-card">
        <svg class="why-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3"/><path d="M12 3v3M12 18v3M3 12h3M18 12h3"/></svg>
        <h4>Presisi Tinggi</h4>
        <p>Menggunakan mesin dan teknologi modern untuk menghasilkan baut dan mur dengan tingkat akurasi maksimal.</p>
      </div>
      <div class="why-card">
        <svg class="why-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        <h4>Pengalaman &amp; Keahlian</h4>
        <p>Didukung oleh tim berpengalaman di bidang manufaktur logam dan teknik industri.</p>
      </div>
      <div class="why-card">
        <svg class="why-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="1.8"/><circle cx="18.5" cy="18.5" r="1.8"/></svg>
        <h4>Ketepatan Waktu Pengiriman</h4>
        <p>Komitmen kami adalah memastikan setiap pesanan dikirim sesuai jadwal dan kebutuhan pelanggan.</p>
      </div>
    </div>
  </div>
</section>

<div class="thread"></div>

<!-- ===== Produk ===== -->
<section class="bg-ink" id="produk">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="kicker">Katalog</div>
      <h2>Produk Kami</h2>
      <p>Empat lini produk utama yang kami produksi, dengan opsi material dan ukuran sesuai kebutuhan proyek Anda.</p>
    </div>

    <div class="prod-grid reveal-stagger">
      <div class="prod-card">
        <span class="prod-card-tag mono">01</span>
        <img src="{{ asset('/images/product-Self Tapping Screws.png') }}" alt="Self-Tapping Screws" loading="lazy">
        <div class="prod-card-overlay"><h4>Self-Tapping Screws</h4></div>
        <div class="prod-card-cta"><span>Hubungi Kami</span></div>
      </div>
      <div class="prod-card">
        <span class="prod-card-tag mono">02</span>
        <img src="{{ asset('/images/product-Self Drilling Screws.png') }}" alt="Self-Drilling Screws" loading="lazy">
        <div class="prod-card-overlay"><h4>Self-Drilling Screws</h4></div>
        <div class="prod-card-cta"><span>Hubungi Kami</span></div>
      </div>
      <div class="prod-card">
        <span class="prod-card-tag mono">03</span>
        <img src="{{ asset('/images/product-Machine Screws.png') }}" alt="Machine Screws" loading="lazy">
        <div class="prod-card-overlay"><h4>Machine Screws</h4></div>
        <div class="prod-card-cta"><span>Hubungi Kami</span></div>
      </div>
      <div class="prod-card">
        <span class="prod-card-tag mono">04</span>
        <img src="{{ asset('/images/product-Hex Bolts.png') }}" alt="Hex Bolts" loading="lazy">
        <div class="prod-card-overlay"><h4>Hex Bolts &amp; Nuts</h4></div>
        <div class="prod-card-cta"><span>Hubungi Kami</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ===== Kontak ===== -->
<section class="bg-soft" id="kontak">
  <div class="wrap">
    <div class="section-head reveal">
      <div class="kicker">Hubungi Kami</div>
      <h2>Mari Berdiskusi Kebutuhan Anda</h2>
    </div>

    <div class="contact-wrap reveal">
      <div class="contact-info">
        <h3>PT. Yoko Fastener Indonesia</h3>

        <div class="contact-item">
          <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.36 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          <div><div class="ctitle">Telepon</div><div class="cval">0822-2728-6666</div></div>
        </div>

        <div class="contact-item">
          <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16v16H4z" opacity="0"/><path d="M22 6 12 13 2 6"/><path d="M2 6h20v12H2z"/></svg>
          <div><div class="ctitle">Email</div><div class="cval">ronnysutanto68@gmail.com</div></div>
        </div>

        <div class="contact-item">
          <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          <div><div class="ctitle">Alamat Pabrik</div><div class="cval">Jl. Kalisabi I No.99, RT.002/RW.011, Uwung Jaya, Kec. Cibodas, Kota Tangerang, Banten 15138</div></div>
        </div>

        <div style="margin-top:30px;display:flex;gap:12px;flex-wrap:wrap;">
          <a href="https://wa.me/6282227286666" target="_blank" rel="noopener" class="btn btn-primary">Chat WhatsApp</a>
          <a href="mailto:ronnysutanto68@gmail.com" class="btn btn-ghost">Kirim Email</a>
        </div>
      </div>
      <div class="contact-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15866.175380371533!2d106.58989283305614!3d-6.191735069405415!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ff005e9d4049%3A0x4a9244e4800a0eaa!2sPT.%20Yoko%20Fastener%20Indonesia!5e0!3m2!1sid!2sid!4v1781882196093!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lokasi PT Yoko Fastener Indonesia"></iframe>
      </div>
    </div>
  </div>
</section>

<!-- ===== Footer ===== -->
<footer>
  <div class="wrap">
    <div class="foot-grid">
      <div>
        <div class="foot-brand">
          <img src="{{ asset('/images/LogoYoko.png') }}" alt="Logo PT. Yoko Fastener Indonesia" class="brand-mark">
          <strong>PT. Yoko Fastener</strong>
        </div>
        <p class="foot-desc">Produsen baut, mur, dan komponen pengikat logam presisi tinggi untuk kebutuhan industri di seluruh Indonesia.</p>
      </div>
      <div class="foot-col">
        <h5>Navigasi</h5>
        <ul>
          <li><a href="#tentang">Tentang Perusahaan</a></li>
          <li><a href="#visi-misi">Visi &amp; Misi</a></li>
          <li><a href="#fasilitas">Fasilitas</a></li>
          <li><a href="#produk">Produk</a></li>
        </ul>
      </div>
      <div class="foot-col">
        <h5>Kontak</h5>
        <ul>
          <li><a href="tel:082227286666">0822-2728-6666</a></li>
          <li><a href="mailto:ronnysutanto68@gmail.com">ronnysutanto68@gmail.com</a></li>
          <li><a href="{{ route('login') }}">Masuk ke Akun</a></li>
        </ul>
      </div>
    </div>
    <div class="foot-bottom">
      <p>&copy; {{ date('Y') }} PT. Yoko Fastener Indonesia. Seluruh hak cipta dilindungi.</p>
      <a href="#beranda" class="back-to-top" aria-label="Kembali ke atas">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="19" x2="12" y2="5"/><polyline points="5 12 12 5 19 12"/></svg>
      </a>
    </div>
  </div>
</footer>

<script>
// Sticky header background shift + active link highlight
const header = document.getElementById('siteHeader');
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.nav-links a');

window.addEventListener('scroll', () => {
  header.style.background = window.scrollY > 40 ? 'rgba(11,11,12,.96)' : 'rgba(11,11,12,.86)';
  let current = '';
  sections.forEach(sec => {
    const top = sec.offsetTop - 120;
    if (window.scrollY >= top) current = sec.getAttribute('id');
  });
  navLinks.forEach(a => {
    a.classList.toggle('active', a.getAttribute('href') === '#' + current);
  });
}, { passive: true });

// Mobile nav toggle
const burger = document.getElementById('burgerBtn');
const mobileNav = document.getElementById('mobileNav');
burger.addEventListener('click', () => {
  const open = mobileNav.classList.toggle('open');
  burger.classList.toggle('open', open);
  burger.setAttribute('aria-expanded', open);
  document.body.style.overflow = open ? 'hidden' : '';
});
mobileNav.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
  mobileNav.classList.remove('open');
  burger.classList.remove('open');
  document.body.style.overflow = '';
}));

// Scroll reveal
const revealEls = document.querySelectorAll('.reveal, .reveal-stagger');
const io = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('in');
      io.unobserve(entry.target);
    }
  });
}, { threshold: 0.15 });
revealEls.forEach(el => io.observe(el));

// Animated stat counters
const counters = document.querySelectorAll('[data-count]');
const animateCount = (el) => {
  const target = +el.getAttribute('data-count');
  const valEl = el.classList.contains('val') ? el : el.querySelector('.val');
  if (!valEl) return;
  let cur = 0;
  const step = Math.max(1, Math.ceil(target / 60));
  const tick = () => {
    cur += step;
    if (cur >= target) { valEl.textContent = target.toLocaleString('id-ID'); return; }
    valEl.textContent = cur.toLocaleString('id-ID');
    requestAnimationFrame(tick);
  };
  tick();
};
const statIo = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      animateCount(entry.target);
      statIo.unobserve(entry.target);
    }
  });
}, { threshold: 0.5 });
counters.forEach(el => statIo.observe(el));
</script>
</body>
</html>