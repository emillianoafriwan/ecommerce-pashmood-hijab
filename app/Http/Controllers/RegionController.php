<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RegionController extends Controller
{
    private const API = 'https://emsifa.github.io/api-wilayah-indonesia/api';

    /**
     * Ambil dan cache data dari emsifa API
     */
    private function fetchCached(string $key, string $url): JsonResponse
    {
        // Coba ambil dari cache terlebih dahulu
        $data = Cache::get($key);

        if ($data === null) {
            try {
                $response = Http::timeout(10)->get($url);
                if ($response->successful()) {
                    $data = $response->json();
                    // Simpan di cache selama 30 hari karena data wilayah sangat jarang berubah
                    Cache::put($key, $data, now()->addMonth());
                }
            } catch (\Exception $e) {
                // Tangani error koneksi secara diam-diam agar tidak merusak response
            }

            // Jika gagal mendapatkan data baru dan cache kosong, return array kosong
            if ($data === null) {
                $data = [];
            }
        }

        return response()->json($data);
    }

    /** GET /api/wilayah/provinsi */
    public function provinces(): JsonResponse
    {
        return $this->fetchCached('wilayah_provinces', self::API . '/provinces.json');
    }

    /** GET /api/wilayah/kota/{provinceId} */
    public function cities(string $provinceId): JsonResponse
    {
        return $this->fetchCached(
            "wilayah_cities_{$provinceId}",
            self::API . "/regencies/{$provinceId}.json"
        );
    }

    /** GET /api/wilayah/kecamatan/{cityId} */
    public function districts(string $cityId): JsonResponse
    {
        return $this->fetchCached(
            "wilayah_districts_{$cityId}",
            self::API . "/districts/{$cityId}.json"
        );
    }

    /** GET /api/wilayah/desa/{districtId} */
    public function villages(string $districtId): JsonResponse
    {
        return $this->fetchCached(
            "wilayah_villages_{$districtId}",
            self::API . "/villages/{$districtId}.json"
        );
    }
}
