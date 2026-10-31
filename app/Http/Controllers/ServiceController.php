<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class ServiceController extends Controller
{
    private function rules(): array
    {
        return [
            'title' => 'required|string|max:120',

            'description' => 'required|string|max:2000',

            'price' => 'required|numeric|min:1|max:1000000',

            'delivery_days' => 'required|integer|min:1|max:365',

            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'category_id')
                    ->where('status', 'active'),
            ],
        ];
    }

    public function index(Request $request)
    {
        $f = $request->validate([
            'search' => 'nullable|string|max:100',

            'category_id' =>
                'nullable|integer|exists:categories,category_id',
        ]);

        $q = Service::with([
            'category:category_id,category_name'
        ])->where('status', 'active');

        if (($f['search'] ?? '') !== '') {

            $term = '%' . $f['search'] . '%';

            $q->where(function ($w) use ($term) {
                $w->where('title', 'like', $term)
                  ->orWhere('description', 'like', $term);
            });
        }

        if (!empty($f['category_id'])) {
            $q->where('category_id', $f['category_id']);
        }

        return response()->json([
            'success' => true,
            'data' => $q->latest()->paginate(12),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $profile = $request->user()->freelancerProfile;

        abort_unless($profile, 403);

        $service = $profile->services()
            ->create($data + ['status' => 'active']);

        return response()->json([
            'success' => true,
            'data' => $service
        ], 201);
    }

    public function update(Request $request, Service $service)
    {
        Gate::authorize('update', $service);

        $service->update(
            $request->validate($this->rules())
        );

        return response()->json([
            'success' => true,
            'data' => $service
        ]);
    }

    public function deactivate(Service $service)
    {
        Gate::authorize('update', $service);

        $service->update([
            'status' => 'inactive'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Service deactivated',
        ]);
    }
}