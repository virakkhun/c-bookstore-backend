<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentsController extends Controller
{
	public function register(Request $request)
	{
		$request->validate([
			'username' => 'required|string',
			'email' => 'required|string|unique:users,email|email',
			'password' => 'required|string|min:6|max:20',
		]);

		if ($request->file('image')) {
			$imageName = time() . $request->file('image')->getClientOriginalName();
			$request->image->move(public_path('images'), $imageName);
		} else {
			$imageName = '';
		}

		$data = Students::create([
			'username' => $request->input('username'),
			'email' => $request->input('email'),
			'password' => Hash::make($request->input('password'), [round('10')]),
			'department' => $request->input('department'),
			'image' => $imageName,
			'telephone' => $request->input('telephone'),
			'status' => $request->input('status')
		]);

		$res = [
			'data' => $data,
			'message' => "User created successfully",
			'status' => 1,
		];
		return response()->json($res, 200);
	}

	public function login(Request $request)
	{
		$validate = $request->validate([
			'email' => 'required|string|email',
			'password' => 'required|string|min:6|max:20'
		]);

		$stu = Students::where('email', $validate['email'])->first();
		$isCorrect = Hash::check($validate['password'], $stu['password']);

		if ($isCorrect) {
			$token = $stu->createToken('token')->plainTextToken;
			return response()->json([
				'data' => $stu,
				'status' => 1,
				'token' => $token
			], 201);
		} else {
			return response()->json([
				'message' => "The credentials you provided is not correct!",
				'status' => 0
			], 200);
		}
	}

	public function getStudentInfo($id)
	{

		$data = Students::where('id', $id)->first();
		if ($data) {
			$res = [
				'data' => [   
					"id" => $data['id'],
					"username" => $data['username'],
					"email" => $data['email'],
					"department" => $data['department'],
					"telephone" => $data['telephone'],
					"status" => $data['status'],
					"image" => $data['image'] ? url('images/'. $data['image']) : '',
					"created_at" => $data['created_at']
				],
				'status' => 1
			];

			return response()->json($res, 200);
		} else {
			return response([
				'message' => "User doesn't not existed!!",
				'status' => 0
			], 200);
		}
	}

	public function update(Request $request, $id)
	{
		if ($id) {
			$data = Students::where('id', $id)->update($request->all());

			$res = [
				'data' => $data,
				'message' => "Update user Successfully!!",
				'status' => 1,
			];
			return response()->json($res, 200);
		} else {
			return response()->json([
				'id' => '',
				'status' => 0
			], 300);
		}
	}

	public function delete($id)
	{
		$data = Students::destroy($id);
		if ($data) {
			return response()->json([
				'message' => 'You have deleted your account successfully',
				'status' => 1
			], 200);
		} else {
			return response()->json([
				'message' => 'This user does not exist',
				'status' => 1
			], 200);
		}
	}
}
