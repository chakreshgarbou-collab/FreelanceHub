@extends('layouts.app')

@section('title', 'Edit Freelancer Profile | FreelanceHub')
{{-- No robots section here, so the layout's default "noindex" keeps this private page out of search engines --}}

@section('content')
@php
    $user     = auth()->user();
    $initials = collect(explode(' ', $user->name))->map(fn ($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
@endphp

<main class="container">

    <div class="page-header">
        <div class="avatar-xl">{{ $initials }}</div>
        <div class="profile-info">
            <h2>{{ $user->name }}</h2>
            <p class="meta">Edit how clients see you on FreelanceHub</p>
        </div>
        @if ($profile)
            <a href="/freelancers/{{ $profile->id }}" class="btn btn-outline">View public profile</a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/freelancer/profile" class="card">
        @csrf
        @method('PUT')

        <h3 class="form-section">Basic information</h3>

        <div class="form-group">
            <label class="label" for="professional_title">Professional title *</label>
            <input class="input" type="text" id="professional_title" name="professional_title"
                   required maxlength="100" placeholder="e.g. Full-Stack Web Developer"
                   value="{{ old('professional_title', $profile->professional_title ?? '') }}">
        </div>

        <div class="form-group">
            <label class="label" for="bio">Bio</label>
            <textarea class="input" id="bio" name="bio" maxlength="2000"
                      placeholder="Tell clients about your experience, what you specialise in and how you work...">{{ old('bio', $profile->bio ?? '') }}</textarea>
            <p class="hint">Maximum 2000 characters.</p>
        </div>

        <hr class="divider">

        <h3 class="form-section">Skills</h3>

        <div class="form-group">
            <label class="label" for="skills">Your skills (separate with commas)</label>
            <input class="input" type="text" id="skills" name="skills" maxlength="255"
                   placeholder="e.g. Laravel, React, Figma"
                   value="{{ old('skills', $profile->skills ?? '') }}">
            <div class="chips" id="skills-preview"></div>
        </div>

        <hr class="divider">

        <h3 class="form-section">Rates &amp; availability</h3>

        <div class="form-row">
            <div class="form-group">
                <label class="label" for="location">Location</label>
                <input class="input" type="text" id="location" name="location" maxlength="100"
                       placeholder="e.g. Port Louis, Mauritius"
                       value="{{ old('location', $profile->location ?? '') }}">
            </div>
            <div class="form-group">
                <label class="label" for="hourly_rate">Hourly rate (Rs) *</label>
                <input class="input" type="number" id="hourly_rate" name="hourly_rate"
                       required min="0" max="100000" step="0.01" placeholder="e.g. 500"
                       value="{{ old('hourly_rate', $profile->hourly_rate ?? '') }}">
            </div>
        </div>

        <div class="toggle-row">
            <div>
                <strong>Available for new work</strong>
                <p class="hint">Clients see a green dot on your profile when this is on.</p>
            </div>
            <input type="hidden" name="availability_status" value="0">
            <label class="switch">
                <input type="checkbox" id="availability_status" name="availability_status" value="1"
                       {{ old('availability_status', $profile->availability_status ?? true) ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
        </div>

        <div class="form-actions">
            @if ($profile)
                <a href="/freelancers/{{ $profile->id }}" class="btn btn-outline">Cancel</a>
            @endif
            <button type="submit" class="btn btn-primary">Save profile</button>
        </div>
    </form>
</main>

<script>
    // Live preview of skill chips while the freelancer types
    const skillsInput = document.getElementById('skills');
    const preview = document.getElementById('skills-preview');

    function renderChips() {
        preview.innerHTML = '';
        skillsInput.value.split(',')
            .map(skill => skill.trim())
            .filter(skill => skill !== '')
            .forEach(skill => {
                const chip = document.createElement('span');
                chip.className = 'chip';
                chip.textContent = skill;   // textContent (not innerHTML) so typed HTML can't run: prevents XSS
                preview.appendChild(chip);
            });
    }

    skillsInput.addEventListener('input', renderChips);
    renderChips();
</script>
@endsection