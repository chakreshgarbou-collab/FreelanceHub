<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>FreelanceHub | Service Catalogue</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --navy: #15344e;
            --teal: #16a89e;
            --light-blue: #eaf2f9;
            --border: #d6e1e9;
            --text: #263b50;
            --muted: #6c8196;
            --white: #ffffff;
            --background: #f5f8fb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--background);
            color: var(--text);
        }

        .topbar {
            background: var(--navy);
            color: white;
            padding: 22px 7%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .brand {
            color: white;
            text-decoration: none;
            font-size: 21px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .topbar-label {
            color: #c8d8e7;
            font-size: 14px;
        }

        .container {
            width: min(1200px, 90%);
            margin: 45px auto;
        }

        .heading h1 {
            font-size: clamp(27px, 4vw, 40px);
            color: var(--navy);
            margin: 0 0 10px;
        }

        .heading p {
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .toolbar {
            display: grid;
            grid-template-columns: 2fr 1fr auto;
            gap: 18px;
            margin-bottom: 35px;
        }

        .toolbar input,
        .toolbar select {
            width: 100%;
            min-height: 58px;
            padding: 15px 18px;
            border: 2px solid var(--border);
            border-radius: 13px;
            background: white;
            color: var(--text);
            font-size: 16px;
        }

        .toolbar input:focus,
        .toolbar select:focus {
            outline: 2px solid var(--teal);
            border-color: var(--teal);
        }

        .button {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            min-height: 48px;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            background: var(--teal);
            color: white;
            text-decoration: none;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .button:hover {
            background: #118b83;
        }

        .message {
            padding: 13px 16px;
            border-radius: 9px;
            margin-bottom: 20px;
            color: var(--muted);
        }

        .message.error {
            background: #fff0ef;
            color: #a12d27;
        }

        .message.success {
            background: #e9f8f1;
            color: #176b45;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 25px;
        }

        .service-card {
            background: white;
            border: 2px solid var(--border);
            border-radius: 17px;
            padding: 18px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 22px rgba(21, 52, 78, 0.09);
        }

        .card-art {
            height: 115px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
            font-size: 38px;
            font-weight: bold;
        }

        .tone-1 {
            background: #fcece8;
            color: #f07860;
        }

        .tone-2 {
            background: #eaf2f9;
            color: #3379b9;
        }

        .tone-3 {
            background: #e7f6f2;
            color: #16a89e;
        }

        .category-label {
            color: var(--muted);
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
            margin-bottom: 9px;
        }

        .service-card h2 {
            color: var(--navy);
            font-size: 22px;
            margin: 0 0 15px;
            overflow-wrap: anywhere;
        }

        .service-description {
            color: var(--muted);
            line-height: 1.5;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .price {
            color: var(--teal);
            font-size: 23px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .delivery {
            color: var(--muted);
            margin: 0;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin: 35px 0;
        }

        .pagination button {
            padding: 10px 17px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: white;
            cursor: pointer;
        }

        .pagination button:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .footer {
            background: var(--navy);
            color: #c8d8e7;
            text-align: center;
            padding: 24px;
            font-size: 13px;
        }

        @media (max-width: 850px) {
            .service-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .toolbar {
                grid-template-columns: 1fr 1fr;
            }

            .toolbar .button {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 560px) {
            .service-grid {
                grid-template-columns: 1fr;
            }

            .toolbar {
                grid-template-columns: 1fr;
            }

            .container {
                margin: 28px auto;
            }
        }
    </style>
</head>

<body>

<header class="topbar">
    <a href="/" class="brand">FREELANCE HUB</a>
    <span class="topbar-label">/ SERVICE CATALOGUE</span>
</header>

<main class="container">

    <section class="heading">
        <h1>Find a service for your next project</h1>
        <p>
            Discover freelance services, compare listings and find
            the right service for your needs.
        </p>
    </section>

    <section class="toolbar">

        <input
            type="search"
            id="search"
            maxlength="100"
            placeholder="Search services (e.g. logo design)"
            aria-label="Search services"
        >

        <select id="category-filter" aria-label="Filter by category">
            <option value="">All categories</option>
        </select>

        {{-- Only logged-in users with a freelancer profile can create services --}}
        @if(auth()->check() && auth()->user()->freelancerProfile)
            <a href="{{ route('services.create') }}" class="button">
                + Create Service
            </a>
        @endif

    </section>

    <div id="message" class="message" role="status">
        Loading services...
    </div>

    <section id="service-grid" class="service-grid"
             aria-live="polite">
    </section>

    <div class="pagination">
        <button id="previous-page" type="button" disabled>
            Previous
        </button>

        <span id="page-info">Page 1</span>

        <button id="next-page" type="button" disabled>
            Next
        </button>
    </div>

</main>

<footer class="footer">
    FreelanceHub – Connecting clients with local freelance talent.
</footer>

<script>
$(document).ready(function () {

    const $search = $('#search');
    const $category = $('#category-filter');
    const $grid = $('#service-grid');
    const $message = $('#message');

    let currentPage = 1;
    let lastPage = 1;
    let searchTimer = null;

    // Display a message above the service cards.
    function showMessage(message, type = '') {
        $message
            .removeClass('error success')
            .addClass(type)
            .text(message)
            .toggle(message !== '');
    }

    // Format prices in Mauritian rupees.
    function formatPrice(value) {
        const amount = Number(value);

        if (!Number.isFinite(amount)) {
            return 'Rs ' + value;
        }

        return 'Rs ' + amount.toLocaleString('en-MU', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        });
    }

    // Retrieve active categories for the dropdown.
    function loadCategories() {

        $.getJSON('/api/categories')

            .done(function (response) {

                const categories = Array.isArray(response.data)
                    ? response.data
                    : [];

                categories.forEach(function (category) {

                    $('<option>')
                        .val(category.category_id)
                        .text(category.category_name)
                        .appendTo($category);

                });

            })

            .fail(function () {
                showMessage(
                    'Unable to load categories. Please refresh the page.',
                    'error'
                );
            });
    }

    // Create a service card using safe text insertion.
    function createServiceCard(service, index) {

        const categoryName = service.category
            ? service.category.category_name
            : 'Uncategorised';

        const icons = ['✦', '</>', '✎'];

        const $card = $('<article>').addClass('service-card');

        const $art = $('<div>')
            .addClass('card-art tone-' + ((index % 3) + 1))
            .text(icons[index % icons.length]);

        const $categoryLabel = $('<div>')
            .addClass('category-label')
            .text(categoryName);

        const $title = $('<h2>')
            .text(service.title || 'Untitled service');

        const $description = $('<p>')
            .addClass('service-description')
            .text(service.description || '');

        const $price = $('<div>')
            .addClass('price')
            .text(formatPrice(service.price));

        const $delivery = $('<p>')
            .addClass('delivery')
            .text('Delivery: ' + service.delivery_days + ' days');

        $card.append(
            $art,
            $categoryLabel,
            $title,
            $description,
            $price,
            $delivery
        );

        return $card;
    }

    // Display services returned by Laravel.
    function displayServices(response) {

        const pagination = response.data || {};

        const services = Array.isArray(pagination.data)
            ? pagination.data
            : [];

        $grid.empty();

        if (services.length === 0) {
            showMessage('No active services were found.');
        } else {

            showMessage('');

            services.forEach(function (service, index) {
                $grid.append(createServiceCard(service, index));
            });
        }

        currentPage = pagination.current_page || 1;
        lastPage = pagination.last_page || 1;

        $('#page-info').text(
            'Page ' + currentPage + ' of ' + lastPage
        );

        $('#previous-page').prop('disabled', currentPage <= 1);
        $('#next-page').prop('disabled', currentPage >= lastPage);
    }

    // Retrieve services from the Laravel API.
    function loadServices(page = 1) {

        const parameters = {
            page: page
        };

        const keyword = $search.val().trim();
        const categoryId = $category.val();

        if (keyword !== '') {
            parameters.search = keyword;
        }

        if (categoryId !== '') {
            parameters.category_id = categoryId;
        }

        showMessage('Loading services...');
        $grid.empty();

        $.getJSON('/api/services', parameters)

            .done(function (response) {

                if (response.success) {
                    displayServices(response);
                } else {
                    showMessage('Unable to retrieve services.', 'error');
                }

            })

            .fail(function () {
                showMessage(
                    'Could not load services. Please check the API route and try again.',
                    'error'
                );
            });
    }

    // Search when the user types.
    $search.on('input', function () {

        clearTimeout(searchTimer);

        searchTimer = setTimeout(function () {
            loadServices(1);
        }, 350);

    });

    // Filter when a category is selected.
    $category.on('change', function () {
        loadServices(1);
    });

    // Pagination controls.
    $('#previous-page').on('click', function () {
        if (currentPage > 1) {
            loadServices(currentPage - 1);
        }
    });

    $('#next-page').on('click', function () {
        if (currentPage < lastPage) {
            loadServices(currentPage + 1);
        }
    });

    // Initial page loading.
    loadCategories();
    loadServices();

});
</script>

</body>
</html>