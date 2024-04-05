<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateUserRequest extends FormRequest
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
		/**
		 * RULES TO VALIDATE USER CREATE REQUEST
		 * WAS USED WITH $request->validate BEFORE
		 */
		$rules = [
			'name' => [
				'required',
				'min:3',
				'max:255'
			],
			'email' => [
				'required',
				'email',
				'max:255',
				'unique:users'
			],
			'password' => [
				'required',
				'min:6',
				'max:100',
			]
		];

		// MODIFYING THE RULES IF THE USER IS BEING UPDATED
		if ($this->method() === 'PATCH') {
			// EMAIL RULES -> ALLOWING SET SAME EMAIL HAS BEING USED BY TH CURRENT USER
			// $rules['email'][3] = "unique:users,email,{$this->id},id";
			$rules['email'][3] = Rule::unique('users')->ignore($this->id);
			
			// REMOVING THE REQUIRED FROM THE PASSWORD
			$rules['password'][0] = 'nullable';
		}

		return $rules;
	}
}
