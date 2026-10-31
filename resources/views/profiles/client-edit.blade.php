@extends('layouts.app')

@section('title', 'Edit Client Profile | FreelanceHub')

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
            <p class="meta">Tell freelancers about you and your business</p>
        </div>
        @if ($profile)
            <a href="/clients/{{ $profile->id }}" class="btn btn-outline">View public profile</a>
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

    <form method="POST" action="/client/profile" class="card">
        @csrf
        @method('PUT')

        <h3 class="form-section">Work information</h3>

        <div class="form-row">
            <div class="form-group">
                <label class="label" for="industry">Industry</label>
                <input class="input" type="text" id="industry" name="industry" maxlength="100"
                       placeholder="e.g. E-commerce, Finance"
                       value="{{ old('industry', $profile->industry ?? '') }}">
            </div>
            <div class="form-group">
                <label class="label" for="current_job">Current job</label>
                <input class="input" type="text" id="current_job" name="current_job" maxlength="100"
                       placeholder="e.g. Marketing Manager"
                       value="{{ old('current_job', $profile->current_job ?? '') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="label" for="bio">About you</label>
            <textarea class="input" id="bio" name="bio" maxlength="2000"
                      placeholder="Describe your business and the kind of work you usually need...">{{ old('bio', $profile->bio ?? '') }}</textarea>
            <p class="hint">Maximum 2000 characters.</p>
        </div>

        <hr class="divider">

        <h3 class="form-section">Private details</h3>

        <div class="form-group">
            <label class="label" for="address">Address</label>
            <input class="input" type="text" id="address" name="address" maxlength="255"
                   placeholder="e.g. Royal Road, Rose Hill, Mauritius"
                   value="{{ old('address', $profile->address ?? '') }}">
            <p class="hint">🔒 Never shown on your public profile.</p>
        </div>

        <div class="toggle-row">
            <div>
                <strong>Currently hiring</strong>
                <p class="hint">Let freelancers know you're looking for help right now.</p>
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
                <a href="/clients/{{ $profile->id }}" class="btn btn-outline">Cancel</a>
            @endif
            <button type="submit" class="btn btn-primary">Save profile</button>
        </div>
    </form>
</main>
@endsection