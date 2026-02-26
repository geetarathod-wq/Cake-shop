@extends('layouts.app')

@section('title', 'Our Cake Collections')

@push('styles')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .categories-header {
            text-align: center;
            padding: 60px 0 30px;
        }
        .categories-header h1 {
            font-size: 3.5rem;
            margin-bottom: 15px;
        }
        .categories-header .divider {
            width: 80px;
            height: 3px;
            background: var(--gold);
            margin: 0 auto 20px;
        }

        /* Back to home button */
        .back-home {
            position: absolute;
            top: 100px;
            left: 30px;
            z-index: 10;
        }
        .back-home a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--dark);
            font-size: 0.9rem;
            background: white;
            padding: 8px 15px;
            border-radius: 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .back-home a:hover {
            background: var(--gold);
            color: white;
        }

        /* Filters */
        .filters-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }
        .search-container {
            max-width: 400px;
            flex: 1;
        }
        .search-input {
            width: 100%;
            padding: 12px 25px;
            border: 2px solid #eee;
            border-radius: 50px;
            font-size: 1rem;
            transition: 0.3s;
            outline: none;
        }
        .search-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(212,175,55,0.1);
        }

        /* Egg toggle */
        .egg-toggle-wrapper {
            display: flex;
            align-items: center;
            background: white;
            padding: 5px;
            border-radius: 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .egg-btn {
            padding: 8px 20px;
            border: none;
            background: transparent;
            border-radius: 50px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: 0.3s;
        }
        .egg-btn.active {
            background: var(--gold);
            color: var(--dark);
            font-weight: 600;
        }
        .egg-btn:not(.active):hover {
            background: #f0f0f0;
        }

        /* Category cards */
        .category-card {
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            background: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
            margin-bottom: 30px;
            position: relative;
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(212,175,55,0.1);
        }
        .category-image {
            height: 220px;
            overflow: hidden;
        }
        .category-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .category-card:hover .category-image img {
            transform: scale(1.05);
        }
        .category-info {
            padding: 20px;
            text-align: center;
        }
        .category-info h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            margin-bottom: 8px;
        }
        .category-info .count {
            color: var(--gold);
            font-weight: 500;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }
        .badge-egg {
            position: absolute;
            top: 10px;
            left: 10px;
            background: white;
            border-radius: 50px;
            padding: 5px 12px;
            font-size: 0.7rem;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 2;
        }
        .badge-egg.veg { color: #28a745; }
        .badge-egg.non-veg { color: #dc3545; }

        .no-results {
            text-align: center;
            padding: 50px;
            color: #999;
            font-size: 1.2rem;
            display: none;
        }
    </style>
@endpush

@section('content')
    <!-- Back to Home button -->
    <div class="back-home">
        <a href="{{ route('home') }}">
            <i class="fa-regular fa-arrow-left me-2"></i> Home
        </a>
    </div>

    <div class="container">
        <div class="categories-header" data-aos="fade-up">
            <h1 class="serif">Our Collections</h1>
            <div class="divider"></div>
            <p class="text-muted">Discover the perfect cake for every moment</p>
        </div>

        <!-- Filters: Search + Egg Toggle -->
        <div class="filters-container" data-aos="fade-up">
            <div class="search-container">
                <input type="text" id="categorySearch" class="search-input" placeholder="Search categories...">
            </div>
            <div class="egg-toggle-wrapper">
                <button class="egg-btn active" id="eggAllBtn">All</button>
                <button class="egg-btn" id="eggVegBtn">🌱 Eggless</button>
                <button class="egg-btn" id="eggNonVegBtn">🥚 With Egg</button>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="row g-4" id="categoriesGrid">
            @forelse($categories as $category)
                @php
                    // You need to compute these flags in your controller.
                    // Example: $hasEggless = $category->products->contains('egg_type', 'eggless');
                    //          $hasEgg     = $category->products->contains('egg_type', 'with_egg');
                    // For now, using placeholders – replace with actual logic.
                    $hasEggless = true;   // change this
                    $hasEgg     = true;   // change this
                @endphp
                <div class="col-lg-4 col-md-6 category-item"
                     data-category-name="{{ strtolower($category->name) }}"
                     data-has-eggless="{{ $hasEggless ? '1' : '0' }}"
                     data-has-egg="{{ $hasEgg ? '1' : '0' }}"
                     data-aos="fade-up"
                     data-aos-delay="{{ $loop->index * 50 }}">
                    <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                        <div class="category-card">
                            @if($hasEggless && $hasEgg)
                                <div class="badge-egg">🌱🥚</div>
                            @elseif($hasEggless)
                                <div class="badge-egg veg">🌱 Eggless</div>
                            @elseif($hasEgg)
                                <div class="badge-egg non-veg">🥚 With Egg</div>
                            @endif
                            <div class="category-image">
                                <img src="{{ $category->image ? asset('storage/'.$category->image) : 'https://via.placeholder.com/600x400?text='.urlencode($category->name) }}" 
                                     alt="{{ $category->name }}">
                            </div>
                            <div class="category-info">
                                <h3>{{ $category->name }}</h3>
                                <span class="count">{{ $category->products_count }} items</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No categories found.</p>
                </div>
            @endforelse
        </div>

        <!-- No results message (for search) -->
        <div id="noResults" class="no-results">
            <i class="fa-regular fa-face-frown fa-2x mb-3"></i>
            <p>No categories match your search.</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });

        // Search filter
        const searchInput = document.getElementById('categorySearch');
        const categoryItems = document.querySelectorAll('.category-item');
        const noResults = document.getElementById('noResults');

        // Egg filter state: 'all', 'eggless', 'egg'
        let eggFilter = 'all';

        function filterCategories() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            let visibleCount = 0;

            categoryItems.forEach(item => {
                const name = item.getAttribute('data-category-name');
                const hasEggless = item.getAttribute('data-has-eggless') === '1';
                const hasEgg = item.getAttribute('data-has-egg') === '1';

                let matchesEgg = true;
                if (eggFilter === 'eggless') {
                    matchesEgg = hasEggless;
                } else if (eggFilter === 'egg') {
                    matchesEgg = hasEgg;
                }

                const matchesSearch = name.includes(searchTerm);

                if (matchesSearch && matchesEgg) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        // Search input event
        searchInput.addEventListener('keyup', filterCategories);

        // Egg toggle buttons
        const eggAllBtn = document.getElementById('eggAllBtn');
        const eggVegBtn = document.getElementById('eggVegBtn');
        const eggNonVegBtn = document.getElementById('eggNonVegBtn');

        function setActiveEggButton(activeBtn) {
            [eggAllBtn, eggVegBtn, eggNonVegBtn].forEach(btn => btn.classList.remove('active'));
            activeBtn.classList.add('active');
        }

        eggAllBtn.addEventListener('click', function() {
            eggFilter = 'all';
            setActiveEggButton(this);
            filterCategories();
        });

        eggVegBtn.addEventListener('click', function() {
            eggFilter = 'eggless';
            setActiveEggButton(this);
            filterCategories();
        });

        eggNonVegBtn.addEventListener('click', function() {
            eggFilter = 'egg';
            setActiveEggButton(this);
            filterCategories();
        });
    </script>
@endpush