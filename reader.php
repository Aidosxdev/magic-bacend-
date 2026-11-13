<?php
require_once __DIR__ . '/includes/db.php';

// URL'dan manga ID va bob raqamini olish (Standart qiymatlar berilgan)
$manga_id = filter_input(INPUT_GET, 'manga_id', FILTER_VALIDATE_INT) ?: 1;
$chapter_num = filter_input(INPUT_GET, 'ch', FILTER_VALIDATE_FLOAT) ?: 142.0;

// 1. Manga ma'lumotlarini bazadan olish
$stmtManga = $pdo->prepare("SELECT * FROM mangas WHERE id = ?");
$stmtManga->execute([$manga_id]);
$manga = $stmtManga->fetch();

if (!$manga) {
    die("<div style='color:white; background:#080D18; padding:40px; text-align:center;'>Manga topilmadi.</div>");
}

// 2. Ushbu mangaga tegishli barcha boblar ro'yxatini olish (Select dropdown uchun)
$stmtChapters = $pdo->prepare("SELECT id, chapter_number, title FROM chapters WHERE manga_id = ? ORDER BY chapter_number ASC");
$stmtChapters->execute([$manga_id]);
$chapters = $stmtChapters->fetchAll();

// 3. Joriy bobni bazadan olish
$stmtCurrent = $pdo->prepare("SELECT * FROM chapters WHERE manga_id = ? AND chapter_number = ?");
$stmtCurrent->execute([$manga_id, $chapter_num]);
$currentChapter = $stmtCurrent->fetch();

// Agar bazada bob topilmasa, birinchi bobni yoki namunani olish
if (!$currentChapter && !empty($chapters)) {
    $currentChapter = $chapters[0];
    $chapter_num = $currentChapter['chapter_number'];
}

// Bob sahifalari JSON formatda saqlanadi. Agar bo'sh bo'lsa, namunaviy rasmlar qo'yiladi.
$pages = $currentChapter && !empty($currentChapter['pages']) 
    ? json_decode($currentChapter['pages'], true) 
    : [
        'https://images.unsplash.com/photo-1578632767115-351597cf2477?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1618336753974-aae8e04506aa?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1541562232579-512a21360020?auto=format&fit=crop&w=1200&q=80'
    ];

