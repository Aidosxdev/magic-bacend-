<?php
require_once __DIR__ . '/includes/db.php';

// Joriy foydalanuvchi ID si (Amalda bu session yoki JWT orqali olinadi)
$user_id = filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT) ?: 1;

// 1. Foydalanuvchi ma'lumotlarini olish
$stmtUser = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmtUser->execute([$user_id]);
$user = $stmtUser->fetch();

if (!$user) {
    die("<div style='color:white; background:#080D18; padding:40px; text-align:center;'>Foydalanuvchi topilmadi.</div>");
}

// 2. Foydalanuvchi o'qiyotgan mangalar va oxirgi progressni olish
$stmtProgress = $pdo->prepare("
    SELECT m.*, c.chapter_number, rp.progress_percent, rp.updated_at 
    FROM reading_progress rp
    JOIN mangas m ON rp.manga_id = m.id
    JOIN chapters c ON rp.chapter_id = c.id
    WHERE rp.user_id = ?
    ORDER BY rp.updated_at DESC
");
$stmtProgress->execute([$user_id]);
$continueReadingList = $stmtProgress->fetchAll();

// 3. Sevimli (Favorites) mangalar ro'yxatini olish
$stmtFavorites = $pdo->prepare("
    SELECT m.* FROM favorites f
    JOIN mangas m ON f.manga_id = m.id
    WHERE f.user_id = ?
    ORDER BY f.created_at DESC
");
$stmtFavorites->execute([$user_id]);
$favoritesList = $stmtFavorites->fetchAll();
?>
<!DOCTYPE html>
<html lang="uz" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($user['username']) ?> — Shaxsiy Kabinet | Magic Manga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif'],
                    },
                    colors: {
                        mm: {
                            darkBg: '#080D18',
                            darkSurface: '#101C30',
                            darkCard: '#14233A',
                            primary: '#247BFF',
                            accent: '#64C7FF',
                        }
                    },
                    boxShadow: { 'neon': '0 0 25px rgba(36, 123, 255, 0.35)' }
                }
            }
        }
    </script>
    <style>
        .glass-nav { backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
    </style>
</head>
<body class="bg-mm-darkBg text-white antialiased min-h-screen pb-24">

    <!-- NAVIGATION BAR -->
    <header class="fixed top-4 inset-x-0 z-50 px-4 sm:px-6 lg:px-8">
        <nav class="max-w-7xl mx-auto glass-nav bg-mm-darkSurface/75 border border-mm-accent/15 rounded-2xl px-4 sm:px-6 h-16 flex items-center justify-between shadow-neon">
            <a href="index.php" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-mm-primary to-mm-accent p-0.5 shadow-neon">
                    <div class="w-full h-full bg-mm-darkBg rounded-[10px] flex items-center justify-center">
                        <svg class="w-5 h-5 text-mm-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M12 2L3 7v10l9 5 9-5V7l-9-5z"/>
                            <path d="M12 22V12"/>
                            <path d="M21 7l-9 5-9-5"/>
                        </svg>
                    </div>
                </div>
                <span class="font-display font-bold text-xl tracking-tight">
                    Magic<span class="text-mm-accent">Manga</span>
                </span>
            </a>
            <div class="flex items-center gap-3">
                <a href="index.php" class="px-4 py-2 rounded-xl bg-mm-darkCard border border-mm-accent/20 text-xs font-semibold hover:border-mm-accent transition">
                    Bosh sahifa
                </a>
            </div>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 space-y-12">

        <!-- PROFILE HEADER CARD -->
        <section class="bg-mm-darkSurface border border-mm-accent/20 rounded-3xl p-6 sm:p-8 relative overflow-hidden shadow-neon">
            <div class="absolute -right-12 -top-12 w-64 h-64 bg-mm-primary/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="flex flex-col sm:flex-row items-center gap-6 relative z-10">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80" alt="Avatar" class="w-24 h-24 rounded-2xl object-cover border-2 border-mm-accent shadow-neon">
                <div class="text-center sm:text-left">
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-1">
                        <h1 class="font-display text-2xl sm:text-3xl font-extrabold"><?= htmlspecialchars($user['username']) ?></h1>
                        <span class="px-2.5 py-0.5 rounded-full bg-mm-primary/20 border border-mm-accent/40 text-mm-accent text-xs font-bold uppercase">
                            <?= htmlspecialchars($user['role']) ?>
                        </span>
                    </div>
                    <p class="text-slate-400 text-sm mb-4"><?= htmlspecialchars($user['email']) ?></p>
                    <div class="flex flex-wrap justify-center sm:justify-start gap-4 text-xs text-slate-300">
                        <span class="px-3 py-1.5 rounded-xl bg-mm-darkCard border border-white/5">📖 O'qilganlar: <b><?= count($continueReadingList) ?></b></span>
                        <span class="px-3 py-1.5 rounded-xl bg-mm-darkCard border border-white/5">⭐ Sevimlilar: <b><?= count($favoritesList) ?></b></span>
                        <span class="px-3 py-1.5 rounded-xl bg-mm-darkCard border border-white/5">📅 Qo'shilgan: <?= date('d.m.Y', strtotime($user['created_at'])) ?></span>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTINUE READING SECTION -->
        <section>
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-display text-xl sm:text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="book-open" class="w-5 h-5 text-mm-accent"></i> Davom Etayotganlar
                </h2>
            </div>

            <?php if (!empty($continueReadingList)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <?php foreach ($continueReadingList as $item): ?>
                    <div class="bg-mm-darkCard border border-white/5 hover:border-mm-accent/50 rounded-2xl p-4 flex gap-4 items-center transition group">
                        <img src="<?= htmlspecialchars($item['cover_image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="w-16 h-22 rounded-xl object-cover shrink-0 group-hover:scale-105 transition-transform">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-sm truncate mb-1"><?= htmlspecialchars($item['title']) ?></h3>
                            <p class="text-xs text-mm-accent font-medium mb-2">Chapter <?= htmlspecialchars($item['chapter_number']) ?></p>
                            <!-- Progress -->
                            <div class="w-full h-1.5 bg-mm-darkBg rounded-full overflow-hidden mb-2">
                                <div class="h-full bg-gradient-to-r from-mm-primary to-mm-accent rounded-full" style="width: <?= (int)$item['progress_percent'] ?>%"></div>
                            </div>
                            <a href="reader.php?manga_id=<?= $item['id'] ?>&ch=<?= $item['chapter_number'] ?>" class="text-[11px] font-semibold text-mm-accent hover:underline">
                                O'qishni davom etish →
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-8 rounded-2xl bg-mm-darkSurface text-center text-slate-400 text-sm border border-white/5">
                    Siz hali hech qanday manga o'qishni boshlamadingiz.
                </div>
            <?php endif; ?>
        </section>

        <!-- FAVORITES SECTION -->
        <section>
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-display text-xl sm:text-2xl font-bold flex items-center gap-2">
                    <i data-lucide="heart" class="w-5 h-5 text-rose-500 fill-rose-500"></i> Sevimli Mangalar
                </h2>
            </div>

            <?php if (!empty($favoritesList)): ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                    <?php foreach ($favoritesList as $fav): ?>
                    <div class="group bg-mm-darkCard rounded-2xl overflow-hidden border border-white/5 hover:border-mm-accent/60 transition">
                        <div class="relative aspect-[3/4] overflow-hidden">
                            <img src="<?= htmlspecialchars($fav['cover_image']) ?>" alt="<?= htmlspecialchars($fav['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-3 right-3 px-2 py-0.5 rounded-lg bg-mm-primary text-white text-[10px] font-bold uppercase">
                                <?= htmlspecialchars($fav['type']) ?>
                            </span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-sm truncate group-hover:text-mm-accent transition"><?= htmlspecialchars($fav['title']) ?></h3>
                            <div class="flex items-center justify-between text-xs text-slate-400 mt-2">
                                <span class="text-amber-400 font-bold">★ <?= htmlspecialchars($fav['rating']) ?></span>
                                <span><?= htmlspecialchars($fav['status']) ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-8 rounded-2xl bg-mm-darkSurface text-center text-slate-400 text-sm border border-white/5">
                    Sevimlilar ro'yxatingiz bo'sh. Mangalardagi yurakcha tugmasini bosing.
                </div>
            <?php endif; ?>
        </section>

    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>