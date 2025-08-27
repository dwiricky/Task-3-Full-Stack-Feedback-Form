//Highlight active navbar link
function highlightNavbarLink() {
    const navbarLinks = document.querySelectorAll('.nav-links li a');
    const fromTop = window.scrollY + window.innerHeight / 4; // Mengurangi perhitungan scroll agar tidak melewati judul section
    let activeLinkFound = false;

    navbarLinks.forEach(link => {
        const section = document.querySelector(link.getAttribute('href'));

        if (
            section.offsetTop <= fromTop &&
            section.offsetTop + section.offsetHeight > fromTop
        ) {
            link.classList.add('active');
            activeLinkFound = true;
        } else {
            link.classList.remove('active');
        }
    });
    // Jika tidak ada tautan aktif ditemukan, periksa apakah kita berada di bagian bawah halaman
    if (!activeLinkFound && (window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        navbarLinks.forEach(link => {
            const section = document.querySelector(link.getAttribute('href'));
            if (section.id === 'kontak') {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }
}

//Toogle navbar
document.addEventListener('DOMContentLoaded', highlightNavbarLink);
window.addEventListener('scroll', highlightNavbarLink);

document.addEventListener('DOMContentLoaded', function () {
    var toggler = document.querySelector('.navbar-toggler');
    var navLinks = document.querySelector('.nav-links');

    toggler.addEventListener('click', function () {
        toggler.classList.toggle('active');
        navLinks.classList.toggle('active');
    });
});