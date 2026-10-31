@extends('layouts.app')

@section('title', $profile->user->name . ' | FreelanceHub Client')

@section('robots', 'index, follow')

@section('content')
@php
    $name      = $profile->user->name;
    $firstName = explode(' ', $name)[0];
    $initials  = collect(explode(' ', $name))->map(fn ($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
    $isOwner   = auth()->id() === $profile->user_id;
@endphp

<main class="container-wide profile-layout">

    <div class="profile-main">
        <section class="card">
            <div class="profile-header">
                <div class="avatar-xl">
                    {{ $initials }}
                    @if ($profile->availability_status)
                        <span class="status-dot" title="Currently hiring"></span>
                    @endif
                </div>

                <div class="profile-info">
                    <div class="name-row">
                        <h2>{{ $name }}</h2>
                    </div>
                    <div class="meta-row">
                        @if ($profile->current_job)
                            <span class="meta-item">💼 {{ $profile->current_job }}</span>
                        @endif
                        @if ($profile->current_job && $profile->industry)
                            <span class="meta-sep"></span>
                        @endif
                        @if ($profile->industry)
                            <span class="meta-item">{{ $profile->industry }}</span>
                        @endif
                    </div>
                </div>

                <div class="profile-actions">
                    @if ($isOwner)
                        <a href="/client/profile/edit" class="btn btn-primary">Edit profile</a>
                    @endif
                </div>
            </div>

            <hr class="divider">

            <h4>About</h4>
            <p class="bio">{{ $profile->bio ?? 'This client has not written a bio yet.' }}</p>
        </section>

        <h3 class="section-title">Reviews given</h3>
        <div class="card empty-state">
            <p style="font-size:28px;margin:0">⭐</p>
            <p style="margin:8px 0 0"><strong>No reviews yet</strong></p>
            <p class="hint">Reviews {{ $firstName }} leaves for freelancers will appear here.</p>
        </div>
    </div>

    <aside class="profile-side">
        <section class="card">
            <h4>{{ $firstName }}'s Snapshot</h4>
            <dl class="snapshot">
                <div><dt>Industry</dt><dd>{{ $profile->industry ?? 'Not set' }}</dd></div>
                <div><dt>Status</dt><dd>{{ $profile->availability_status ? 'Currently hiring' : 'Not hiring' }}</dd></div>
            </dl>
            <hr class="divider">
            <p class="overline">Member since</p>
            <p style="margin:0"><strong>{{ $profile->user->created_at->format('M Y') }}</strong></p>
        </section>
    </aside>

</main>
@endsection