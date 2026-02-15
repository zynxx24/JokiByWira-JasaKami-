document.addEventListener('DOMContentLoaded', () => {

    const navbar = document.getElementById('navbar');
    if (navbar) {
        const handleNavbarScroll = () => {
            if (window.scrollY > 50) {
                navbar.classList.add('bg-white/95', 'backdrop-blur-xl', 'shadow-lg', 'shadow-black/5');
                navbar.classList.remove('bg-transparent');
                navbar.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('text-white/90', 'hover:text-white');
                    link.classList.add('text-gray-700', 'hover:text-brand-dark');
                    link.classList.remove('after:bg-white');
                    link.classList.add('after:bg-brand-dark');
                });
                const logoText = navbar.querySelector('a > span');
                if (logoText) {
                    logoText.classList.remove('text-white');
                    logoText.classList.add('text-gray-800');
                }
                const loginBtn = navbar.querySelector('a[href="login.html"].px-6');
                if (loginBtn) {
                    loginBtn.classList.remove('bg-white', 'text-brand-dark', 'hover:bg-mint-50');
                    loginBtn.classList.add('bg-gradient-to-r', 'from-brand', 'to-brand-dark', 'text-white');
                }
                navbar.querySelectorAll('#mobile-menu-btn span').forEach(bar => {
                    bar.classList.remove('bg-white');
                    bar.classList.add('bg-gray-700');
                });
            } else {
                navbar.classList.remove('bg-white/95', 'backdrop-blur-xl', 'shadow-lg', 'shadow-black/5');
                navbar.classList.add('bg-transparent');
                navbar.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.add('text-white/90', 'hover:text-white');
                    link.classList.remove('text-gray-700', 'hover:text-brand-dark');
                    link.classList.add('after:bg-white');
                    link.classList.remove('after:bg-brand-dark');
                });
                const logoText = navbar.querySelector('a > span');
                if (logoText) {
                    logoText.classList.add('text-white');
                    logoText.classList.remove('text-gray-800');
                }
                const loginBtn = navbar.querySelector('a[href="login.html"].px-6');
                if (loginBtn) {
                    loginBtn.classList.add('bg-white', 'text-brand-dark', 'hover:bg-mint-50');
                    loginBtn.classList.remove('bg-gradient-to-r', 'from-brand', 'to-brand-dark', 'text-white');
                }
                navbar.querySelectorAll('#mobile-menu-btn span').forEach(bar => {
                    bar.classList.add('bg-white');
                    bar.classList.remove('bg-gray-700');
                });
            }
        };
        window.addEventListener('scroll', handleNavbarScroll, { passive: true });
        handleNavbarScroll();
    }
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const bars = mobileMenuBtn.querySelectorAll('span');
            if (!mobileMenu.classList.contains('hidden')) {
                bars[0].classList.add('rotate-45', 'translate-y-2');
                bars[1].classList.add('opacity-0');
                bars[2].classList.add('-rotate-45', '-translate-y-2');
            } else {
                bars[0].classList.remove('rotate-45', 'translate-y-2');
                bars[1].classList.remove('opacity-0');
                bars[2].classList.remove('-rotate-45', '-translate-y-2');
            }
        });
        mobileMenu.querySelectorAll('.mobile-link').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                const bars = mobileMenuBtn.querySelectorAll('span');
                bars[0].classList.remove('rotate-45', 'translate-y-2');
                bars[1].classList.remove('opacity-0');
                bars[2].classList.remove('-rotate-45', '-translate-y-2');
            });
        });
    }
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const targetId = anchor.getAttribute('href');
            if (targetId === '#') return;
            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                const navHeight = navbar ? navbar.offsetHeight : 0;
                const targetPosition = target.getBoundingClientRect().top + window.scrollY - navHeight - 20;
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -60px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100', 'translate-y-0');
                entry.target.classList.remove('opacity-0', 'translate-y-8');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    document.querySelectorAll('#layanan > div > div.group').forEach((section, index) => {
        section.classList.add('opacity-0', 'translate-y-8', 'transition-all', 'duration-700');
        section.style.transitionDelay = `${index * 150}ms`;
        observer.observe(section);
    });
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            if (eyeOpen && eyeClosed) {
                eyeOpen.classList.toggle('hidden');
                eyeClosed.classList.toggle('hidden');
            }
        });
    }
    const loginForm = document.getElementById('login-form');
    const errorMessage = document.getElementById('error-message');
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = document.getElementById('email');
            const password = document.getElementById('password');

            [email, password].forEach(input => {
                input.classList.remove('border-red-400', 'bg-red-50/50');
            });
            if (errorMessage) errorMessage.classList.add('hidden');

            let errors = [];
            if (!email.value.trim()) {
                errors.push('Email wajib diisi');
                email.classList.add('border-red-400', 'bg-red-50/50');
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                errors.push('Format email tidak valid');
                email.classList.add('border-red-400', 'bg-red-50/50');
            }
            if (!password.value.trim()) {
                errors.push('Password wajib diisi');
                password.classList.add('border-red-400', 'bg-red-50/50');
            } else if (password.value.length < 6) {
                errors.push('Password minimal 6 karakter');
                password.classList.add('border-red-400', 'bg-red-50/50');
            }

            if (errors.length > 0) {
                if (errorMessage) {
                    errorMessage.textContent = errors.join(' • ');
                    errorMessage.classList.remove('hidden');
                }
                return;
            }

            const loginBtn = document.getElementById('login-btn');
            if (loginBtn) {
                loginBtn.innerHTML = `
                    <svg class="animate-spin h-5 w-5 mx-auto text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>`;
                loginBtn.disabled = true;
            }

            setTimeout(() => {
                alert('Login berhasil! (Demo)');
                if (loginBtn) {
                    loginBtn.innerHTML = 'Login';
                    loginBtn.disabled = false;
                }
                loginForm.reset();
            }, 1500);
        });
    }
    const rememberCheckbox = document.getElementById('remember');
    if (rememberCheckbox) {
        const checkboxContainer = rememberCheckbox.closest('label');
        if (checkboxContainer) {
            const checkIcon = checkboxContainer.querySelector('svg');
            rememberCheckbox.addEventListener('change', () => {
                if (checkIcon) {
                    checkIcon.classList.toggle('opacity-0', !rememberCheckbox.checked);
                    checkIcon.classList.toggle('opacity-100', rememberCheckbox.checked);
                }
            });
        }
    }

});