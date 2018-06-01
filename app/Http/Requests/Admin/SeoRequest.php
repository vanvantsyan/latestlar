<?php

namespace App\Http\Requests\Admin;

use App\Models\GeneratedSeo;
use Illuminate\Foundation\Http\FormRequest;

class SeoRequest extends FormRequest
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
        // Получаем URL модели, если она редактируется, а не создается
        $url = $this->route('seo') ? ',' . $this->route('seo')->url . ',url' : '';
        $url = preg_replace('~[\S]+.ru\/~i',"", $url);
        
        return [
            //
            'url' => 'required|unique:generated_seo,url' . $url,
        ];
    }
    
    public function attributes()
    {
        return [
            'url' => 'Ссылка',
        ];
    }
}
