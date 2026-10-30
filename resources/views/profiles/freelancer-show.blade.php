@extends('layouts.app')

@section('title', $profile->user->name . ' – ' . $profile->professional_title . ' | FreelanceHub')

@section('robots', 'index, follow')

@section('content')
@php
    $name      = $profile->user->name;
    $firstName = explode(' ', $name)[0];
    $initials  = collect(explode(' ', $name))->map(fn ($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
    $skills    = array_filter(array_map('trim', explode(',', $profile->skills ?? '')));
    $isOwner   = auth()->id() === $profile->user_id;
@endphp

<main class="container-wide profile-layout">

    <div class="profile-main">
        <section class="card">
            <div class="profile-header">
                <div class="avatar-xl">
                    {{ $initials }}
                    @if ($profile->availability_status)
                        <span class="status-dot" title="Available for work"></span>
                    @endif
                </div>

                <div class="profile-info">
                    <div class="name-row">
                        <h2>{{ $name }}</h2>
                    </div>
                    <div class="meta-row">
                        @if ($profile->location)
                            <span class="meta-item">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/></svg>
                                {{ $profile->location }}
                            </span>
                            <span class="meta-sep"></span>
                        @endif
                        <span class="rating">
                            <span class="star">★</span>
                            <strong>New</strong>
                            <span class="count">(no reviews yet)</span>
                        </span>
                    </div>
                </div>

                <div class="profile-actions">
                    @if ($isOwner)
                        <a href="/freelancer/profile/edit" class="btn btn-primary">Edit profile</a>
                    @else
                        <button class="btn btn-outline" disabled title="Coming soon">Save to List</button>
                        <button class="btn btn-primary" disabled title="Coming soon">Contact {{ $firstName }}</button>
                    @endif
                </div>
            </div>

            <hr class="divider">

            <h4>{{ $profile->professional_title }}</h4>
            <p class="bio">{{ $profile->bio ?? 'This freelancer has not written a bio yet.' }}</p>
        </section>

        <h3 class="section-title">Recent Reviews</h3>
        <div class="card empty-state">
            <p style="font-size:28px;margin:0">⭐</p>
            <p style="margin:8px 0 0"><strong>No reviews yet</strong></p>
            <p class="hint">{{ $firstName }}'s reviews will appear here after their first completed order.</p>
        </div>
    </div>

    <aside class="profile-side">
        <section class="card">
            <h4>{{ $firstName }}'s Snapshot</h4>
            <dl class="snapshot">
                <div><dt>Hourly rate</dt><dd>Rs {{ number_format($profile->hourly_rate, 2) }}</dd></div>
                <div><dt>Availability</dt><dd>{{ $profile->availability_status ? 'Available now' : 'Not available' }}</dd></div>
            </dl>
            <hr class="divider">
            <p class="overline">Member since</p>
            <p style="margin:0"><strong>{{ $profile->user->created_at->format('M Y') }}</strong></p>
        </section>

        <section class="card">
            <h4>Skills &amp; Expertise</h4>
            @if (count($skills))
                <div class="chips">
                    @foreach ($skills as $skill)
                        <span class="chip">{{ $skill }}</span>
                    @endforeach
                </div>
            @else
                <p class="subtitle" style="margin-bottom:0">No skills listed yet.</p>
            @endif
        </section>
    </aside>

</main>
@endsection