<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
        $employeeId = $this->route('id');

        return [
            'name' => 'sometimes|required|string|max:255',
            'phone' => [
                'sometimes',
                'nullable',
                'string',
                'max:20',
                Rule::unique('employees', 'phone')->ignore($employeeId),
            ],
            'division' => 'sometimes|required|uuid|exists:divisions,id',
            'position' => 'sometimes|required|string|max:100',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama karyawan wajib diisi',
            'name.string' => 'Nama karyawan harus berupa teks',
            'name.max' => 'Nama karyawan maksimal 255 karakter',

            'phone.string' => 'Nomor telepon harus berupa teks',
            'phone.max' => 'Nomor telepon maksimal 20 karakter',
            'phone.unique' => 'Nomor telepon sudah digunakan',

            'division.required' => 'Divisi wajib dipilih',
            'division.uuid' => 'Format divisi tidak valid',
            'division.exists' => 'Divisi tidak ditemukan',

            'position.required' => 'Posisi/jabatan wajib diisi',
            'position.string' => 'Posisi/jabatan harus berupa teks',
            'position.max' => 'Posisi/jabatan maksimal 100 karakter',

            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama karyawan',
            'phone' => 'nomor telepon',
            'division' => 'divisi',
            'position' => 'posisi/jabatan',
            'image' => 'foto karyawan',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
