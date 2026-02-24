<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= htmlspecialchars($pageTitle ?? 'JasaKami') ?>
    </title>
    <meta name="description" content="Pencari Daily Worker profesional — layanan perhotelan, kuliner, dan PPLG.">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            safelist: [
                'text-brand', 'text-brand-dark', 'text-mint-400', 'text-purple-400', 'text-yellow-400',
                'bg-brand', 'bg-brand-dark', 'bg-mint-400', 'bg-purple-400', 'bg-yellow-400',
                'from-brand', 'to-brand-dark', 'via-mint-400',
                'from-emerald-500', 'to-teal-600',
                'from-orange-500', 'to-red-500',
                'from-violet-500', 'to-purple-600',
                'text-pink-600', 'bg-pink-100',
                'text-blue-600', 'bg-blue-100'
            ],
            theme: {
                extend: {
                    colors: {
                        mint: {
                            50: '#f0fdf9',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                        },
                        brand: {
                            light: '#6ee7b7', // Emerald 300
                            DEFAULT: '#34d399', // Emerald 400
                            dark: '#10b981', // Emerald 500
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    keyframes: {
                        fadeUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideRight: {
                            '0%': { opacity: '0', transform: 'translateX(-40px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-15px)' },
                        },
                        scaleIn: {
                            '0%': { opacity: '0', transform: 'scale(0.8)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-200% 0' },
                            '100%': { backgroundPosition: '200% 0' },
                        }
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.7s ease-out forwards',
                        'fade-in': 'fadeIn 0.6s ease-out forwards',
                        'slide-right': 'slideRight 0.7s ease-out forwards',
                        'float': 'float 4s ease-in-out infinite',
                        'scale-in': 'scaleIn 0.5s ease-out forwards',
                        'shimmer': 'shimmer 2s linear infinite',
                    }
                }
            }
        }
    </script>
    <link rel="icon" type="image/png" href="/assets/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body class="font-sans bg-white text-gray-800 overflow-x-hidden min-h-screen flex flex-col">

    <?php include __DIR__ . '/partials/navbar.php'; ?>

    <main class="flex-1">
        <?= $content ?? '' ?>
    </main>

    <?php include __DIR__ . '/partials/footer.php'; ?>

    <script src="/assets/js/app.js"></script>
</body>

</html>