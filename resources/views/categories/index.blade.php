@extends('layouts.app')

@section('title', 'Our Cake Collections')

@push('styles')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .categories-header { text-align: center; padding: 60px 0 30px; }
        .categories-header h1 { font-size: 3.5rem; margin-bottom: 15px; }
        .categories-header .divider { width: 80px; height: 3px; background: var(--gold); margin: 0 auto 20px; }

        /* Back to home button */
        .back-home {
            position: absolute; top: 100px; left: 30px; z-index: 10;
        }
        .back-home a {
            display: flex; align-items: center; text-decoration: none; color: var(--dark);
            font-size: 0.9rem; background: white; padding: 8px 15px; border-radius: 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: 0.3s;
        }
        .back-home a:hover { background: var(--gold); color: white; }

        /* Filters */
        .filters-container {
            display: flex; justify-content: center; gap: 20px; margin-bottom: 40px; flex-wrap: wrap;
        }
        .search-container { max-width: 400px; flex: 1; }
        .search-input {
            width: 100%; padding: 12px 25px; border: 2px solid #eee; border-radius: 50px;
            font-size: 1rem; transition: 0.3s; outline: none;
        }
        .search-input:focus { border-color: var(--gold); box-shadow: 0 0 0 4px rgba(212,175,55,0.1); }

        /* Egg toggle buttons (unchanged) */
        .egg-toggle-wrapper {
            display: flex; align-items: center; background: white; padding: 5px;
            border-radius: 50px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .egg-btn {
            padding: 8px 20px; border: none; background: transparent; border-radius: 50px;
            font-size: 0.9rem; cursor: pointer; transition: 0.3s;
        }
        .egg-btn.active { background: var(--gold); color: var(--dark); font-weight: 600; }
        .egg-btn:not(.active):hover { background: #f0f0f0; }

        /* Category cards */
        .category-card {
            border-radius: 16px; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s;
            background: white; box-shadow: 0 5px 20px rgba(0,0,0,0.03); margin-bottom: 30px;
            position: relative;
        }
        .category-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(212,175,55,0.1); }

        .category-image {
            height: 240px; overflow: hidden; background: #f5f5f5;
        }
        .category-image img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.5s;
        }
        .category-card:hover .category-image img { transform: scale(1.05); }

        .category-info { padding: 20px; text-align: center; }
        .category-info h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            margin-bottom: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;          /* space between name and icons */
            flex-wrap: wrap;
            justify-content: center;
        }

        /* Food icon styles (exactly as you provided) */
        .food-icon {
            width: 16px;
            height: 16px;
            border: 2px solid;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 3px;
            background: white;
        }
        .food-icon::after {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        .veg {
            border-color: #28a745;
        }
        .veg::after {
            background-color: #28a745;
        }
        .non-veg {
            border-color: #dc3545;
        }
        .non-veg::after {
            background-color: #dc3545;
        }

        .category-info .count {
            color: var(--gold);
            font-weight: 500;
            letter-spacing: 1px;
            font-size: 0.9rem;
            display: block;
            margin-top: 5px;
        }

        .no-results { text-align: center; padding: 50px; color: #999; font-size: 1.2rem; display: none; }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="categories-header" data-aos="fade-up">
            <h1 class="serif">Our Collections</h1>
            <div class="divider"></div>
            <p class="text-muted">Discover the perfect cake for every moment</p>
        </div>

        <!-- Filters -->
        <div class="filters-container" data-aos="fade-up">
            <div class="search-container">
                <form action="{{ route('search.products') }}" method="GET" style="width: 100%;">
                    <input type="text" name="query" class="search-input" placeholder="Search flavours..." required>
                </form>
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
                    $hasEggless = isset($category->has_eggless) && $category->has_eggless;
                    $hasEgg     = isset($category->has_egg) && $category->has_egg;
                @endphp
                <div class="col-lg-4 col-md-6 category-item"
                     data-has-eggless="{{ $hasEggless ? '1' : '0' }}"
                     data-has-egg="{{ $hasEgg ? '1' : '0' }}"
                     data-aos="fade-up"
                     data-aos-delay="{{ $loop->index * 50 }}">
                    <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                        <div class="category-card">
                            {{-- Image with fallback – never broken --}}
                            <div class="category-image">
                                @php
                                    $imagePath = $category->image ? 'storage/'.$category->image : null;
                                    $imageExists = $imagePath && file_exists(public_path($imagePath));
                                @endphp
                                <img src="{{ $imageExists ? asset($imagePath) : asset('images/category-placeholder.jpg') }}"
                                     onerror="this.onerror=null; this.src='{{ asset('images/category-placeholder.jpg') }}';"
                                     alt="{{ $category->name }}"
                                     class="w-100 h-100">
                            </div>

                            <div class="category-info">
                                <h3>
                                    {{ $category->name }}
                                    {{-- Food icons instead of emoji badges --}}
                                    @if($hasEggless)
                                        <span class="food-icon veg" title="Eggless"></span>
                                    @endif
                                    @if($hasEgg)
                                        <span class="food-icon non-veg" title="Contains Egg"></span>
                                    @endif
                                </h3>
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

        <!-- No results message (for egg filter) -->
        <div id="noResults" class="no-results">
            <i class="fa-regular fa-face-frown fa-2x mb-3"></i>
            <p>No categories match your filter.</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });

        // Egg filter state
        let eggFilter = 'all';
        const categoryItems = document.querySelectorAll('.category-item');
        const noResults = document.getElementById('noResults');

        function filterCategories() {
            let visibleCount = 0;
            categoryItems.forEach(item => {
                const hasEggless = item.dataset.hasEggless === '1';
                const hasEgg = item.dataset.hasEgg === '1';

                let matches = true;
                if (eggFilter === 'eggless') matches = hasEggless;
                else if (eggFilter === 'egg') matches = hasEgg;

                item.style.display = matches ? '' : 'none';
                if (matches) visibleCount++;
            });
            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        document.getElementById('eggAllBtn').addEventListener('click', function() {
            eggFilter = 'all';
            [eggAllBtn, eggVegBtn, eggNonVegBtn].forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            filterCategories();
        });
        document.getElementById('eggVegBtn').addEventListener('click', function() {
            eggFilter = 'eggless';
            [eggAllBtn, eggVegBtn, eggNonVegBtn].forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            filterCategories();
        });
        document.getElementById('eggNonVegBtn').addEventListener('click', function() {
            eggFilter = 'egg';
            [eggAllBtn, eggVegBtn, eggNonVegBtn].forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            filterCategories();
        });
    </script>
@endpush