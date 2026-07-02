<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    /**
     * Store a new bank account for the admin.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bank_name'    => ['required', 'string', 'max:50'],
            'bank_account' => ['required', 'string', 'max:50'],
            'bank_owner'   => ['required', 'string', 'max:100'],
        ]);

        $user = Auth::user();

        // Hitung sort_order berdasarkan jumlah rekening yang sudah ada
        $sortOrder = BankAccount::where('user_id', $user->id)->count();

        BankAccount::create([
            'user_id'      => $user->id,
            'bank_name'    => $validated['bank_name'],
            'bank_account' => $validated['bank_account'],
            'bank_owner'   => $validated['bank_owner'],
            'is_active'    => true,
            'sort_order'   => $sortOrder,
        ]);

        return redirect()->route('profile.edit')
            ->with('status', 'bank-added')
            ->withFragment('bank-section');
    }

    /**
     * Delete a bank account.
     */
    public function destroy(BankAccount $bankAccount): RedirectResponse
    {
        // Pastikan hanya pemilik yang bisa hapus
        if ($bankAccount->user_id !== Auth::id()) {
            abort(403);
        }

        $bankAccount->delete();

        return redirect()->route('profile.edit')
            ->with('status', 'bank-deleted')
            ->withFragment('bank-section');
    }

    /**
     * Toggle active status of a bank account.
     */
    public function toggle(BankAccount $bankAccount): RedirectResponse
    {
        if ($bankAccount->user_id !== Auth::id()) {
            abort(403);
        }

        $bankAccount->update(['is_active' => !$bankAccount->is_active]);

        return redirect()->route('profile.edit')
            ->with('status', 'bank-updated')
            ->withFragment('bank-section');
    }
}
