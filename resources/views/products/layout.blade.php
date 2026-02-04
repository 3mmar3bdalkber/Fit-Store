<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitStore</title>
    <link rel="icon" href="home img&vid/fitstore icon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #f5f5dc; /* beige */
            --accent-color: #4CAF50;
            --text-color: #333;
            --light-gray: #f8f8f8;
            --dark-gray: #555;
            --shadow: 0 4px 12px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background-color: var(--secondary-color);
            color: var(--text-color);
        }

        /* Search Box */
        .searchBox {
            height: 100px;
            background: rgba(245, 245, 220, 0.95);
            backdrop-filter: blur(7px);
            position: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            width: 100%;
            top: -100px;
            transition: var(--transition);
            box-shadow: var(--shadow);
        }

        #exitSearch {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            cursor: pointer;
            transition: var(--transition);
        }

        #exitSearch:hover {
            transform: rotate(90deg);
        }

        .btnSearch {
            position: relative;
            left: -50px;
            top: 4px;
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .iconSearch {
            width: 20px;
            height: 20px;
            position: relative;
        }

        .inputSearch {
            width: 700px;
            height: 40px;
            border-radius: 20px;
            border: 1px solid var(--dark-gray);
            padding: 10px 50px 10px 20px;
            font-size: 16px;
            outline: none;
            transition: var(--transition);
        }

        .inputSearch:focus {
            box-shadow: 0 0 5px 3px rgba(76, 175, 80, 0.3);
            border-color: var(--accent-color);
        }

        input[type="search"]::-webkit-search-cancel-button {
            -webkit-appearance: none;
            appearance: none;
        }

        /* Header */
        .header {
            background-color: var(--secondary-color);
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            height: 110px;
            align-items: center;
            position: relative;
            padding: 0 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 100;
        }

        .imgLogo {
            height: 120px;
            width: auto;
            transition: var(--transition);
        }

        .imgLogo:hover {
            transform: scale(1.05);
        }

        .headIcons, .headIconsS, .headIconsM {
            height: 30px;
            width: 30px;
            margin-left: 10px;
            transition: var(--transition);
            cursor: pointer;
        }

        .headIcons:hover, .headIconsM:hover, .headIconsS:hover {
            transform: scale(1.2);
        }

        .headIconsS {
            margin-left: 70px;
        }

        /* Navigation Links Container */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        /* Cart Link Styles */
        .cart-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--primary-color);
            position: relative;
            transition: var(--transition);
            margin-left: 40px;
        }

        .cart-link:hover {
            color: var(--accent-color);
        }

        .cart-link i {
            font-size: 24px;
            margin-right: 5px;
        }

        .cart-count {
            background-color: var(--accent-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            position: absolute;
            top: -8px;
            right: -8px;
            transition: var(--transition);
        }

        .cart-link:hover .cart-count {
            background-color: #388E3C;
            transform: scale(1.1);
        }

        /* Wishlist Link Styles */
        .wishlist-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--primary-color);
            position: relative;
            transition: var(--transition);
            margin-left: 20px;
        }

        .wishlist-link:hover {
            color: #d82e2e;
        }

        .wishlist-link img {
            width: 30px;
            height: 30px;
            transition: var(--transition);
        }

        .wishlist-link:hover img {
            transform: scale(1.1);
        }

        /* Updated ParentMarket for compatibility */
        .ParentMarket, .ParentFavoriets {
            position: relative;
            display: flex;
            align-items: center;
        }

        .headLinks {
            text-decoration: none;
            color: var(--primary-color);
            font-size: 18px;
            font-weight: 600;
            position: relative;
            padding: 5px 0;
            transition: var(--transition);
            white-space: nowrap;
        }

        .headLinks:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary-color);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }

        .headLinks:hover:after {
            transform: scaleX(1);
            transform-origin: left;
        }

        /* User Icon */
        .user-icon {
            cursor: pointer;
            margin-left: 20px;
        }

        #sideBarIcon {
            height: 40px;
            width: 40px;
            display: none;
            cursor: pointer;
        }

        #exit_id {
            display: none;
            width: 30px;
            height: 30px;
            position: relative;
            left: 220px;
            cursor: pointer;
            transition: var(--transition);
        }

        #exit_id:hover {
            transform: rotate(90deg);
        }

        /* User Menu */
        #userMenu {
            display: none;
            position: absolute;
            top: 70px;
            right: 20px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: var(--shadow);
            z-index: 1000;
            min-width: 200px;
        }

        #userMenu p {
            margin: 0 0 15px 0;
            font-weight: bold;
            color: var(--primary-color);
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        #userMenu a, #userMenu button {
            display: block;
            margin: 5px 0;
            padding: 8px 12px;
            color: var(--text-color);
            text-decoration: none;
            transition: var(--transition);
            border-radius: 4px;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            font-size: 14px;
        }

        #userMenu a:hover, #userMenu button:hover {
            background-color: var(--light-gray);
        }

        /* Notification Styles */
        .cart-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 15px 20px;
            border-radius: 4px;
            z-index: 10000;
            animation: slideIn 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            font-weight: 500;
        }

        .cart-notification.error {
            background: #dc3545;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }

        /* Footer */
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 50px 30px 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .footer h1, .footer h2 {
            color: white;
            margin-bottom: 20px;
        }

        .footer i {
            font-size: 40px;
            font-weight: bold;
            color: var(--accent-color);
        }

        .footer p {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 30px;
            line-height: 1.6;
        }

        .divider {
            width: 80%;
            height: 1px;
            background-color: rgba(255,255,255,0.2);
            margin: 20px 0;
        }

        .final {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            flex-wrap: wrap;
        }

        .contacts, .social, .cash {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
            min-width: 250px;
        }

        .cons {
            text-decoration: none;
            color: white;
            font-size: 16px;
            position: relative;
            margin: 8px 0;
            padding: 5px 0;
            transition: var(--transition);
        }

        .cons:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 1px;
            background-color: white;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .cons:hover:after {
            transform: scaleX(1);
        }

        .icons {
            background-color: white;
            width: 35px;
            height: 35px;
            margin: 0 8px;
            border-radius: 50%;
            padding: 5px;
            transition: var(--transition);
        }

        .icons:hover {
            transform: scale(1.2);
            background-color: var(--accent-color);
        }

        .pays {
            width: 45px;
            height: 30px;
            margin: 0 5px;
            object-fit: contain;
            transition: var(--transition);
            border-radius: 4px;
        }

        .pays:hover {
            transform: scale(1.1);
        }

        .year {
            text-align: center;
            margin: 20px 0;
            color: white;
            font-size: 14px;
            opacity: 0.8;
        }

        /* Mobile Styles */
        @media screen and (max-width: 1024px) {
            .nav-links {
                gap: 20px;
            }
            
            .headLinks {
                font-size: 16px;
            }
        }

        @media screen and (max-width: 768px) {
            .header {
                padding: 0 15px;
                height: 80px;
            }

            .imgLogo {
                height: 80px;
            }

            #links_id {
                display: flex;
                flex-direction: column;
                gap: 15px;
                position: fixed;
                top: 0;
                right: -250px;
                padding: 30px 20px;
                background: rgba(245, 245, 220, 0.95);
                backdrop-filter: blur(10px);
                width: 250px;
                height: 100vh;
                z-index: 1000;
                transition: right 0.3s ease;
                box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            }

            #links_id.active {
                right: 0;
            }

            .nav-links {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
                width: 100%;
            }

            .inputSearch {
                width: 80%;
                max-width: 400px;
            }

            .headLinks {
                margin-left: 0;
                padding: 10px;
                font-size: 16px;
                background-color: transparent;
                transition: background-color 0.3s;
                width: 100%;
            }

            .headLinks:hover {
                background-color: rgba(0,0,0,0.05);
            }

            .headLinks:after {
                display: none;
            }

            .headIcons, .headIconsS, .headIconsM {
                margin-left: 0;
                padding: 10px;
            }

            .cart-link, .wishlist-link {
                padding: 10px;
                width: 100%;
                justify-content: flex-start;
                margin-left: 0;
            }

            .ParentMarket, .ParentFavoriets {
                width: 100%;
            }

            .ParentSearch::after,
            .ParentUser::after,
            .ParentMarket::after,
            .ParentFavoriets::after {
                content: attr(data-label);
                color: var(--primary-color);
                font-size: 16px;
                font-weight: 600;
                position: relative;
                background-color: transparent;
                padding: 10px 0;
                transition: none;
                display: block;
                text-align: left;
                width: 100%;
                left: 0;
                bottom: 0;
            }

            #sideBarIcon {
                display: block;
            }

            #exit_id {
                display: block;
                position: absolute;
                top: 20px;
                right: 20px;
            }

            .final {
                flex-direction: column;
                align-items: center;
                gap: 30px;
            }

            .contacts, .social, .cash {
                width: 100%;
                align-items: center;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        main {
            animation: fadeIn 0.5s ease-out;
            min-height: calc(100vh - 380px); /* Adjust based on your header/footer height */
        }
    </style>
    @stack('style')
</head>
<body>
    <div class="searchBox" id="sBox">
        <form action="{{ route('products.search') }}" method="GET">
            <img src="{{asset('home img&vid/exit.png')}}" alt="exit" id="exitSearch" />
            <input type="search" class="inputSearch" placeholder="Search Product" name="word">
            <button type="submit" class="btnSearch">
                <img src="{{asset('home img&vid/serch.png')}}" alt="search" class="iconSearch"/>
            </button>
        </form>
    </div>

    <header class="header">
        <a href="{{route('fitstoreHome')}}">
            <img src="{{asset('home img&vid/black logo.png')}}" alt="FitStore logo" class="imgLogo"/>
        </a>
        
        <div id="links_id">
            <img src="{{ asset('home img&vid/exit.png') }}" alt="exit" id="exit_id" />
            
            <div class="nav-links">
                <!-- Main Navigation Links -->
                <a href="{{route('products.index')}}" class="headLinks">All Collection</a>
                <a href="{{route('products.summer')}}" class="headLinks">Summer Collection</a>
                <a href="{{route('products.winter')}}" class="headLinks">Winter Collection</a>
                <a href="#" class="headLinks">Latest Offers</a>
                
                <!-- Cart and Wishlist (placed after Latest Offers) -->
                <span class="ParentMarket" data-label="Cart">
                    <a href="{{ route('cart.index') }}" class="cart-link">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">{{ Auth::check() ? Auth::user()->carts->count() : 0 }}</span>
                    </a>
                </span>
                
                <span class="ParentFavoriets" data-label="Wishlist">
                    <a href="{{ route('wishlist.index') }}" class="wishlist-link">
                        <img src="{{asset('home img&vid/fav.png')}}" alt="fav">
                    </a>
                </span>
                
                <!-- Search Icon -->
                <span class="ParentSearch" data-label="Search">
                    <img src="{{asset('home img&vid/serch.png')}}" alt="search" id="s" class="headIconsS"/>
                </span>
                
                <!-- User Icon -->
                <span class="ParentUser" data-label="Account">
                    <img src="{{asset('home img&vid/user.png')}}" alt="user" class="user-icon headIcons" onclick="toggleMenu()"/>
                </span>
            </div>
            
            <div id="userMenu">
    @auth
        <p>{{ Auth::user()->name }}</p>
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('products.create') }}" class="dropdown-item">
                <i class="fas fa-plus"></i> Add Product
            </a>
            <a href="{{ route('products.index') }}" class="dropdown-item">
                <i class="fas fa-cog"></i> Manage Products
            </a>
        @endif
        <!-- ADD THIS LINK -->
        <a href="{{ route('orders.index') }}" class="dropdown-item">
            <i class="fas fa-shopping-bag"></i> My Orders
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="dropdown-item">
            <i class="fas fa-sign-in-alt"></i> Login
        </a>
        <a href="{{ route('register') }}" class="dropdown-item">
            <i class="fas fa-user-plus"></i> Register
        </a>
    @endauth
