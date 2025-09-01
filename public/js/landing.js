document.addEventListener("DOMContentLoaded", () => {
    const hamburger = document.getElementById("hamburger");
    const navMenu = document.getElementById("nav-menu");

    hamburger.addEventListener("click", () => {
        navMenu.classList.toggle("active");
    });

    const dropdownToggle = document.querySelector(".dropdown-toggle");

    dropdownToggle.addEventListener("click", (event) => {
        if (window.getComputedStyle(hamburger).display === "block") {
            event.preventDefault();
            const dropdownMenu = dropdownToggle.nextElementSibling;
            dropdownMenu.classList.toggle("active");
        }
    });

    const navLinks = document.querySelectorAll(".nav-menu a");
    navLinks.forEach((link) => {
        if (!link.classList.contains("dropdown-toggle")) {
            link.addEventListener("click", () => {
                if (navMenu.classList.contains("active")) {
                    navMenu.classList.remove("active");
                }
            });
        }
    });

    // JAVASCRIPT BARU UNTUK ANIMASI SCROLL
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                }
            });
        },
        {
            threshold: 0.1, // Muncul saat 10% elemen terlihat
        }
    );

    const elementsToReveal = document.querySelectorAll(".reveal");
    elementsToReveal.forEach((el) => {
        observer.observe(el);
    });
});

// ... (JavaScript Anda yang sudah ada, misal untuk hamburger menu) ...

// --- LOGIKA UNTUK TOMBOL SCROLL TO TOP ---
document.addEventListener("DOMContentLoaded", () => {
    // Ambil elemen tombol
    const scrollToTopBtn = document.getElementById("scrollToTopBtn");

    // Tampilkan tombol jika user scroll lebih dari 300px ke bawah
    window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
            scrollToTopBtn.classList.add("show");
        } else {
            scrollToTopBtn.classList.remove("show");
        }
    });

    // Saat tombol di-klik, scroll halaman ke paling atas
    scrollToTopBtn.addEventListener("click", (e) => {
        e.preventDefault(); // Mencegah link '#' mengubah URL

        window.scrollTo({
            top: 0,
            behavior: "smooth", // Efek scroll halus
        });
    });
});
