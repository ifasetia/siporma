<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKampusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'km_nama_kampus'    => 'required|string|max:255',
            'km_kode_kampus' => [
                'required',
                'string',
                'max:20',
                Rule::unique('ms_kampus', 'km_kode_kampus')
                    ->ignore($id, 'km_id')
            ],
            'km_email_kampus'   => [
                'required',
                'email',
                Rule::unique('ms_kampus', 'km_email')
                    ->ignore($id, 'km_id')
            ],
            'km_alamat_kampus'  => 'required|string',
            'km_telepon'        => 'required|string|min:10|max:15',
        ];
    }

    public function messages(): array
    {
        return [
            'km_nama_kampus.required'   => 'Nama kampus wajib diisi',

            'km_kode_kampus.required'   => 'Kode kampus wajib diisi',
            'km_kode_kampus.unique'     => 'Kode kampus sudah terdaftar',

            'km_email_kampus.required'  => 'Email kampus wajib diisi',
            'km_email_kampus.unique'    => 'Email kampus sudah terdaftar',
            'km_email_kampus.email'     => 'Format email tidak valid',

            'km_alamat_kampus.required' => 'Alamat kampus wajib diisi',

            'km_telepon.required'       => 'Nomor telepon wajib diisi',
            'km_telepon.min'            => 'Nomor telepon minimal 10 digit',
            'km_telepon.max'            => 'Nomor telepon maksimal 15 digit',
        ];
    }
}
