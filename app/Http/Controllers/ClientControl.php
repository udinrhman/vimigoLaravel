<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClientControl extends Controller
{
    public function getAllUser($page)
    {
        $response = Http::get('https://gorest.co.in/public/v2/users');
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
        if( $offset < 0 ) $offset = 0;
        $dataArray = array_slice( $data, $offset, $limit );

        return view('userList', ['data' => $dataArray, 'page' => $page, 'totalPages' => $totalPages]);
    }

    public function getUserTodos($id)
    {
        $response = Http::get('https://gorest.co.in/public/v2/users/' . $id . '/todos');
        $response->json();

        //$data = json_decode($response->getBody()); // returns an object
        $data = json_decode($response->getBody(), true); // returns an array

        return view('userTodos', ['data' => $data]);
    }
}
