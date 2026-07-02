<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Daftar semua banner.
     */
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Form tambah banner baru.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Simpan banner baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:100',
            'subtitle'   => 'nullable|string|max:200',
            'image'      => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
            'link_url'   => 'nullable|url|max:255',
            'sort_order' => 'required|integer|min:0|max:99',
            'is_active'  => 'nullable|boolean',
            'placement'  => 'required|string|in:above_recommendations,below_recommendations,below_catalog',
            'width'      => 'required|string|in:full,half',
            'height'     => 'required|string|in:small,medium,large',
        ]);

        $imagePath = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title'           => $request->title,
            'subtitle'        => $request->subtitle,
            'image_path'      => $imagePath,
            'file_size_bytes' => $request->file('image')->getSize(),
            'link_url'        => $request->link_url,
            'sort_order'      => $request->sort_order,
            'is_active'       => $request->boolean('is_active', true),
            'placement'       => $request->placement,
            'width'           => $request->width,
            'height'          => $request->height,
        ]);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil ditambahkan!');
    }

    /**
     * Form edit banner.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update banner.
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title'      => 'required|string|max:100',
            'subtitle'   => 'nullable|string|max:200',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'link_url'   => 'nullable|url|max:255',
            'sort_order' => 'required|integer|min:0|max:99',
            'is_active'  => 'nullable|boolean',
            'placement'  => 'required|string|in:above_recommendations,below_recommendations,below_catalog',
            'width'      => 'required|string|in:full,half',
            'height'     => 'required|string|in:small,medium,large',
        ]);

        $data = [
            'title'      => $request->title,
            'subtitle'   => $request->subtitle,
            'link_url'   => $request->link_url,
            'sort_order' => $request->sort_order,
            'is_active'  => $request->boolean('is_active', false),
            'placement'  => $request->placement,
            'width'      => $request->width,
            'height'     => $request->height,
        ];

        // Ganti gambar jika ada upload baru
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($banner->image_path);
            $data['image_path']      = $request->file('image')->store('banners', 'public');
            $data['file_size_bytes'] = $request->file('image')->getSize();
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil diperbarui!');
    }

    /**
     * Hapus banner beserta file gambarnya.
     */
    public function destroy(Banner $banner)
    {
        Storage::disk('public')->delete($banner->image_path);
        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil dihapus!');
    }

    /**
     * Toggle status aktif/nonaktif banner.
     */
    public function toggleActive(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Status banner berhasil diubah!');
    }

    /**
     * AJAX endpoint to crop and update banner image.
     */
    public function cropAjax(Request $request, Banner $banner)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        Storage::disk('public')->delete($banner->image_path);
        
        $imagePath = $request->file('image')->store('banners', 'public');
        $fileSize = $request->file('image')->getSize();

        $banner->update([
            'image_path'      => $imagePath,
            'file_size_bytes' => $fileSize,
        ]);

        return response()->json([
            'success'  => true,
            'imageUrl' => $banner->imageUrl(),
            'message'  => 'Banner berhasil dipotong!'
        ]);
    }
}
