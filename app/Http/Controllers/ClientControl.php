<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ClientControl extends Controller
{
    public function getAllUser($page)
    {
        $response = Http::withToken(config('services.rest.token'))
            ->get('https://gorest.co.in/public/v2/users');
        $response->json();

        //$data = json_decode($response->getBody()); // returns an object
        $data = json_decode($response->getBody(), true); // returns an array

        $page = !empty($page) ? (int) $page : 1;
        $total = count($data); //total items in array  
        $limit = 4;
        $totalPages = ceil($total / $limit); //calculate total pages
        $page = max($page, 1); //get 1 page when $page <= 0
        $page = min($page, $totalPages); //get last page when $page > $totalPages
        $offset = ($page - 1) * $limit;
        if ($offset < 0) $offset = 0;
        $dataArray = array_slice($data, $offset, $limit);

        return view('userList', ['data' => $dataArray, 'page' => $page, 'totalPages' => $totalPages]);
    }

    public function adduser(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:filter', 'max:255'],
            'gender' => ['required'],
            'status' => ['required'],
        ]);

        if ($validation->fails()) {
            return response()->json(['code' => 400, 'msg' => $validation->errors()->first()]);
        } else {
            $response = Http::withToken(config('services.rest.token'))
                ->post('https://gorest.co.in/public/v2/users/', [
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'gender' => $request->input('gender'),
                    'status' => $request->input('status'),
                ]);
            $response->json();
            if ($response->successful() == 'true') {
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'fail', 'restmsg' => $response->getStatusCode()]);
            }
        }
    }

    public function edituser(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:filter', 'max:255'],
            'gender' => 'required',
            'status' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['code' => 400, 'msg' => $validation->errors()->first()]);
        } else {
            $id = $request->input('id');
            $response = Http::withToken(config('services.rest.token'))
                ->put('https://gorest.co.in/public/v2/users/' . $id, [ //edit todo
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'gender' => $request->input('gender'),
                    'status' => $request->input('status'),
                ]);
            $response->json();
            if ($response->successful() == 'true') {
                return response()->json(['code' => 200, 'status' => 'Sucessfully Updated']);
            } else {
                return response()->json(['status' => 'fail', 'restmsg' => $response->getStatusCode()]);
            }
        }
    }

    public function getUserProfile($id)
    {
        $userResponse = Http::withToken(config('services.rest.token')) //get user info
            ->get('https://gorest.co.in/public/v2/users/' . $id);
        $userResponse->json();
        $user = json_decode($userResponse->getBody(), true); // returns an array

        $postsResponse = Http::withToken(config('services.rest.token')) //get user posts
            ->get('https://gorest.co.in/public/v2/users/' . $id . '/posts');
        $postsResponse->json();
        $post = json_decode($postsResponse->getBody(), true); // returns an array
        $totalPost = count($post);

        $todosResponse = Http::withToken(config('services.rest.token')) //get user posts
            ->get('https://gorest.co.in/public/v2/users/' . $id . '/todos');
        $todosResponse->json();
        $todo = json_decode($todosResponse->getBody(), true); // returns an array
        $totalTodo = count($todo);

        return view('userProfile', ['user' => $user, 'post' => $post, 'totalPost' => $totalPost, 'todo' => $todo, 'totalTodo' => $totalTodo,]);
    }

    public function addpost(Request $request)
    {
        $id = $request->input('user_id');
        $validation = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:500'],
        ]);

        if ($validation->fails()) {
            return response()->json(['code' => 400, 'msg' => $validation->errors()->first()]);
        } else {
            $response = Http::withToken(config('services.rest.token'))
                ->post('https://gorest.co.in/public/v2/users/' . $id . '/posts', [ //add post for specific user
                    'user_id' => $request->input('user_id'),
                    'title' => $request->input('title'),
                    'body' => $request->input('body'),
                ]);
            $response->json();
            if ($response->successful() == 'true') {
                return response()->json(['code' => 200, 'status' => 'Sucessfully Added']);
            } else {
                return response()->json(['status' => 'fail', 'restmsg' => $response->getStatusCode()]);
            }
        }
    }

    public function editpost(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:500'],
        ]);

        if ($validation->fails()) {
            return response()->json(['code' => 400, 'msg' => $validation->errors()->first()]);
        } else {
            $id = $request->input('id');
            $response = Http::withToken(config('services.rest.token'))
                ->put('https://gorest.co.in/public/v2/posts/' . $id, [ //edit todo
                    'title' => $request->input('title'),
                    'body' => $request->input('body'),
                ]);
            $response->json();
            if ($response->successful() == 'true') {
                return response()->json(['code' => 200, 'status' => 'Sucessfully Updated']);
            } else {
                return response()->json(['status' => 'fail', 'restmsg' => $response->getStatusCode()]);
            }
        }
    }

    public function addtodo(Request $request)
    {
        $id = $request->input('user_id');
        $validation = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:100'],
            'due_on' => 'required',
            'status' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['code' => 400, 'msg' => $validation->errors()->first()]);
        } else {
            $response = Http::withToken(config('services.rest.token'))
                ->post('https://gorest.co.in/public/v2/users/' . $id . '/todos', [ //add todos for specific user
                    'user_id' => $request->input('user_id'),
                    'title' => $request->input('title'),
                    'due_on' => $request->input('due_on'),
                    'status' => $request->input('status'),
                ]);
            $response->json();
            if ($response->successful() == 'true') {
                return response()->json(['code' => 200, 'status' => 'Sucessfully Added']);
            } else {
                return response()->json(['status' => 'fail', 'restmsg' => $response->getStatusCode()]);
            }
        }
    }

    public function edittodo(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'due_on' => 'required',
            'status' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['code' => 400, 'msg' => $validation->errors()->first()]);
        } else {
            $id = $request->input('id');
            $response = Http::withToken(config('services.rest.token'))
                ->put('https://gorest.co.in/public/v2/todos/' . $id, [ //edit todo
                    'title' => $request->input('title'),
                    'due_on' => $request->input('due_on'),
                    'status' => $request->input('status'),
                ]);
            $response->json();
            if ($response->successful() == 'true') {
                return response()->json(['code' => 200, 'status' => 'Sucessfully Updated']);
            } else {
                return response()->json(['status' => 'fail', 'restmsg' => $response->getStatusCode()]);
            }
        }
    }

    public function deletetodo(Request $request)
    {
        $id = $request->input('id');
        $response = Http::withToken(config('services.rest.token'))
            ->delete('https://gorest.co.in/public/v2/todos/' . $id);
        $response->json();
        if ($response->successful() == 'true') {
            return response()->json(['code' => 200, 'status' => 'Successfully Deleted']);
        } else {
            return response()->json(['status' => 'fail', 'restmsg' => $response->getStatusCode()]);
        }
    }
}
