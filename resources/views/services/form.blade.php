@php
    $editing = isset($service) && $service !== null;

    $serviceData = $editing
        ? $service->only([
            'service_id',
            'title',
            'description',
            'price',
            'delivery_days',
            'category_id'
        ])
        : null;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        FreelanceHub | {{ $editing ? 'Edit Service' : 'Create Service' }}
    </title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --navy: #15344e;
            --teal: #16a89e;
            --border: #d6e1e9;
            --text: #263b50;
            --muted: #6c8196;
            --background: #f5f8fb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--background);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        .topbar {
            background: var(--navy);
            color: white;
            padding: 22px 7%;
        }

        .brand {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 21px;
            letter-spacing: 1px;
        }

        .container {
            width: min(760px, 92%);
            margin: 40px auto;
        }

        .heading {
            margin-bottom: 25px;
        }

        .heading h1 {
            color: var(--navy);
            font-size: 32px;
            margin-bottom: 10px;
        }

        .heading p {
            color: var(--muted);
            line-height: 1.6;
        }

        .form-card {
            background: white;
            padding: 32px;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(21, 52, 78, 0.05);
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            color: var(--navy);
            font-weight: bold;
            margin-bottom: 9px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 13px 15px;
            border: 2px solid var(--border);
            border-radius: 9px;
            font-size: 15px;
            font-family: inherit;
            background: white;
            color: var(--text);
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: 2px solid var(--teal);
            border-color: var(--teal);
        }

        textarea {
            min-height: 130px;
            resize: vertical;
        }

        .help {
            display: block;
            color: var(--muted);
            font-size: 13px;
            margin-top: 6px;
        }

        .field-error {
            display: block;
            min-height: 18px;
            color: #b42318;
            font-size: 13px;
            margin-top: 6px;
        }

        .invalid {
            border-color: #c0392b;
            background: #fffafa;
        }

        .message {
            display: none;
            padding: 13px 15px;
            border-radius: 9px;
            margin-bottom: 22px;
            line-height: 1.5;
        }

        .message.success {
            display: block;
            background: #e9f8f1;
            color: #176b45;
        }

        .message.error {
            display: block;
            background: #fff0ef;
            color: #a12d27;
        }

        .button-row {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 28px;
        }

        .button {
            border: none;
            border-radius: 9px;
            padding: 13px 20px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
        }

        .primary {
            background: var(--teal);
            color: white;
        }

        .primary:hover {
            background: #118b83;
        }

        .secondary {
            background: #eaf2f9;
            color: var(--navy);
        }

        .danger {
            background: #fff0ef;
            color: #a12d27;
        }

        .button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .footer {
            text-align: center;
            color: var(--muted);
            font-size: 13px;
            padding: 25px;
        }

        @media (max-width: 560px) {
            .form-card {
                padding: 21px;
            }

            .button-row {
                flex-direction: column;
                align-items: stretch;
            }

            .button {
                text-align: center;
            }
        }
    </style>
</head>

<body>

<header class="topbar">
    <a href="{{ route('services.catalogue') }}" class="brand">
        FREELANCE HUB
    </a>
</header>

<main class="container">

    <section class="heading">

        <h1>
            {{ $editing ? 'Edit your service' : 'Create a new service' }}
        </h1>

        <p>
            {{ $editing
                ? 'Update your service details and keep your listing accurate.'
                : 'Publish your freelance service so clients can discover it.'
            }}
        </p>

    </section>

    <section class="form-card">

        <div id="form-message" class="message" role="alert"></div>

        <form id="service-form">

            @csrf

            <div class="form-group">

                <label for="title">Service title</label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    maxlength="120"
                    required
                    value="{{ old('title', $editing ? $service->title : '') }}"
                    placeholder="e.g. Professional Logo Design"
                >

                <small class="help">
                    Maximum 120 characters.
                </small>

                <span class="field-error" id="title-error"></span>

            </div>

            <div class="form-group">

                <label for="description">Description</label>

                <textarea
                    id="description"
                    name="description"
                    maxlength="2000"
                    required
                    placeholder="Describe the service you are offering..."
                >{{ old('description', $editing ? $service->description : '') }}</textarea>

                <small class="help">
                    Maximum 2000 characters.
                </small>

                <span class="field-error" id="description-error"></span>

            </div>

            <div class="form-group">

                <label for="price">Price (Rs)</label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    min="1"
                    max="1000000"
                    step="0.01"
                    required
                    value="{{ old('price', $editing ? $service->price : '') }}"
                    placeholder="e.g. 1500"
                >

                <span class="field-error" id="price-error"></span>

            </div>

            <div class="form-group">

                <label for="delivery_days">Delivery days</label>

                <input
                    type="number"
                    id="delivery_days"
                    name="delivery_days"
                    min="1"
                    max="365"
                    step="1"
                    required
                    value="{{ old('delivery_days', $editing ? $service->delivery_days : '') }}"
                    placeholder="e.g. 3"
                >

                <small class="help">
                    Enter a whole number between 1 and 365.
                </small>

                <span class="field-error" id="delivery_days-error"></span>

            </div>

            <div class="form-group">

                <label for="category_id">Service category</label>

                <select id="category_id" name="category_id" required>

                    <option value="">Loading categories...</option>

                </select>

                <small class="help">
                    Select one active category for your service.
                </small>

                <span class="field-error" id="category_id-error"></span>

            </div>

            <div class="button-row">

                <button type="submit" class="button primary" id="submit-button">
                    {{ $editing ? 'Save Changes' : 'Publish Service' }}
                </button>

                @if($editing)

                    <button
                        type="button"
                        class="button danger"
                        id="deactivate-button"
                    >
                        Deactivate Service
                    </button>

                @endif

                <a href="{{ route('services.catalogue') }}"
                   class="button secondary">
                    Cancel
                </a>

            </div>

        </form>

    </section>

