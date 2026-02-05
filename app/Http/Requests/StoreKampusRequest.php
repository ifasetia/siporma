<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKampusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_kampus' => 'required|string|max:255',
            'kode_kampus' => 'required|string|max:20|unique:kampus,kode_kampus',
            'email'       => 'required|email|unique:kampus,email',
            'alamat'      => 'required|string',
            'telepon'     => 'required|string|min:10|max:15',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kampus.required' => 'Nama kampus wajib diisi',
            'kode_kampus.required' => 'Kode kampus wajib diisi',
            'kode_kampus.unique'   => 'Kode kampus sudah terdaftar',
            'email.required'       => 'Email kampus wajib diisi',
            'email.unique'         => 'Email kampus sudah terdaftar',
            'telepon.min'          => 'Nomor telepon minimal 10 digit',
        ];
    }
}