</div>
        </div>

        <img src="{{asset('home img&vid/hamp.png')}}" alt="navbar" id="sideBarIcon"/>
    </header>
    
    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="intro">
            <h1>SIGN-UP FOR <i>FitStore</i> NEWSLETTER</h1>
            <p>Be the first to know about our newest arrivals, special offers and store events near you.</p>
        </div>

        <div class="divider"></div>

        <div class="final">
            <div class="contacts">
                <h2>Customer Service</h2>
                <a href="#" class="cons">Help Center</a>
                <a href="#" class="cons">About Us</a>
                <a href="#" class="cons">Contact Us</a>
            </div>

            <div class="social">
                <h2>Connect With Us</h2>
                <div>
                    <img src="{{asset('home img&vid/facebook.png')}}" alt="Facebook" class="icons">
                    <img src="{{asset('home img&vid/insta.png')}}" alt="Instagram" class="icons">
                    <img src="{{asset('home img&vid/tiktok.png')}}" alt="TikTok" class="icons">
                    <img src="{{asset('home img&vid/youtube.png')}}" alt="YouTube" class="icons">
                </div>
            </div>

            <div class="cash">
                <h2>Payment Methods</h2>
                <div>
                    <img src="{{asset('home img&vid/pay2.png')}}" alt="Visa" class="pays">
                    <img src="{{asset('home img&vid/pay3.png')}}" alt="Mastercard" class="pays">
                    <img src="{{asset('home img&vid/pay4.png')}}" alt="PayPal" class="pays">
                    <img src="{{asset('home img&vid/pay5.png')}}" alt="Apple Pay" class="pays">
                    <img src="{{asset('home img&vid/pay6.png')}}" alt="Google Pay" class="pays">
                </div>
            </div>
        </div>

        <div class="year">
            © FITSTORE {{ date('Y') }}. ALL RIGHTS RESERVED.
        </div>
    </footer>

    <script>
        // Get CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Mobile menu toggle
        const navbar = document.getElementById("links_id");
        const btnOpen = document.getElementById("sideBarIcon");
        const btnClose = document.getElementById("exit_id");

        btnOpen.addEventListener('click', () => {
            navbar.classList.add('active');
        });

        btnClose.addEventListener('click', () => {
            navbar.classList.remove('active');
        });

        // Search box toggle
        const btnCloseSearch = document.getElementById("exitSearch");
        const searchBtn = document.getElementById("s");
        const searchBox = document.getElementById("sBox");

        searchBtn.addEventListener('click', () => {
            searchBox.style.top = "0";
            navbar.classList.remove('active');
        });

        btnCloseSearch.addEventListener('click', () => {
            searchBox.style.top = "-100px";
        });

        // User menu toggle
        function toggleMenu() {
            const menu = document.getElementById('userMenu');
            menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
        }

        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const icon = document.querySelector('.user-icon');
            const menu = document.getElementById('userMenu');
            
            if (icon && !icon.contains(event.target) && menu && !menu.contains(event.target)) {
                menu.style.display = 'none';
            }
        });

        // Function to update cart count
        function updateCartCount(count) {
            const cartCountElements = document.querySelectorAll('.cart-count');
            cartCountElements.forEach(element => {
                element.textContent = count;
            });
            
            // Store in localStorage for persistence across page loads
            localStorage.setItem('cartCount', count);
        }

        // Function to show notification
        function showNotification(message, type = 'success') {
            // Remove existing notifications
            const existingNotif = document.querySelector('.cart-notification');
            if (existingNotif) existingNotif.remove();
            
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `cart-notification ${type}`;
            notification.textContent = message;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#28a745' : '#dc3545'};
                color: white;
                padding: 15px 20px;
                border-radius: 4px;
                z-index: 10000;
                animation: slideIn 0.3s ease;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            `;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Function to fetch cart count from server
        function fetchCartCount() {
            // If user is authenticated, fetch from server
            fetch('/cart/count', {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.count);
                }
            })
            .catch(error => {
                console.error('Error fetching cart count:', error);
                // Fallback to localStorage
                const storedCount = localStorage.getItem('cartCount');
                if (storedCount !== null) {
                    updateCartCount(parseInt(storedCount));
                }
            });
        }

        // Initialize cart count on page load
        document.addEventListener('DOMContentLoaded', () => {
            // Try to get from localStorage first (for immediate UI update)
            const storedCount = localStorage.getItem('cartCount');
            if (storedCount !== null) {
                updateCartCount(parseInt(storedCount));
            }
            
            // Then fetch fresh count from server
            fetchCartCount();
            
            // Set up event listener for storage events (in case cart is updated in another tab)
            window.addEventListener('storage', (event) => {
                if (event.key === 'cartCount') {
                    updateCartCount(parseInt(event.newValue) || 0);
                }
            });
        });

        // Global function to be called from product pages
        window.updateCartCount = updateCartCount;
        window.showNotification = showNotification;
    </script>
    
    <!-- Include any page-specific scripts -->
    @stack('scripts')
</body>
</html>