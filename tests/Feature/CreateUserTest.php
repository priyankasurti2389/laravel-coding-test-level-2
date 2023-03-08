<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;

class ACNProjectTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function test_for_create_user()
    {
 
        $payload = [
            "username" => "gia4",
            "password" => "asdf1234",
            "role_id"  => "42e2db4b-bd14-11ed-8bf9-a81e848802d0"
        ];
 
        $response = $this->postJson('api/users', $payload);

        $response
        ->assertStatus(200)
        ->assertJson([
                'success' => true,
            ]);
    }

    public function test_for_create_project()
    {
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiNjFlYWE1NTdlOTg4YzEzODYxOWUzMDczMmNjMmU0OGYzMzhlY2Q2MGI5NWYwNzA5NDUwZmVlMTg5YzJkNjgyMGNhZjE4N2I5MDg3MjU0MTUiLCJpYXQiOjE2NzgyMTMwODEuODY3NjYzLCJuYmYiOjE2NzgyMTMwODEuODY3NjY1LCJleHAiOjE3MDk4MzU0ODEuODQzMjk1LCJzdWIiOiJlMjQ5MDdlMy1jYjA3LTQ2ODktYmY5Yy1jNjNlYWNhYjc4ZjAiLCJzY29wZXMiOltdfQ.lZn9HwN1UXtdx8vT9OqOB6gh9GUWfVXgedCNmweISh4905EJNCr18GoTQio-DPIZXko9NwIPyvrfIB2lp8_YsQYe1NKN80HvgSmsAIEkwgECMff9GpPvdCcegf4sc_UozGpB1ViYDT3dQ0EErLDVpSEZrYPQqsbecmBRuIMlbq0mqx9NK97cm4_iPhNgicwBqb_B0eQE0vBGIXbdqNXhQCBhuRu_yt2XlavkUQaWQPuxK4yPUiSb5Ope9rNVg4gSY8EakT8IUVzySm2aRWjsprgbdy-LlmUX4DZg0hOsjxd9N8McxxxFf9T4jwu6d2dKrFDKky6Af8JkvnE6cekTpOi5H579-Ab7NleGswrZvv-3I8FCjot7ABpZTwdhCDQ3eATxm5sildUURtXF5Z5HbB-sFVTigAyuCoq2HbbhVXdctX4stCkUbP79gYdSN7AbKZ5GK8OWP3TqrjBs0ed7Wen-Wog7Ha8LT1UOtZ40tcasD-4axQi4FIo4gEfAQ6qoSoPw3dUvGMd58lTcUaLatQ2SBLzPuttZ2AOj4hNfbruXlfbVvkJ7EIi3wS5kgS-stCtINJAOErH1tGyLe50DW7IAuPz5l5kpx-Qzf_6adod0leXkWs0JhvubbeIIwvstLvDFQnEsQ315vDLF6wOkmjOHWZUlx9AsDVayNQPyU3s";
 
        $payload1 = [
            "name"=>"ACN Project6",
            "id"=> Str::uuid()
        ];
 
        $project = Project::create($payload1);

        $payload2 = [
            "project_id"=>$project->id,
            "user_id"=>["d21fc236-84de-459a-88d3-702608231b97","c6ca1cf2-6a19-4102-82d7-74e3e1181939"]
        ];
        $headers = ['Authorization' => "Bearer $token"];

        $responseProject = $this->postJson('api/projects/assign', $payload2,$headers);

        $responseProject
        ->assertStatus(200)
        ->assertJson([
                'success' => true,
            ]);
    }

    public function test_for_update_task_status()
    {
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIyIiwianRpIjoiNjFlYWE1NTdlOTg4YzEzODYxOWUzMDczMmNjMmU0OGYzMzhlY2Q2MGI5NWYwNzA5NDUwZmVlMTg5YzJkNjgyMGNhZjE4N2I5MDg3MjU0MTUiLCJpYXQiOjE2NzgyMTMwODEuODY3NjYzLCJuYmYiOjE2NzgyMTMwODEuODY3NjY1LCJleHAiOjE3MDk4MzU0ODEuODQzMjk1LCJzdWIiOiJlMjQ5MDdlMy1jYjA3LTQ2ODktYmY5Yy1jNjNlYWNhYjc4ZjAiLCJzY29wZXMiOltdfQ.lZn9HwN1UXtdx8vT9OqOB6gh9GUWfVXgedCNmweISh4905EJNCr18GoTQio-DPIZXko9NwIPyvrfIB2lp8_YsQYe1NKN80HvgSmsAIEkwgECMff9GpPvdCcegf4sc_UozGpB1ViYDT3dQ0EErLDVpSEZrYPQqsbecmBRuIMlbq0mqx9NK97cm4_iPhNgicwBqb_B0eQE0vBGIXbdqNXhQCBhuRu_yt2XlavkUQaWQPuxK4yPUiSb5Ope9rNVg4gSY8EakT8IUVzySm2aRWjsprgbdy-LlmUX4DZg0hOsjxd9N8McxxxFf9T4jwu6d2dKrFDKky6Af8JkvnE6cekTpOi5H579-Ab7NleGswrZvv-3I8FCjot7ABpZTwdhCDQ3eATxm5sildUURtXF5Z5HbB-sFVTigAyuCoq2HbbhVXdctX4stCkUbP79gYdSN7AbKZ5GK8OWP3TqrjBs0ed7Wen-Wog7Ha8LT1UOtZ40tcasD-4axQi4FIo4gEfAQ6qoSoPw3dUvGMd58lTcUaLatQ2SBLzPuttZ2AOj4hNfbruXlfbVvkJ7EIi3wS5kgS-stCtINJAOErH1tGyLe50DW7IAuPz5l5kpx-Qzf_6adod0leXkWs0JhvubbeIIwvstLvDFQnEsQ315vDLF6wOkmjOHWZUlx9AsDVayNQPyU3s";
 
        $payload = [
            "task_id"=> "271012cf-1d9e-4d31-b0f9-ffbd85ad7190",
            "status"=> "IN_PROGRESS",
            "user_id"=>"40753cfd-831b-401a-a249-fc92f11d713b"
        ];
        $headers = ['Authorization' => "Bearer $token"];

        $responseProject = $this->postJson('api/tasks/status/update', $payload,$headers);

        $responseProject
        ->assertStatus(200)
        ->assertJson([
                'success' => true,
            ]);
    }
}