// Oldingi va Keyingi bobni aniqlash
$prevChapter = null;
$nextChapter = null;
foreach ($chapters as $index => $ch) {
    if ((float)$ch['chapter_number'] === (float)$chapter_num) {
        $prevChapter = $chapters[$index - 1] ?? null;
        $nextChapter = $chapters[$index + 1] ?? null;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="uz" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($manga['title']) ?> — Chapter <?= htmlspecialchars($chapter_num) ?> | Magic Manga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
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
        .glass-nav {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-mm-darkBg text-white antialiased min-h-screen">

    <!-- FLOATING TOP NAVIGATION BAR -->
    <header class="fixed top-0 inset-x-0 z-50 px-4 py-3">
        <nav class="max-w-4xl mx-auto glass-nav bg-mm-darkSurface/85 border border-mm-accent/20 rounded-2xl px-4 h-14 flex items-center justify-between shadow-neon">
            <!-- Back to Manga / Home -->
            <a href="index.php" class="flex items-center gap-2 text-xs font-semibold text-slate-300 hover:text-white transition">
                <i data-lucide="arrow-left" class="w-4 h-4 text-mm-accent"></i>
                <span class="hidden sm:inline">Bosh sahifa</span>
            </a>

            <!-- Chapter Title & Selector -->
            <div class="flex items-center gap-3">
                <span class="font-bold text-sm truncate max-w-[180px] sm:max-w-xs"><?= htmlspecialchars($manga['title']) ?></span>
                <select onchange="changeChapter(this.value)" class="bg-mm-darkCard border border-mm-accent/30 text-xs rounded-lg px-2.5 py-1.5 text-mm-accent font-semibold focus:outline-none cursor-pointer">
                    <?php foreach ($chapters as $ch): ?>
                        <option value="<?= $ch['chapter_number'] ?>" <?= (float)$ch['chapter_number'] === (float)$chapter_num ? 'selected' : '' ?>>
                            Ch. <?= $ch['chapter_number'] ?> <?= $ch['title'] ? '— ' . htmlspecialchars($ch['title']) : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Settings / Theme -->
            <button onclick="toggleBars()" class="p-2 rounded-xl bg-mm-darkCard hover:border-mm-accent border border-transparent transition" title="Panellarni yashirish">
                <i data-lucide="eye" class="w-4 h-4 text-mm-accent"></i>
            </button>
        </nav>
    </header>

    <!-- MANGA WEBTOON VIEWER CONTAINER -->
    <main class="max-w-3xl mx-auto pt-24 pb-32 px-2 sm:px-4 flex flex-col items-center space-y-1">
        <?php if (!empty($pages)): ?>
            <?php foreach ($pages as $index => $pageUrl): ?>
                <div class="relative w-full flex justify-center group">
                    <img src="<?= htmlspecialchars($pageUrl) ?>" alt="Page <?= $index + 1 ?>" loading="lazy" class="w-full max-w-2xl rounded-lg shadow-2xl object-contain bg-mm-darkSurface">
                    <span class="absolute bottom-3 right-3 px-2 py-0.5 rounded bg-black/60 backdrop-blur-md text-[10px] text-slate-300 opacity-0 group-hover:opacity-100 transition-opacity">
                        <?= $index + 1 ?> / <?= count($pages) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="py-24 text-center text-slate-400">
                <p>Bu bob uchun hali sahifalar yuklanmagan.</p>
            </div>
        <?php endif; ?>
    </main>

    <!-- BOTTOM CHAPTER NAVIGATION BAR -->
    <footer id="bottomNav" class="fixed bottom-4 inset-x-0 z-40 px-4 transition-transform duration-300">
        <div class="max-w-md mx-auto glass-nav bg-mm-darkSurface/90 border border-mm-accent/30 rounded-2xl p-3 flex items-center justify-between shadow-neon">
            <!-- Prev Chapter -->
            <?php if ($prevChapter): ?>
                <a href="reader.php?manga_id=<?= $manga_id ?>&ch=<?= $prevChapter['chapter_number'] ?>" class="flex items-center gap-1 px-3 py-2 rounded-xl bg-mm-darkCard hover:bg-mm-primary text-xs font-semibold transition">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i> Oldingi
                </a>
            <?php else: ?>
                <button disabled class="flex items-center gap-1 px-3 py-2 rounded-xl bg-mm-darkCard/50 text-xs font-semibold text-slate-500 cursor-not-allowed">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i> Oldingi
                </button>
            <?php endif; ?>

            <span class="text-xs font-bold text-mm-accent">Chapter <?= htmlspecialchars($chapter_num) ?></span>

            <!-- Next Chapter -->
            <?php if ($nextChapter): ?>
                <a href="reader.php?manga_id=<?= $manga_id ?>&ch=<?= $nextChapter['chapter_number'] ?>" class="flex items-center gap-1 px-3 py-2 rounded-xl bg-mm-primary hover:bg-blue-600 text-xs font-semibold text-white transition shadow-neon">
                    Keyingi <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            <?php else: ?>
                <button disabled class="flex items-center gap-1 px-3 py-2 rounded-xl bg-mm-darkCard/50 text-xs font-semibold text-slate-500 cursor-not-allowed">
                    Keyingi <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            <?php endif; ?>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
    let mangaId = 1; // PHP'dan dinamik kelishi mumkin: <?= $manga_id ?>
    let chapterId = <?= $currentChapter['id'] ?? 1 ?>;
    let lastSavedPercent = 0;

    // Scroll foizini hisoblash va yuborish
    function updateProgress() {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        if (docHeight <= 0) return;

        let percent = Math.round((scrollTop / docHeight) * 100);
        
        // Har 10% o'zgargandagina bazaga so'rov yuborish (serverni ortiqcha yuklamaslik uchun)
        if (Math.abs(percent - lastSavedPercent) >= 10 || percent === 100) {
            lastSavedPercent = percent;
            sendProgress(percent);
        }
    }

    function sendProgress(percent) {
        fetch('api/save_progress.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                user_id: 1, // Joriy foydalanuvchi ID si (Session dan olinadi)
                manga_id: mangaId,
                chapter_id: chapterId,
                progress_percent: percent
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Progress saved:', data);
        })
        .catch(error => {
            console.error('Error saving progress:', error);
        });
    }

    // Scroll eventini tinglash (throttle bilan)
    let scrollTimer;
    window.addEventListener('scroll', () => {
        if (scrollTimer) clearTimeout(scrollTimer);
        scrollTimer = setTimeout(updateProgress, 1000);
    });

    // Sahidadan chiqib ketayotganda ham oxirgi holatni saqlab qolish
    window.addEventListener('beforeunload', () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        let percent = docHeight > 0 ? Math.round((scrollTop / docHeight) * 100) : 0;
        
        // sendBeacon brauzer yopilayotganda ham so'rovni ishonchli yuboradi
        navigator.sendBeacon('api/save_progress.php', JSON.stringify({
            user_id: 1,
            manga_id: mangaId,
            chapter_id: chapterId,
            progress_percent: percent
        }));
    });
});
        lucide.createIcons();

        function changeChapter(chapterNum) {
            window.location.href = `reader.php?manga_id=<?= $manga_id ?>&ch=${chapterNum}`;
        }

        // Scroll qilganda pastdagi navigatsiyani avtomatik yashirish/ko'rsatish
        let lastScrollTop = 0;
        const bottomNav = document.getElementById('bottomNav');

        window.addEventListener('scroll', () => {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                bottomNav.style.transform = 'translateY(100px)';
            } else {
                bottomNav.style.transform = 'translateY(0)';
            }
            lastScrollTop = scrollTop;
        });
    </script>
</body>
</html>