<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Tampilkan halaman notifikasi in-app pengguna.
     */
    public function index()
    {
        $user = Auth::user();

        $notifikasis = Notifikasi::where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        $unreadCount = Notifikasi::where('user_id', $user->id)
            ->whereNull('dibaca_at')
            ->count();

        return view('notifications.index', compact('notifikasis', 'unreadCount'));
    }

    /**
     * Tandai sebuah notifikasi telah dibaca.
     */
    public function markAsRead(Notifikasi $notifikasi)
    {
        if ($notifikasi->user_id === Auth::id() && ! $notifikasi->dibaca_at) {
            $notifikasi->update(['dibaca_at' => now()]);
        }

        if ($notifikasi->link) {
            return redirect($notifikasi->link);
        }

        return back()->with('success', 'Notifikasi ditandai telah dibaca.');
    }

    /**
     * Tandai semua notifikasi telah dibaca.
     */
    public function markAllAsRead()
    {
        Notifikasi::where('user_id', Auth::id())
            ->whereNull('dibaca_at')
            ->update(['dibaca_at' => now()]);

        return back()->with('success', 'Semua notifikasi ditandai telah dibaca.');
    }
}
