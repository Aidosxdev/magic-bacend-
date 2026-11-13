<?php
require_once __DIR__ . '/db.php';

// Trenddagi mangalarni bazadan olish (Prepared Statement orqali)
$stmt = $pdo->prepare("SELECT * FROM mangas ORDER BY views DESC LIMIT 5");
$stmt->execute();
$trendingMangaList = $stmt->fetchAll();
$heroSlides = [
    [
        'id' => 1,
        'title' => 'Astral Sovereign: Zero',
        'subtitle' => 'ORIGINAL SERIES • SEASON 2 PREMIERE',
        'description' => 'In a fractured metropolis ruled by star-forged syndicates, an exiled archivist awakens a forbidden celestial grimoire capable of rewriting fate.',
        'genres' => ['Sci-Fi Fantasy', 'Action', 'Cyber-Arcane'],
        'rating' => '4.9',
        'chapters' => '142 Chapters',
        'cover' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?auto=format&fit=crop&w=1600&q=80',
        'badge' => '#1 GLOBAL TRENDING'
    ],
    [
        'id' => 2,
        'title' => 'Chronicles of the Neon Void',
        'subtitle' => 'MANHWA EXCLUSIVE • WEEKLY',
        'description' => 'When dimensional rifts tear open above Neo-Seoul, a lone rift-walker must descend into the abyssal towers before reality collapses.',
        'genres' => ['Action', 'Dungeon', 'Supernatural'],
        'rating' => '4.8',
        'chapters' => '98 Chapters',
        'cover' => 'https://images.unsplash.com/photo-1618336753974-aae8e04506aa?auto=format&fit=crop&w=1600&q=80',
        'badge' => 'EDITORS CHOICE'
    ],
    [
        'id' => 3,
        'title' => 'Blade of the Azure Eclipse',
        'subtitle' => 'MANHUA MASTERPIECE • FULL COLOR',
        'description' => 'Born without spiritual meridians, a young swordsmith tempers a blade from fallen meteor iron that challenges the Nine Heavens.',
        'genres' => ['Martial Arts', 'Fantasy', 'Adventure'],
        'rating' => '4.9',
        'chapters' => '215 Chapters',
        'cover' => 'https://images.unsplash.com/photo-1541562232579-512a21360020?auto=format&fit=crop&w=1600&q=80',
        'badge' => 'NEW ARC'
    ]
];

$continueReading = [
    [
        'title' => 'Astral Sovereign: Zero',
        'chapter' => 'Chapter 138',
        'total' => '142',
        'progress' => 84,
        'cover' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?auto=format&fit=crop&w=500&q=80'
    ],
    [
        'title' => 'Shadow Monarch’s Legacy',
        'chapter' => 'Chapter 64',
        'total' => '80',
        'progress' => 62,
        'cover' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=500&q=80'
    ],
    [
        'title' => 'Velvet Villainess Protocol',
        'chapter' => 'Chapter 49',
        'total' => '52',
        'progress' => 94,
        'cover' => 'https://images.unsplash.com/photo-1580477667995-2b94f01c9516?auto=format&fit=crop&w=500&q=80'
    ],
    [
        'title' => 'Cyber Ronin 2099',
        'chapter' => 'Chapter 19',
        'total' => '45',
        'progress' => 42,
        'cover' => 'https://images.unsplash.com/photo-1614583225154-5fcdda07019e?auto=format&fit=crop&w=500&q=80'
    ]
];