</main>

<footer class="footer">
    FreelanceHub – Service Management
</footer>

<script>
$(document).ready(function () {

    const existingService = @json($serviceData);

    const serviceId = existingService
        ? existingService.service_id
        : null;

    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    const $form = $('#service-form');
    const $message = $('#form-message');
    const $category = $('#category_id');
    const $submit = $('#submit-button');

    // Send JSON preference and CSRF header with AJAX requests.
    $.ajaxSetup({
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    });

    // Display a success or error message.
    function showMessage(message, type) {

        $message
            .removeClass('success error')
            .addClass(type)
            .text(message)
            .show();
    }

    // Clear all previous validation messages.
    function clearErrors() {

        $('.field-error').text('');

        $('input, textarea, select')
            .removeClass('invalid');

        $message.hide().text('');

    }

    // Display Laravel's HTTP 422 validation errors beside fields.
    function showValidationErrors(errors) {

        Object.keys(errors).forEach(function (field) {

            const messages = errors[field];

            $('#' + field + '-error').text(messages[0]);

            $('[name="' + field + '"]').addClass('invalid');

        });

    }

    // Load active categories from Laravel.
    function loadCategories() {

        $.getJSON('/api/categories')

            .done(function (response) {

                $category.empty();

                $category.append(
                    $('<option>').val('').text('Select a category')
                );

                const categories = Array.isArray(response.data)
                    ? response.data
                    : [];

                categories.forEach(function (category) {

                    const $option = $('<option>')
                        .val(category.category_id)
                        .text(category.category_name);

                    $category.append($option);

                });

                // Select the existing category when editing.
                if (existingService) {
                    $category.val(existingService.category_id);
                }

            })

            .fail(function () {

                $category.empty();

                $category.append(
                    $('<option>').val('').text('Unable to load categories')
                );

                showMessage(
                    'Could not retrieve categories. Please refresh the page.',
                    'error'
                );

            });

    }

    // Submit the create or edit form.
    $form.on('submit', function (event) {

        event.preventDefault();

        clearErrors();

        // Run browser-side validation first.
        if (!this.checkValidity()) {
            this.reportValidity();
            return;
        }

        const url = serviceId
            ? '/api/services/' + encodeURIComponent(serviceId)
            : '/api/services';

        const method = serviceId ? 'PUT' : 'POST';

        $submit.prop('disabled', true).text('Saving...');

        $.ajax({
            url: url,
            method: method,
            data: $form.serialize(),
            dataType: 'json'
        })

        .done(function (response) {

            showMessage(
                serviceId
                    ? 'Your service has been updated successfully.'
                    : 'Your service has been published successfully.',
                'success'
            );

            if (!serviceId) {

                $form[0].reset();

                $category.val('');

            }

        })

        .fail(function (xhr) {

            if (xhr.status === 422 && xhr.responseJSON.errors) {

                showValidationErrors(xhr.responseJSON.errors);

                showMessage(
                    'Please correct the highlighted fields.',
                    'error'
                );

            } else if (xhr.status === 401) {

                showMessage(
                    'Please sign in before managing a service.',
                    'error'
                );

            } else if (xhr.status === 403) {

                showMessage(
                    'You are not authorised to manage this service.',
                    'error'
                );

            } else {

                const errorMessage = xhr.responseJSON
                    ? xhr.responseJSON.message
                    : 'Something went wrong. Please try again.';

                showMessage(errorMessage, 'error');

            }

        })

        .always(function () {

            $submit.prop('disabled', false).text(
                serviceId ? 'Save Changes' : 'Publish Service'
            );

        });

    });

    // Deactivate an existing service.
    $('#deactivate-button').on('click', function () {

        if (!serviceId) {
            return;
        }

        const confirmed = window.confirm(
            'Are you sure you want to deactivate this service? It will no longer appear in the active catalogue.'
        );

        if (!confirmed) {
            return;
        }

        const $button = $(this);

        $button.prop('disabled', true).text('Deactivating...');

        $.ajax({
            url: '/api/services/' + encodeURIComponent(serviceId) + '/deactivate',
            method: 'PATCH',
            dataType: 'json'
        })

        .done(function (response) {

            showMessage(
                'The service has been deactivated. The database record has been retained.',
                'success'
            );

            $submit.prop('disabled', true);
            $button.text('Deactivated');

        })

        .fail(function (xhr) {

            if (xhr.status === 403) {

                showMessage(
                    'You are not authorised to deactivate this service.',
                    'error'
                );

            } else if (xhr.status === 401) {

                showMessage(
                    'Please sign in before managing a service.',
                    'error'
                );

            } else {

                showMessage(
                    'Could not deactivate the service. Please try again.',
                    'error'
                );

            }

            $button.prop('disabled', false).text('Deactivate Service');

        });

    });

    // Load categories when the page opens.
    loadCategories();

});
</script>

</body>
</html>