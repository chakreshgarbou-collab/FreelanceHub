<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Private page: tell search engines not to index it -->
    <meta name="robots" content="noindex, nofollow">
    <title>Edit Freelancer Profile | Freelance Hub</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; margin: 0; padding: 40px 16px; }
        .card { max-width: 600px; margin: auto; background: #fff; padding: 32px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,.08); }
        h1 { margin-top: 0; }
        label { display: block; font-weight: bold; margin: 16px 0 6px; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; font-size: 15px; }
        .checkbox { display: flex; align-items: center; gap: 8px; margin-top: 16px; }
        .checkbox input { width: auto; }
        button { margin-top: 24px; background: #1e6fd9; color: #fff; border: 0; padding: 12px 24px; border-radius: 6px; font-size: 15px; cursor: pointer; }
        .success { background: #e6f6ea; color: #1d6b34; padding: 12px; border-radius: 6px; }
        .errors { background: #fdecea; color: #a12622; padding: 12px; border-radius: 6px; }
    </style>
</head>
<body>
<div class="card">
    <h1>Freelancer Profile</h1>

    @if (session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/freelancer/profile">
        @csrf
        @method('PUT')

        <label for="professional_title">Professional title *</label>
        <input type="text" id="professional_title" name="professional_title" required maxlength="100"
               value="{{ old('professional_title', $profile->professional_title ?? '') }}">

        <label for="bio">Bio</label>
        <textarea id="bio" name="bio" rows="4" maxlength="2000">{{ old('bio', $profile->bio ?? '') }}</textarea>

        <label for="skills">Skills (comma-separated)</label>
        <input type="text" id="skills" name="skills" maxlength="255"
               value="{{ old('skills', $profile->skills ?? '') }}">

        <label for="location">Location</label>
        <input type="text" id="location" name="location" maxlength="100"
               value="{{ old('location', $profile->location ?? '') }}">

        <label for="hourly_rate">Hourly rate (Rs) *</label>
        <input type="number" id="hourly_rate" name="hourly_rate" required min="0" max="100000" step="0.01"
               value="{{ old('hourly_rate', $profile->hourly_rate ?? '') }}">

        <div class="checkbox">
            <input type="hidden" name="availability_status" value="0">
            <input type="checkbox" id="availability_status" name="availability_status" value="1"
                   {{ old('availability_status', $profile->availability_status ?? true) ? 'checked' : '' }}>
            <label for="availability_status" style="margin:0">Available for work</label>
        </div>

        <button type="submit">Save profile</button>
    </form>
</div>
</body>
</html>