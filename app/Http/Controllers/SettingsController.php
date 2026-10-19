<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Show store and account settings.
     */
    public function index(): View
    {
        $user = Auth::user();
        $store = $user->stores()->firstOrFail();

        return view('settings.index', [
            'user' => $user,
            'store' => $store,
        ]);
    }

    /**
     * Update store settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $store = $user->stores()->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'timezone' => ['required', 'string', 'max:50'],
        ]);

        $store->update($validated);

        return back()->with('success', 'Store settings updated successfully.');
    }

    /**
     * Rotate store webhook secret.
     */
    public function regenerateSecret(): RedirectResponse
    {
        $user = Auth::user();
        $store = $user->stores()->firstOrFail();

        $store->update([
            'webhook_secret' => 'rp_sec_'.Str::random(24),
        ]);

        return back()->with('success', 'New webhook signing secret generated.');
    }
}
