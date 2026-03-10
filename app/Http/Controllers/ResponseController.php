<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ResponseController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
            'message' => 'required|string|max:1000',
        ]);

        // Дополнительная валидация для гостей
        if (!Auth::check()) {
            $validator->addRules([
                'guest_name' => 'required|string|max:100',
                'guest_phone' => 'required|string|max:20',
                'guest_social' => 'nullable|string|max:255',
                'preferred_time' => 'nullable|string|max:100',
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Пожалуйста, заполните все обязательные поля',
                'errors' => $validator->errors()
            ], 422);
        }

        $post = Post::findOrFail($request->post_id);

        // Проверяем, что пользователь не отвечает на своё собственное объявление
        if (Auth::check() && $post->user_id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Вы не можете отвечать на своё собственное объявление'
            ], 403);
        }

        $responseData = [
            'post_id' => $request->post_id,
            'message' => $request->message,
            'status' => 'pending',
        ];

        if (Auth::check()) {
            $responseData['user_id'] = Auth::id();
        } else {
            $responseData['guest_name'] = $request->guest_name;
            $responseData['guest_phone'] = $request->guest_phone;
            $responseData['guest_social'] = $request->guest_social;
            $responseData['preferred_time'] = $request->preferred_time;
        }

        Response::create($responseData);

        return response()->json([
            'success' => true,
            'message' => 'Ваш отклик успешно отправлен!'
        ]);
    }
}