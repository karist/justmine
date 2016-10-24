<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TablePropertiesRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'tabel_nomor' => 'required|min:5|max:100',
          'tabel_judul' => 'required|max:250',
          'tabel_title' => 'required|max:250',
          'tabel_sumber' => 'required|max:250',
          'tabel_source' => 'max:500',
          'tabel_catatan' => 'max:500',
          'tabel_note' => 'max:500',
        ];
    }
}
