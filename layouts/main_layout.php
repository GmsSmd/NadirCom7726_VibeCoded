<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'NadirCom7726' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e40af', // blue-800
                        secondary: '#1e293b', // slate-800
                        accent: '#3b82f6', // blue-500
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar for glassmorphism feel */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9; 
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <?php 
    if (isset($navbarFile) && file_exists(__DIR__ . '/' . $navbarFile)) {
        include __DIR__ . '/' . $navbarFile;
    } else {
    ?>
    <nav class="bg-white shadow-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-primary">NadirCom7726</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <?php } ?>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php echo $content ?? ''; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-500">
                &copy; <?= date('Y') ?> NadirCom7726. All rights reserved. Vibe Coded.
            </p>
        </div>
    </footer>

</body>
</html>
