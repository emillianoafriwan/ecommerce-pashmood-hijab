<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mov,avi|max:20480', // Maksimal 20MB
        ]);

        $mediaPath = null;
        $mediaType = null;

        // Jika pembeli mengupload foto/video
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mediaPath = $file->store('reviews', 'public'); // Simpan di folder storage/app/public/reviews
            
            // Cek apakah file berupa video atau gambar
            if (str_contains($file->getMimeType(), 'video')) {
                $mediaType = 'video';
            } else {
                $mediaType = 'image';
            }
        }

        Review::create([
            'user_id' => auth()->user()->id,
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}