@extends('layouts.landing')

@section('title', 'GriskaNutri')

@section('content')


      <section class="hero" id="home">
        <div class="container">
          <div class="hero-content">
            <h1 class="animated fade-in-up" style="animation-delay: 0.2s">
              Digitalisasi Program Sekolah Perempuan GRISKA
            </h1>
            <p class="animated fade-in-up" style="animation-delay: 0.4s">
              Memberdayakan perempuan Kelurahan Purbayan melalui edukasi
              kesehatan, pencegahan stunting, dan kemandirian ekonomi untuk
              membangun masa depan keluarga yang lebih cerah dan sejahtera.
            </p>
            <a
              href="#proker"
              class="btn animated fade-in-up"
              style="animation-delay: 0.6s"
              >Jelajahi Program Kami</a
            >
          </div>
          <div
            class="hero-image animated fade-in"
            style="animation-delay: 0.8s"
          >
            <div class="placeholder">
              <img
                src="{{ asset('images/img/sosialisasi-ibu-pkk.jpg') }}"
                alt="Sekolah Perempuan GRISKA"
                style="
                  width: 100%;
                  height: 100%;
                  object-fit: cover;
                  border-radius: 8px;
                "
              />
            </div>
          </div>
        </div>
      </section>

      <section class="proker" id="proker">
        <div class="container">
          <h2 class="section-title reveal">Fitur Unggulan</h2>
          <p class="section-subtitle reveal">
            Website ini menyediakan
            <strong>berbagai fitur digital</strong> untuk mendukung program
            Sekolah Perempuan "GRISKA". Akses materi pembelajaran, resep
            inovatif, dan panduan pemasaran untuk meningkatkan
            <strong>pengetahuan dan keterampilan</strong> Anda secara mandiri.
          </p>
          <div class="proker-grid">
            <div class="proker-card reveal">
              <div class="icon">📚</div>
              <h3>Kurikulum SEHATI</h3>
              <p>
                Akses modul pembelajaran lengkap dari kurikulum "SEHATI" (Sehat,
                Harmonis, dan Terampil Inovatif) yang mencakup materi gizi,
                kesehatan ibu & anak, serta pola asuh.
              </p>
              <br />
              <a
                href="{{ route('kurikulum.index') }}"
                class="btn animated fade-in-up"
                style="animation-delay: 0.6s"
                >Akses Kurikulum</a
              >
            </div>
            <div class="proker-card reveal" style="transition-delay: 0.2s">
              <div class="icon">🍲</div>
              <h3>Inovasi Produk Anti-Stunting</h3>
              <p>
                Temukan resep dan panduan langkah demi langkah untuk membuat
                produk olahan sehat dan bernilai ekonomi, seperti nugget daun
                kelor dan siomay lele, langsung dari dapur Anda.
              </p>
              <br />
              <a
                href="{{ route('resep.index') }}"
                class="btn animated fade-in-up"
                style="animation-delay: 0.6s"
                >Lihat Resep</a
              >
            </div>
            <div class="proker-card reveal" style="transition-delay: 0.4s">
              <div class="icon">🧮</div>
              <h3>Kalkulator Stunting</h3>
              <p>
                Gunakan fitur kalkulator untuk memantau tumbuh kembang anak.
                Masukkan data tinggi dan berat badan untuk mengetahui status
                gizi dan mendeteksi risiko stunting secara dini.
              </p>
              <br />
              <a
                href="#proker"
                class="btn animated fade-in-up"
                style="animation-delay: 0.6s"
                >Cek Status Stunting</a
              >
            </div>
          </div>
        </div>
      </section>

      <section class="desa" id="desa">
        <div class="container desa-grid reveal">
          <div class="desa-content">
            <h2>Profil Kelurahan Purbayan</h2>
            <p>
              Kelurahan Purbayan terletak di Kemantren Kotagede, Kota
              Yogyakarta, sebuah kawasan yang kaya akan sejarah dan budaya.
              Dengan luas wilayah 0,83 km², Purbayan menjadi rumah bagi 10.549
              jiwa yang tersebar di 14 Rukun Warga (RW) dan 58 Rukun Tetangga
              (RT).
            </p>
            <p>
              Purbayan memiliki beragam potensi unggulan, mulai dari kerajinan
              perak yang melegenda, wisata cagar budaya, hingga berbagai UMKM
              dan kuliner khas seperti kue kembang waru. Potensi sumber daya
              manusia yang besar menjadi modal utama untuk terus mengembangkan
              kelurahan ini menjadi lebih maju dan sejahtera.
            </p>
          </div>
          <div class="desa-image">
            <div class="placeholder" style="padding:0;">
              <img
                src="{{ asset('images/img/kelurahan-purbayan.jpg') }}"
                alt="Desa Purbayan"
                style="width:100%; height:100%; object-fit:cover; border-radius:8px;"
              />
            </div>
          </div>
        </div>
      </section>

      <section class="gallery" id="galeri">
        <div class="container">
          <h2 class="section-title reveal">Galeri Kegiatan GRISKA</h2>
          <div class="gallery-grid reveal">
            <div class="gallery-item">
              <img
                src="{{ asset('images/img/sosialisasi-kelompok-sasaran.JPG') }}"
                alt="Sosialisasi Kelompok Sasaran"
              />
              <div class="overlay"><h3>Sosialisasi Kelompok Sasaran</h3></div>
            </div>
            <div class="gallery-item">
              <img
                src="{{ asset('images/img/pembukaan-sekolah-perempuan-griska.jpg') }}"
                alt="Pembukaan Sekolah Perempuan GRISKA"
              />
              <div class="overlay">
                <h3>Pembukaan Sekolah Perempuan GRISKA</h3>
              </div>
            </div>
            <div class="gallery-item">
              <img
                src="{{ asset('images/img/fgd-materi-pencegahan-stunting.JPG') }}"
                alt="FGD Materi Pencegahan Stunting"
              />
              <div class="overlay"><h3>FGD Materi Pencegahan Stunting</h3></div>
            </div>
            <div class="gallery-item">
              <img
                src="{{ asset('images/img/pembuatan-pohon-harapan.jpg') }}"
                alt="Pembuatan Pohon Harapan"
              />
              <div class="overlay"><h3>Pembuatan Pohon Harapan</h3></div>
            </div>
            <div class="gallery-item">
              <img
                src="{{ asset('images/img/isi-piringku.JPG') }}"
                alt="Isi Piringku"
              />
              <div class="overlay"><h3>Isi Piringku</h3></div>
            </div>
            <div class="gallery-item">
              <img
                src="{{ asset('images/img/praktik-materi-isi-piringku.JPG') }}"
                alt="Praktik Materi Isi Piringku"
              />
              <div class="overlay"><h3>Praktik Materi Isi Piringku</h3></div>
            </div>
            <div class="gallery-item">
              <img
                src="{{ asset('images/img/materi-isi-piringku.JPG') }}"
                alt="Materi Isi Piringku"
              />
              <div class="overlay"><h3>Materi Isi Piringku</h3></div>
            </div>
            <div class="gallery-item">
              <img
                src="{{ asset('images/img/presentasi-hasil-praktik-isi-piringku.JPG') }}"
                alt="Presentasi Hasil Praktik Isi Piringku"
              />
              <div class="overlay"><h3>Presentasi Hasil Praktik Isi Piringku</h3></div>
            </div>
            <div class="gallery-item">
              <img
                src="{{ asset('images/img/memasukkan-adonan-siomay-lele.JPG') }}"
                alt="Proses Memasukkan Adonan Siomay Lele"
              />
              <div class="overlay"><h3>Proses Memasukkan Adonan Siomay Lele</h3></div>
            </div>
            <div class="gallery-item">
              <img
                src="{{ asset('images/img/proses-memasak-siomay-lele.JPG') }}"
                alt="Proses Memasak Siomay Lele"
              />
              <div class="overlay"><h3>Proses Memasak Siomay Lele</h3></div>
            </div>
            <div class="gallery-item">
              <img
                src="{{ asset('images/img/proses-mengukus-siomay-lele.JPG') }}"
                alt="Proses Mengukus Siomay Lele"
              />
              <div class="overlay"><h3>Proses Mengukus Siomay Lele</h3></div>
            </div>
            <div class="gallery-item">
              <img
                src="{{ asset('images/img/kelompok-satu-siomay-lele.JPG') }}"
                alt="Kelompok Satu Siomay Lele"
              />
              <div class="overlay"><h3>Kelompok Satu Siomay Lele</h3></div>
            </div>
            <div class="gallery-item">
              <img
                src="{{ asset('images/img/masakan-siomay-lele.JPG') }}"
                alt="Masakan Siomay Lele"
              />
              <div class="overlay"><h3>Masakan Siomay Lele</h3></div>
            </div>
          </div>
        </div>
      </section>

      <section class="mitra" id="mitra">
        <div class="container">
          <h2 class="section-title reveal">Mitra Kolaborasi</h2>
          <div class="mitra-grid">
            <div class="mitra-card reveal">
              <div class="mitra-logo placeholder">
                <img
                  max-width="80px"
                  src="{{ asset('images/logo/logo-pemkot-jogja.png') }}"
                  alt="Logo Pemerintah Kelurahan Purbayan"
                />
              </div>
              <h3>Pemerintah Kelurahan Purbayan</h3>
            </div>
            <div class="mitra-card reveal" style="transition-delay: 0.2s">
              <div class="mitra-logo placeholder">
                <img
                  max-width="80px"
                  src="{{ asset('images/logo/logo-pemkot-jogja.png') }}"
                  alt="Logo Dinas P3AP2KB Kota Yogyakarta"
                />
              </div>
              <h3>Dinas P3AP2KB Kota Yogyakarta</h3>
            </div>
            <div class="mitra-card reveal" style="transition-delay: 0.4s">
              <div class="mitra-logo placeholder">
                <img
                  max-width="80px"
                  src="{{ asset('images/logo/logo-pemkot-jogja.png') }}"
                  alt="Logo Dinas Kesehatan Kota Yogyakarta"
                />
              </div>
              <h3>Dinas Kesehatan Kota Yogyakarta</h3>
            </div>
            <div class="mitra-card reveal" style="transition-delay: 0.6s">
              <div class="mitra-logo placeholder">
                <img
                  max-width="80px"
                  src="{{ asset('images/logo/logo-puskesmas-kotagede.png') }}"
                  alt="Logo Puskesmas Kotagede I"
                />
              </div>
              <h3>Puskesmas Kotagede I</h3>
            </div>
            <div class="mitra-card reveal" style="transition-delay: 0.8s">
              <div class="mitra-logo placeholder">
                <img
                  max-width="80px"
                  src="{{ asset('images/logo/logo-bank-bpd-syariah.png') }}"
                  alt="Logo Bank BPD DIY Syariah Kusumanegara"
                />
              </div>
              <h3>Bank BPD DIY Syariah Kusumanegara</h3>
            </div>
            <div class="mitra-card reveal" style="transition-delay: 1.0s">
              <div class="mitra-logo placeholder">
                <img
                  max-width="80px"
                  src="{{ asset('images/logo/logo-saynana.jpg') }}"
                  alt="Logo Saynana"
                />
              </div>
              <h3>Saynana Snack & Food</h3>
            </div>
          </div>
        </div>
      </section>

      <section class="slogan reveal">
        <div class="container">
          <h2>Gerak Bersama, Berdampak Nyata</h2>
          <div class="hashtags-grid">
            <div class="hashtag-item">#GriskaPurbayan</div>
            <div class="hashtag-item">#PerempuanBerdaya</div>
            <div class="hashtag-item">#CegahStunting</div>
          </div>
        </div>
      </section>


@endsection
