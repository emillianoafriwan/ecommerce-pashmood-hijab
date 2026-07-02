<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $hasAddressInput = $this->filled('province') 
            || $this->filled('city') 
            || $this->filled('district') 
            || $this->filled('village') 
            || $this->filled('detail_address');
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:10240'],
            'province'      => [$hasAddressInput ? 'required' : 'nullable', 'string', 'max:100'],
            'province_code' => [$hasAddressInput ? 'required' : 'nullable', 'string', 'max:20'],
            'city'          => [$hasAddressInput ? 'required' : 'nullable', 'string', 'max:100'],
            'city_code'     => [$hasAddressInput ? 'required' : 'nullable', 'string', 'max:20'],
            'district'      => [$hasAddressInput ? 'required' : 'nullable', 'string', 'max:100'],
            'district_code' => [$hasAddressInput ? 'required' : 'nullable', 'string', 'max:20'],
            'village'       => [$hasAddressInput ? 'required' : 'nullable', 'string', 'max:100'],
            'village_code'  => [$hasAddressInput ? 'required' : 'nullable', 'string', 'max:20'],
            'detail_address' => [$hasAddressInput ? 'required' : 'nullable', 'string'],
            'address'        => ['nullable', 'string'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'bank_name'      => ['nullable', 'string', 'max:50'],
            'bank_account'   => ['nullable', 'string', 'max:50'],
            'bank_owner'     => ['nullable', 'string', 'max:100'],
        ];
    }

    /**
     * Get the custom error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'province.required'       => 'Provinsi wajib dipilih.',
            'province_code.required'  => 'Kode provinsi wajib ada.',
            'city.required'           => 'Kabupaten / Kota wajib dipilih.',
            'city_code.required'      => 'Kode kabupaten / kota wajib ada.',
            'district.required'       => 'Kecamatan wajib dipilih.',
            'district_code.required'  => 'Kode kecamatan wajib ada.',
            'village.required'        => 'Desa / Kelurahan wajib dipilih.',
            'village_code.required'   => 'Kode desa / kelurahan wajib ada.',
            'detail_address.required' => 'Detail alamat wajib diisi agar pesanan dapat dikirim.',
        ];
    }
}
