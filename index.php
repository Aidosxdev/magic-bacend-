<?php
require_once __DIR__ . '/includes/data.php';
?>
<!DOCTYPE html>
<html lang="en" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magic Manga — Next-Gen Manga, Manhwa & Manhua Ecosystem</title>
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
                            darkMuted: '#9EABC1',
                            lightBg: '#F5F8FF',
                            lightSurface: '#FFFFFF',
                            lightText: '#101828',
                            lightMuted: '#667085',
                            primary: '#247BFF',
                            accent: '#64C7FF',
                        }
                    },
                    boxShadow: {
                        'neon': '0 0 25px rgba(36, 123, 255, 0.35)',
                        'neon-lg': '0 0 40px rgba(100, 199, 255, 0.25)',
                    }
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
<body class="bg-mm-lightBg text-mm-lightText dark:bg-mm-darkBg dark:text-white transition-colors duration-300 antialiased selection:bg-mm-primary selection:text-white">

    <!-- 3. FLOATING GLASSMORPHISM NAVBAR -->
    <header class="fixed top-4 inset-x-0 z-50 px-4 sm:px-6 lg:px-8">
        <nav class="max-w-7xl mx-auto glass-nav bg-white/80 dark:bg-mm-darkSurface/75 border border-slate-200/80 dark:border-mm-accent/15 rounded-2xl px-4 sm:px-6 h-16 flex items-center justify-between shadow-lg dark:shadow-neon">
            <!-- Brand Logo -->
            <a href="index.php" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-mm-primary to-mm-accent p-0.5 shadow-neon">
                    <div class="w-full h-full bg-mm-darkBg rounded-[10px] flex items-center justify-center">
                        <svg class="w-5 h-5 text-mm-accent group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                            <path d="M12 2L3 7v10l9 5 9-5V7l-9-5z"/>
                            <path d="M12 22V12"/>
                            <path d="M21 7l-9 5-9-5"/>
                        </svg>
                    </div>
                </div>
                <span class="font-display font-bold text-xl tracking-tight">
                    Magic<span class="text-mm-primary dark:text-mm-accent">Manga</span>
                </span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-7 text-sm font-medium text-mm-lightMuted dark:text-mm-darkMuted">
                <a href="#" class="text-mm-primary dark:text-white font-semibold">Home</a>
                <a href="#trending" class="hover:text-mm-primary dark:hover:text-mm-accent transition">Explore</a>
                <a href="#updates" class="hover:text-mm-primary dark:hover:text-mm-accent transition">Genres</a>
                <a href="#community" class="hover:text-mm-primary dark:hover:text-mm-accent transition">Community</a>
                <a href="#translator" class="flex items-center gap-1.5 text-mm-primary dark:text-mm-accent font-semibold">
                    <i data-lucide="sparkles" class="w-4 h-4"></i> Translator
                </a>
            </div>

            <!-- Action Controls -->
            <div class="flex items-center gap-2 sm:gap-3">
                <button onclick="toggleSearchModal()" aria-label="Search" class="p-2.5 rounded-xl bg-slate-100 dark:bg-mm-darkCard/80 hover:border-mm-primary border border-transparent transition">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </button>
                <button aria-label="Notifications" class="relative p-2.5 rounded-xl bg-slate-100 dark:bg-mm-darkCard/80 hover:border-mm-primary border border-transparent transition">
                    <i data-lucide="bell" class="w-4 h-4"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-mm-primary"></span>
                </button>
                <button id="themeToggle" aria-label="Toggle Theme" class="p-2.5 rounded-xl bg-slate-100 dark:bg-mm-darkCard/80 hover:border-mm-accent border border-transparent transition">
                    <i data-lucide="sun" class="w-4 h-4 hidden dark:block text-mm-accent"></i>
                    <i data-lucide="moon" class="w-4 h-4 block dark:hidden text-mm-primary"></i>
                </button>
                <a href="#profile" class="ml-1 flex items-center gap-2 pl-1.5 pr-3 py-1 rounded-xl bg-mm-primary/10 dark:bg-mm-darkCard border border-mm-primary/30 hover:border-mm-accent transition">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" alt="Avatar" class="w-7 h-7 rounded-lg object-cover">
                    <span class="hidden sm:inline text-xs font-semibold">Reader</span>
                </a>
            </div>
        </nav>
    </header>

    <!-- 4. CINEMATIC FULL-WIDTH HERO SECTION -->
    <section class="relative min-h-[640px] lg:min-h-[720px] flex items-end pt-28 pb-16 overflow-hidden">
        <?php foreach ($heroSlides as $index => $slide): ?>
        <div class="hero-slide absolute inset-0 transition-opacity duration-700 <?= $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none' ?>" data-slide="<?= $index ?>">
            <img src="<?= htmlspecialchars($slide['cover']) ?>" alt="<?= htmlspecialchars($slide['title']) ?>" class="w-full h-full object-cover object-center scale-105">
            <!-- Gradient Overlays -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#080D18] via-[#080D18]/85 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-mm-lightBg via-transparent to-[#080D18]/60 dark:from-mm-darkBg dark:via-transparent dark:to-[#080D18]/60"></div>

            <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-end pb-14">
                <div class="max-w-2xl text-white">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-mm-primary/20 border border-mm-accent/40 text-mm-accent text-xs font-bold tracking-wider mb-4">
                        <span class="w-2 h-2 rounded-full bg-mm-accent animate-pulse"></span>
                        <?= htmlspecialchars($slide['badge']) ?>
                    </div>
                    <p class="text-xs sm:text-sm font-semibold tracking-widest text-mm-accent uppercase mb-2">
                        <?= htmlspecialchars($slide['subtitle']) ?>
                    </p>
                    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-4">
                        <?= htmlspecialchars($slide['title']) ?>
                    </h1>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-6">
                        <?= htmlspecialchars($slide['description']) ?>
                    </p>

                    <!-- Genre Badges & Stats -->
                    <div class="flex flex-wrap items-center gap-2.5 mb-8">
                        <?php foreach ($slide['genres'] as $genre): ?>
                            <span class="px-3 py-1 rounded-lg bg-white/10 backdrop-blur-md text-xs font-medium border border-white/10">
                                <?= htmlspecialchars($genre) ?>
                            </span>
                        <?php endforeach; ?>
                        <span class="flex items-center gap-1 text-amber-400 text-sm font-bold ml-2">
                            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i> <?= htmlspecialchars($slide['rating']) ?>
                        </span>
                        <span class="text-slate-400 text-sm">• <?= htmlspecialchars($slide['chapters']) ?></span>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="#read" class="px-7 py-3.5 rounded-xl bg-mm-primary hover:bg-blue-500 text-white font-semibold text-sm flex items-center gap-2 shadow-neon transition">
                            <i data-lucide="book-open" class="w-4 h-4"></i> Read Now
                        </a>
                        <a href="#trending" class="px-7 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white font-semibold text-sm flex items-center gap-2 transition">
                            Explore More <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Slider Controls -->
        <div class="relative z-30 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex justify-end gap-2">
            <?php foreach ($heroSlides as $index => $slide): ?>
                <button onclick="setHeroSlide(<?= $index ?>)" class="hero-dot h-2 rounded-full transition-all duration-300 <?= $index === 0 ? 'w-10 bg-mm-accent' : 'w-3 bg-white/40 hover:bg-white/70' ?>" aria-label="Slide <?= $index + 1 ?>"></button>
            <?php endforeach; ?>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20 pb-24">

        <!-- 5. CONTINUE READING CAROUSEL -->
        <section>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-display text-2xl font-bold">Continue Reading</h2>
                    <p class="text-sm text-mm-lightMuted dark:text-mm-darkMuted">Pick up right where you left off</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="scrollCarousel(-320)" class="p-2.5 rounded-xl bg-mm-lightSurface dark:bg-mm-darkSurface border border-slate-200 dark:border-white/10 hover:border-mm-primary transition">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </button>
                    <button onclick="scrollCarousel(320)" class="p-2.5 rounded-xl bg-mm-lightSurface dark:bg-mm-darkSurface border border-slate-200 dark:border-white/10 hover:border-mm-primary transition">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <div id="continueCarousel" class="flex gap-5 overflow-x-auto no-scrollbar scroll-smooth pb-2">
                <?php foreach ($continueReading as $item): ?>
                <div class="min-w-[290px] sm:min-w-[320px] bg-mm-lightSurface dark:bg-mm-darkCard border border-slate-200/80 dark:border-white/5 hover:border-mm-primary/50 rounded-2xl p-4 flex gap-4 items-center transition group shadow-sm">
                    <img src="<?= htmlspecialchars($item['cover']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" loading="lazy" class="w-20 h-28 rounded-xl object-cover shrink-0 group-hover:scale-105 transition-transform">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-sm truncate mb-1"><?= htmlspecialchars($item['title']) ?></h3>
                        <p class="text-xs text-mm-primary dark:text-mm-accent font-medium mb-3">
                            <?= htmlspecialchars($item['chapter']) ?> <span class="text-mm-lightMuted dark:text-mm-darkMuted">/ <?= $item['total'] ?></span>
                        </p>
                        <!-- Progress Bar -->
                        <div class="w-full h-1.5 bg-slate-200 dark:bg-mm-darkBg rounded-full overflow-hidden mb-3">
                            <div class="h-full bg-gradient-to-r from-mm-primary to-mm-accent rounded-full" style="width: <?= (int)$item['progress'] ?>%"></div>
                        </div>
                        <a href="#read" class="inline-flex items-center gap-1.5 text-xs font-semibold text-mm-primary dark:text-mm-accent hover:underline">
                            Continue Reading <i data-lucide="play" class="w-3 h-3 fill-current"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- 6. TRENDING MANGA GRID -->
        <section id="trending">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="font-display text-2xl sm:text-3xl font-bold">Trending Now</h2>
                    <p class="text-sm text-mm-lightMuted dark:text-mm-darkMuted">Most read series across the Magic Manga ecosystem</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 rounded-xl bg-mm-primary text-white text-xs font-semibold shadow-neon">All</button>
                    <button class="px-4 py-2 rounded-xl bg-mm-lightSurface dark:bg-mm-darkSurface border border-slate-200 dark:border-white/10 text-xs font-semibold hover:border-mm-primary transition">Manga</button>
                    <button class="px-4 py-2 rounded-xl bg-mm-lightSurface dark:bg-mm-darkSurface border border-slate-200 dark:border-white/10 text-xs font-semibold hover:border-mm-primary transition">Manhwa</button>
                    <button class="px-4 py-2 rounded-xl bg-mm-lightSurface dark:bg-mm-darkSurface border border-slate-200 dark:border-white/10 text-xs font-semibold hover:border-mm-primary transition">Manhua</button>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                <?php foreach ($trendingManga as $manga): ?>
                <article class="group relative bg-mm-lightSurface dark:bg-mm-darkCard rounded-2xl overflow-hidden border border-slate-200/80 dark:border-white/5 hover:border-mm-accent/60 hover:shadow-neon transition-all duration-300">
                    <div class="relative aspect-[3/4] overflow-hidden">
                        <img src="<?= htmlspecialchars($manga['cover']) ?>" alt="<?= htmlspecialchars($manga['title']) ?>" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#080D18] via-transparent to-transparent opacity-80"></div>
                        
                        <!-- Rank Badge -->
                        <div class="absolute top-3 left-3 w-8 h-8 rounded-xl bg-mm-darkBg/85 backdrop-blur-md border border-mm-accent/40 flex items-center justify-center font-display font-extrabold text-sm text-mm-accent">
                            #<?= (int)$manga['rank'] ?>
                        </div>
                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-lg bg-mm-primary/90 text-white text-[10px] font-bold uppercase">
                            <?= htmlspecialchars($manga['type']) ?>
                        </span>

                        <div class="absolute bottom-3 inset-x-3 flex items-center justify-between text-xs text-white">
                            <span class="flex items-center gap-1 font-bold text-amber-400">
                                <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400"></i> <?= htmlspecialchars($manga['rating']) ?>
                            </span>
                            <span class="text-slate-300"><?= (int)$manga['chapters'] ?> Ch.</span>
                        </div>
                    </div>

                    <div class="p-4">
                        <h3 class="font-bold text-sm sm:text-base line-clamp-1 group-hover:text-mm-primary dark:group-hover:text-mm-accent transition">
                            <?= htmlspecialchars($manga['title']) ?>
                        </h3>
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            <?php foreach ($manga['genres'] as $tag): ?>
                                <span class="text-[11px] px-2 py-0.5 rounded-md bg-slate-100 dark:bg-mm-darkSurface text-mm-lightMuted dark:text-mm-darkMuted">
                                    <?= htmlspecialchars($tag) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- 7 & 8. LATEST UPDATES + RECOMMENDED FOR YOU -->
        <section id="updates" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Latest Updates (2 Columns) -->
            <div class="lg:col-span-2">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-display text-2xl font-bold">Latest Updates</h2>
                    <a href="#" class="text-xs font-semibold text-mm-primary dark:text-mm-accent hover:underline">View All Releases</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <?php foreach ($latestUpdates as $upd): ?>
                    <div class="bg-mm-lightSurface dark:bg-mm-darkCard border border-slate-200/80 dark:border-white/5 hover:border-mm-primary/50 rounded-2xl p-3.5 flex gap-4 items-center transition">
                        <img src="<?= htmlspecialchars($upd['cover']) ?>" alt="<?= htmlspecialchars($upd['title']) ?>" loading="lazy" class="w-16 h-22 rounded-xl object-cover shrink-0">
                        <div class="min-w-0 flex-1">
                            <span class="inline-block px-2 py-0.5 rounded-md bg-mm-primary/15 text-mm-primary dark:text-mm-accent text-[10px] font-bold mb-1">
                                <?= htmlspecialchars($upd['status']) ?>
                            </span>
                            <h3 class="font-bold text-sm truncate"><?= htmlspecialchars($upd['title']) ?></h3>
                            <p class="text-xs text-mm-lightMuted dark:text-mm-darkMuted truncate mt-0.5"><?= htmlspecialchars($upd['chapter']) ?></p>
                            <div class="flex items-center gap-1 text-[11px] text-slate-400 mt-2">
                                <i data-lucide="clock" class="w-3 h-3"></i> <?= htmlspecialchars($upd['updated']) ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Recommended For You (1 Column) -->
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-display text-2xl font-bold">Recommended For You</h2>
                </div>

                <div class="space-y-4">
                    <?php foreach ($recommendedManga as $rec): ?>
                    <div class="bg-mm-lightSurface dark:bg-mm-darkSurface border border-slate-200/80 dark:border-mm-accent/15 rounded-2xl p-4 flex gap-4 items-start hover:shadow-neon transition">
                        <img src="<?= htmlspecialchars($rec['cover']) ?>" alt="<?= htmlspecialchars($rec['title']) ?>" loading="lazy" class="w-16 h-20 rounded-xl object-cover shrink-0">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[11px] font-bold text-emerald-500"><?= htmlspecialchars($rec['match']) ?></span>
                                <span class="text-xs text-amber-400 font-bold">★ <?= htmlspecialchars($rec['rating']) ?></span>
                            </div>
                            <h3 class="font-bold text-sm"><?= htmlspecialchars($rec['title']) ?></h3>
                            <p class="text-xs text-mm-lightMuted dark:text-mm-darkMuted mt-1 leading-relaxed">
                                <?= htmlspecialchars($rec['desc']) ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- 9. COMMUNITY SPOTLIGHT -->
        <section id="community">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-display text-2xl font-bold">Community Spotlight</h2>
                    <p class="text-sm text-mm-lightMuted dark:text-mm-darkMuted">Live discussions, chapter theories & translator insights</p>
                </div>
                <div class="hidden sm:flex gap-2 text-xs">
                    <span class="px-3 py-1.5 rounded-full bg-mm-primary/10 text-mm-primary dark:text-mm-accent font-semibold">#AstralTheory</span>
                    <span class="px-3 py-1.5 rounded-full bg-mm-primary/10 text-mm-primary dark:text-mm-accent font-semibold">#OCRTypesetting</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach ($communityPosts as $post): ?>
                <div class="bg-mm-lightSurface dark:bg-mm-darkCard border border-slate-200/80 dark:border-white/5 rounded-2xl p-5 flex flex-col justify-between hover:border-mm-primary/40 transition">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-mm-primary to-mm-accent flex items-center justify-center text-white font-bold text-xs">
                                <?= strtoupper(substr($post['user'], 0, 2)) ?>
                            </div>
                            <div>
                                <p class="text-sm font-bold"><?= htmlspecialchars($post['user']) ?></p>
                                <p class="text-[11px] text-mm-primary dark:text-mm-accent"><?= htmlspecialchars($post['role']) ?></p>
                            </div>
                        </div>
                        <p class="text-sm font-semibold leading-snug mb-3">
                            "<?= htmlspecialchars($post['topic']) ?>"
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-200/70 dark:border-white/10 flex items-center justify-between text-xs text-mm-lightMuted dark:text-mm-darkMuted">
                        <span class="font-medium text-mm-primary dark:text-mm-accent"><?= htmlspecialchars($post['manga']) ?></span>
                        <div class="flex items-center gap-3">
                            <span class="flex items-center gap-1"><i data-lucide="heart" class="w-3.5 h-3.5"></i> <?= (int)$post['likes'] ?></span>
                            <span class="flex items-center gap-1"><i data-lucide="message-square" class="w-3.5 h-3.5"></i> <?= (int)$post['comments'] ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- 10. MAGIC TRANSLATOR PROMOTION -->
        <section id="translator" class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#0D1B33] via-[#102447] to-[#080D18] border border-mm-accent/30 p-8 sm:p-12 text-white shadow-neon-lg">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center relative z-10">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-mm-accent/15 border border-mm-accent/40 text-mm-accent text-xs font-bold mb-4">
                        <i data-lucide="scan-text" class="w-4 h-4"></i> AI OCR + TYPESET ENGINE
                    </div>
                    <h2 class="font-display text-3xl sm:text-4xl font-extrabold leading-tight mb-4">
                        Translate Raw Manga Pages in Seconds with <span class="text-mm-accent">Magic Translator</span>
                    </h2>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-6">
                        Upload raw Japanese, Korean, or Chinese scans. Our neural OCR detects speech bubbles, cleans background artwork automatically, and typesets natural translations.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <button onclick="simulateOCR()" class="px-6 py-3.5 rounded-xl bg-mm-primary hover:bg-blue-500 text-white font-semibold text-sm flex items-center gap-2 shadow-neon transition">
                            <i data-lucide="upload-cloud" class="w-4 h-4"></i> Try Magic Translator
                        </button>
                        <span class="flex items-center gap-2 text-xs text-slate-300">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-mm-accent"></i> Supports PNG, JPG, WEBP & ZIP
                        </span>
                    </div>
                </div>

                <!-- Interactive OCR Preview Box -->
                <div class="bg-mm-darkBg/80 backdrop-blur-xl border border-mm-accent/25 rounded-2xl p-6">
                    <div class="flex items-center justify-between text-xs text-slate-400 mb-4">
                        <span>RAW_PAGE_014.PNG</span>
                        <span id="ocrStatus" class="text-mm-accent font-semibold">● Ready to Scan</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-mm-darkSurface border border-white/10">
                            <span class="text-[10px] uppercase tracking-wider text-slate-400">Detected Original (JP)</span>
                            <p class="mt-2 font-bold text-base text-white">「この星の運命は、俺が書き換える！」</p>
                        </div>
                        <div class="p-4 rounded-xl bg-mm-primary/15 border border-mm-accent/40">
                            <span class="text-[10px] uppercase tracking-wider text-mm-accent">AI Typeset Output</span>
                            <p id="ocrOutput" class="mt-2 font-bold text-sm text-white">"I will rewrite the destiny of this star myself!"</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- 11. FOOTER -->
    <footer class="border-t border-slate-200 dark:border-white/10 bg-mm-lightSurface dark:bg-mm-darkSurface/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2.5 mb-3">
                        <div class="w-8 h-8 rounded-lg bg-mm-primary flex items-center justify-center text-white font-bold">M</div>
                        <span class="font-display font-bold text-lg">Magic<span class="text-mm-primary dark:text-mm-accent">Manga</span></span>
                    </div>
                    <p class="text-sm text-mm-lightMuted dark:text-mm-darkMuted max-w-md">
                        A futuristic digital reading and AI scanlation ecosystem built for manga, manhwa, and manhua readers worldwide.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-sm mb-3">Platform</h4>
                    <ul class="space-y-2 text-xs text-mm-lightMuted dark:text-mm-darkMuted">
                        <li><a href="#" class="hover:text-mm-primary">About Us</a></li>
                        <li><a href="#translator" class="hover:text-mm-primary">Magic Translator</a></li>
                        <li><a href="#" class="hover:text-mm-primary">Help Center</a></li>
                        <li><a href="#" class="hover:text-mm-primary">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-sm mb-3">Legal & Social</h4>
                    <ul class="space-y-2 text-xs text-mm-lightMuted dark:text-mm-darkMuted">
                        <li><a href="#" class="hover:text-mm-primary">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-mm-primary">Privacy Policy</a></li>
                        <li class="flex gap-3 pt-2">
                            <a href="#" aria-label="Discord" class="hover:text-mm-accent"><i data-lucide="message-circle" class="w-4 h-4"></i></a>
                            <a href="#" aria-label="Twitter" class="hover:text-mm-accent"><i data-lucide="twitter" class="w-4 h-4"></i></a>
                            <a href="#" aria-label="GitHub" class="hover:text-mm-accent"><i data-lucide="github" class="w-4 h-4"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="pt-6 border-t border-slate-200 dark:border-white/10 text-xs text-mm-lightMuted dark:text-mm-darkMuted flex flex-col sm:flex-row justify-between gap-2">
                <span>© <?= date('Y') ?> Magic Manga Ecosystem. All rights reserved.</span>
                <span>Engineered with PHP 8 & Tailwind CSS</span>
            </div>
        </div>
    </footer>

    <script src="assets/js/app.js"></script>
</body>
</html>