$trendingManga = [
    [
        'rank' => 1,
        'title' => 'Astral Sovereign: Zero',
        'genres' => ['Sci-Fi', 'Action'],
        'rating' => '4.9',
        'chapters' => 142,
        'type' => 'Manga',
        'cover' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?auto=format&fit=crop&w=600&q=80'
    ],
    [
        'rank' => 2,
        'title' => 'Chronicles of the Neon Void',
        'genres' => ['Dungeon', 'Fantasy'],
        'rating' => '4.8',
        'chapters' => 98,
        'type' => 'Manhwa',
        'cover' => 'https://images.unsplash.com/photo-1618336753974-aae8e04506aa?auto=format&fit=crop&w=600&q=80'
    ],
    [
        'rank' => 3,
        'title' => 'Blade of the Azure Eclipse',
        'genres' => ['Murim', 'Adventure'],
        'rating' => '4.9',
        'chapters' => 215,
        'type' => 'Manhua',
        'cover' => 'https://images.unsplash.com/photo-1541562232579-512a21360020?auto=format&fit=crop&w=600&q=80'
    ],
    [
        'rank' => 4,
        'title' => 'Empress of the Glass Throne',
        'genres' => ['Romance', 'Regression'],
        'rating' => '4.7',
        'chapters' => 76,
        'type' => 'Manhwa',
        'cover' => 'https://images.unsplash.com/photo-1580477667995-2b94f01c9516?auto=format&fit=crop&w=600&q=80'
    ],
    [
        'rank' => 5,
        'title' => 'Phantom Gear Alchemist',
        'genres' => ['Steampunk', 'Magic'],
        'rating' => '4.8',
        'chapters' => 114,
        'type' => 'Manga',
        'cover' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=600&q=80'
    ]
];

$latestUpdates = [
    [
        'title' => 'Astral Sovereign: Zero',
        'chapter' => 'Ch. 142 — Starfall Citadel',
        'updated' => '18 mins ago',
        'status' => 'Official EN / UZ',
        'cover' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?auto=format&fit=crop&w=300&q=80'
    ],
    [
        'title' => 'Chronicles of the Neon Void',
        'chapter' => 'Ch. 98 — Floor 77 Boss',
        'updated' => '1 hour ago',
        'status' => 'AI + Scan Verified',
        'cover' => 'https://images.unsplash.com/photo-1618336753974-aae8e04506aa?auto=format&fit=crop&w=300&q=80'
    ],
    [
        'title' => 'Empress of the Glass Throne',
        'chapter' => 'Ch. 76 — Midnight Banquet',
        'updated' => '3 hours ago',
        'status' => 'Official EN / UZ',
        'cover' => 'https://images.unsplash.com/photo-1580477667995-2b94f01c9516?auto=format&fit=crop&w=300&q=80'
    ],
    [
        'title' => 'Blade of the Azure Eclipse',
        'chapter' => 'Ch. 215 — Heavenly Tribulation',
        'updated' => '5 hours ago',
        'status' => 'Scanlation Group',
        'cover' => 'https://images.unsplash.com/photo-1541562232579-512a21360020?auto=format&fit=crop&w=300&q=80'
    ]
];

$recommendedManga = [
    [
        'title' => 'Aether Academy Dropout',
        'match' => '98% Match',
        'desc' => 'Because you read Astral Sovereign & magic academy regression titles.',
        'rating' => '4.9',
        'cover' => 'https://images.unsplash.com/photo-1614583225154-5fcdda07019e?auto=format&fit=crop&w=600&q=80'
    ],
    [
        'title' => 'Silent Duke’s Contract',
        'match' => '95% Match',
        'desc' => 'High-rated fantasy romance with intricate political intrigue.',
        'rating' => '4.8',
        'cover' => 'https://images.unsplash.com/photo-1580477667995-2b94f01c9516?auto=format&fit=crop&w=600&q=80'
    ],
    [
        'title' => 'Zero-Latency Necromancer',
        'match' => '93% Match',
        'desc' => 'Fast-paced VRMMO & system leveling action with crisp art.',
        'rating' => '4.8',
        'cover' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=600&q=80'
    ]
];

$communityPosts = [
    [
        'user' => 'Akira_Dev',
        'role' => 'Top Translator',
        'topic' => 'Theory: Who is the real architect behind the Astral Grimoire in Ch. 142?',
        'manga' => 'Astral Sovereign: Zero',
        'comments' => 148,
        'likes' => 612
    ],
    [
        'user' => 'SoraReads',
        'role' => 'Verified Reviewer',
        'topic' => 'Why Chronicles of the Neon Void has the best dungeon pacing this year.',
        'manga' => 'Chronicles of the Neon Void',
        'comments' => 89,
        'likes' => 430
    ],
    [
        'user' => 'KuroTypeset',
        'role' => 'Scanlation Lead',
        'topic' => 'Tested Magic Translator OCR on vertical SFX bubbles — 96% clean detection!',
        'manga' => 'Magic Translator',
        'comments' => 64,
        'likes' => 319
    ]
];