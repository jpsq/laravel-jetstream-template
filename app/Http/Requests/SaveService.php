<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use App\Actions\UpdateOrCreateService;
use App\Facades\Services as ServicesFacade;

class SaveService extends FormRequest
{
    public function rules(): array
    {
        $keys = array_keys(ServicesFacade::services());

        $serviceRules = $this->service()::rules();

        return array_merge($serviceRules, [Rule::in($keys)]);
    }

    public function handle(): void
    {
        $form = $this->service()::form();

        $value = Arr::map($form, function ($item, $key) {
            return $this->input($key);
        });

        (new UpdateOrCreateService())($this->route('service'), $value, auth()->user());
    }

    public function messages(): array
    {
        return $this->service()::messages();
    }

    protected function service()
    {
        return ServicesFacade::services($this->route('service'));
    }
}
