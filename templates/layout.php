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
            theme: {
                extend: {
                    colors: {
                        mint: {
                            50: '#f0fdf8',
                            100: '#dcfce9',
                            200: '#bbf7d4',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                        },
                        brand: {
                            light: '#a8f0c8',
                            DEFAULT: '#4dd9a0',
                            dark: '#2ecc71',
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