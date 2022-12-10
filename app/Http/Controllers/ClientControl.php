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

    public function getUserTodos($id)
    {
        $response = Http::withToken(config('services.rest.token'))
        ->get('https://gorest.co.in/public/v2/users/' . $id . '/todos');
        $response->json();

        //$data = json_decode($response->getBody()); // returns an object
        $data = json_decode($response->getBody(), true); // returns an array

        return view('userTodos', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:filter', 'max:255'],
            'gender' => 'required',
            'status' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['code' => 400, 'msg' => $validation->errors()->first()]);
        }
        else {
            $response = Http::withToken(config('services.rest.token'))
                ->post('https://gorest.co.in/public/v2/users/', [
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'gender' => $request->input('gender'),
                    'status' => $request->input('status'),
                ]);
                $response->json();
                if($response->successful()=='true'){
                    return response()->json(['status' => 'success']);
                }else{
                    return response()->json(['status' => 'fail', 'restmsg' => 'Please try again with different info']);
                }
                
                
        }
    }

    public function getUserProfile($id)
    {
        $response = Http::withToken(config('services.rest.token'))
        ->get('https://gorest.co.in/public/v2/users/' . $id);
        $response->json();

        //$data = json_decode($response->getBody()); // returns an object
        $data = json_decode($response->getBody(), true); // returns an array

        return view('userProfile', ['user' => $data]);
    }
}
