@extends('layouts.app')

@section('title', 'Dashboard | FreelanceHub')

@section('content')
@php
    $firstName = explode(' ', $user->name)[0];
@endphp

<main class="dash-container">

    <div class="dash-header">
        <div>
            <h2>Your workspace, {{ $firstName }}</h2>
            @if ($strength < 100)
                <p>Complete your profile to get discovered by potential clients.</p>
            @else
                <p>Your profile is complete. Clients can now discover you.</p>
            @endif
        </div>
        <a href="#" class="btn btn-primary" title="Service creation is part of the Service Catalogue module">+ Add Service</a>
    </div>

    <div class="stat-grid">
        @foreach ($stats as $stat)
            <div class="stat-card">
                <div class="stat-label">{{ $stat['label'] }}</div>
                <div class="stat-value">{{ $stat['value'] }}</div>
                <div class="stat-note">{{ $stat['note'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="pill-tabs">
        <button type="button" class="active" data-tab="overview">Overview</button>
        <button type="button" data-tab="matches">Job Matches</button>
        <button type="button" data-tab="gigs">Active Gigs</button>
    </div>

    <div class="tab-panel active" id="tab-overview">
        <div class="dash-layout">
            <div class="card empty-big">
                <div class="empty-icon">💼</div>
                <h3>No activity yet</h3>
                <p>Get started by completing your profile checklist or publishing your first service listing to get orders.</p>
                <a href="#" class="btn btn-primary">+ Add Service</a>
            </div>

            <div class="dash-side">
                <section class="card">
                    <h4>Profile strength</h4>
                    <div class="strength">
                        <div class="ring" style="--p: {{ $strength }}"><span>{{ $strength }}%</span></div>
                        <div>
                            @if ($strength == 100)
                                <strong>Good standing</strong>
                                <small>Your profile is complete</small>
                            @elseif ($strength >= 60)
                                <strong>Almost there</strong>
                                <small>Finish the checklist to stand out</small>
                            @else
                                <strong>Incomplete profile</strong>
                                <small>Fill the essentials to get discovered</small>
                            @endif
                        </div>
                    </div>
                    <ul class="checklist">
                        @foreach ($checks as $label => $done)
                            <li class="{{ $done ? 'done' : '' }}">
                                <span class="check-icon">{{ $done ? '✓' : '' }}</span>
                                {{ $label }}
                            </li>
                        @endforeach
                    </ul>
                    @if ($strength < 100)
                        <p style="margin:14px 0 0"><a href="/freelancer/profile/edit" class="btn-small">Complete profile</a></p>
                    @endif
                </section>

                <section class="card">
                    <h4>Top skills</h4>
                    @if (count($skills))
                        <div class="chips">
                            @foreach ($skills as $skill)
                                <span class="chip">{{ $skill }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="hint" style="text-align:center;margin:12px 0">No skills added yet</p>
                        <p style="text-align:center;margin:0"><a href="/freelancer/profile/edit" class="btn-small">+ Add Skills</a></p>
                    @endif
                </section>
            </div>
        </div>
    </div>

    <div class="tab-panel" id="tab-matches">
        <div class="card empty-big">
            <div class="empty-icon">🔍</div>
            <h3>No job matches yet</h3>
            <p>Job matching is planned for a future release. Keep your skills up to date so we can match you with the right clients.</p>
        </div>
    </div>

    <div class="tab-panel" id="tab-gigs">
        <div class="card empty-big">
            <div class="empty-icon">📦</div>
            <h3>No active gigs</h3>
            <p>When clients order your services, your ongoing projects and their progress will appear here.</p>
        </div>
    </div>

</main>

<script>
    document.querySelectorAll('.pill-tabs button').forEach(function (button) {
        button.addEventListener('click', function () {
            document.querySelectorAll('.pill-tabs button').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            button.classList.add('active');
            document.getElementById('tab-' + button.dataset.tab).classList.add('active');
        });
    });
</script>
@endsection