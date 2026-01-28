<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogInfrastrukturRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lokasi' => 'required|string|max:255',
            'insiden' => 'required|string|max:255',
            'tipe_insiden' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
            'akar_penyebab' => 'nullable|string',
            'tindak_lanjut' => 'nullable|string',
            'no_ticket' => 'nullable|string|max:100',
            'direspon_oleh' => 'required|array|min:1',
            'direspon_oleh.*' => 'string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'target_sla' => 'required|numeric|min:0|max:100',
        ];
    }

    /**
     * Get custom error messages
     */
    public function messages(): array
    {
        return [
            'lokasi.required' => 'Lokasi wajib dipilih',
            'insiden.required' => 'Insiden wajib diisi',
            'direspon_oleh.required' => 'Minimal pilih 1 responder',
            'direspon_oleh.array' => 'Format responder tidak valid',
            'direspon_oleh.min' => 'Minimal pilih 1 responder',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi',
            'waktu_mulai.date' => 'Format waktu mulai tidak valid',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi',
            'waktu_selesai.date' => 'Format waktu selesai tidak valid',
            'waktu_selesai.after' => 'Waktu selesai harus setelah waktu mulai',
            'target_sla.required' => 'Target SLA wajib diisi',
            'target_sla.numeric' => 'Target SLA harus berupa angka',
            'target_sla.min' => 'Target SLA minimal 0',
            'target_sla.max' => 'Target SLA maksimal 100',
        ];
    }
}
