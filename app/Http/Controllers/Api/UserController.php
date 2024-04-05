<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{

	public function __construct(
		protected User $repository
	)
	{
		
	}

	public function index()
	{
		$users = $this->repository->all();
		return UserResource::collection($users);
	}

	public function store(StoreUpdateUserRequest $request)
	{
		// GETTING ONLY VALIDATED FIELDS FROM REQUEST
		$data = $request->validated();
		// 
		/**
		 * Encrypting the user password. 
		 * UNECESSARY AT LEAST FROM LARAVEL 10.X
		 * WHEN THE DATA IS TO BE ENTERED, THE LARAVEL MODEL USER, WITH THE cast, ENCRYPT THE PASS
		 * $data['password'] = bcrypt($request->password);
		 */

		$user = $this->repository->create($data);

		return new UserResource($user);
	}


	public function show(String $id)
	{
		/**
		 * HAVE SOME WAYS TO CREATE THIS RESOURCE
		 * $user = $this->repository->find($id) -> THAT WAY SEARCH IF HAVE SOME USER WITH THIS ID
		 * $user = $this->repository->where('id', '=', $id) -> USING QUERY TO SEARCH THE USER, BY ID EQUALITY
		 * 
		 * WHEN USED ABOVE WAYS MENCIONED, WE HAVE TO VERIFY IF NULL WAS RETURN, THEN WE RETURN A RESPONSE JSON WITH 404 NOT FOUND
		 * if (!$user) {
		 *      return response()->json(['message'=> 'user not found'], 404);
		 * }
		 */


		$user = $this->repository->findOrFail($id);

		return new UserResource($user);
	}

	public function update(StoreUpdateUserRequest $request, String $id)
	{
		$data = $request->validated();
		
		$user = $this->repository->findOrFail($id);
		$user->update($data);

		return new UserResource($user);
	}


	public function destroy(String $id): JsonResponse
	{
		$this->repository->findOrFail($id)->delete();

		return response()->json([], Response::HTTP_NO_CONTENT);
	}
}
