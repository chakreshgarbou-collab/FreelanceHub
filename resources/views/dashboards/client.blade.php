@extends('layouts.app')

@section('title', 'Dashboard | FreelanceHub')

@section('content')
<main class="dash-container">

    <div class="dash-header">
        <div>
            <h2>{{ $greeting }}, {{ explode(' ', $user->name)[0] }} 👋</h2>
            <p>You're all set! Browse services to find the perfect freelancer for your first project.</p>
        </div>
        <a href="#" class="btn btn-primary">+ New Order</a>
    </div>

    <div class="stat-grid">
        @foreach ($stats as $stat)
            <div class="stat-card">
                <div class="stat-top">
                    <span class="stat-icon">{{ $stat['icon'] }}</span>
                    <span class="stat-hint">{{ $stat['hint'] }}</span>
                </div>
                <div class="stat-big">{{ $stat['value'] }}</div>
                <div class="stat-label">{{ $stat['label'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="dash-layout">

        <div class="card tabs-card">
            <div class="line-tabs">
                <button type="button" class="active" data-tab="orders">Orders</button>
                <button type="button" data-tab="messages">Messages</button>
                <button type="button" data-tab="saved">Saved</button>
            </div>

            <div class="tab-panel active empty-big" id="tab-orders">
                <div class="empty-icon">💼</div>
                <h3>No orders yet</h3>
                <p>Find vetted freelancers to bring your projects to life. Get started by browsing our services.</p>
                <a href="#" class="btn btn-primary">Browse Services</a>
            </div>

            <div class="tab-panel empty-big" id="tab-messages">
                <div class="empty-icon">💬</div>
                <h3>No messages</h3>
                <p>Messaging with freelancers is planned for a future release.</p>
            </div>

            <div class="tab-panel empty-big" id="tab-saved">
                <div class="empty-icon">🔖</div>
                <h3>Nothing saved yet</h3>
                <p>Services you save for later will appear here.</p>
            </div>
        </div>

        <div class="dash-side">
            <section class="card">
                <h4>Quick actions</h4>
                <ul class="quick-list">
                    <li><a href="#">🔍 Browse services <span>›</span></a></li>
                    <li><a href="/client/profile/edit">✏️ Edit my profile <span>›</span></a></li>
                    <li><a href="/clients/{{ $profile->id }}">👤 View public profile <span>›</span></a></li>
                    <li><a href="#">📝 Post a job <span>›</span></a></li>
                </ul>
            </section>

            <section class="card">
                <h4>Spend overview</h4>
                @php $colors = ['#4f46e5', '#0891b2', '#10b981']; @endphp
                @foreach ($spend as $category => $percent)
                    <div class="spend-row">
                        <div class="spend-head"><span>{{ $category }}</span><strong>{{ $percent }}%</strong></div>
                        <div class="bar"><span style="width: {{ $percent }}%; background: {{ $colors[$loop->index] }}"></span></div>
                    </div>
                @endforeach
            </section>

            <section class="promo">
                <p class="overline">Recommended</p>
                <h4>Need a mobile app?</h4>
                <p>Browse verified mobile developers available now.</p>
                <a href="#">Browse →</a>
            </section>
        </div>
    </div>
</main>

<script>
    document.querySelectorAll('.line-tabs button').forEach(function (button) {
        button.addEventListener('click', function () {
            document.querySelectorAll('.line-tabs button').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            button.classList.add('active');
            document.getElementById('tab-' + button.dataset.tab).classList.add('active');
        });
    });
</script>
@endsection