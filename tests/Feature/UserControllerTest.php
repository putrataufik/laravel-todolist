<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginPage()
    {
        $this->get('login')->assertSeeText("Login");
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "putra",
            "password" => "rahasia",
        ])->assertRedirect("/")->assertSessionHas("user", "putra");
    }

    public function testLoginValidationError()
    {
        $this->post("/login", [])->assertSeeText("User or password is required");
    }
    public function testLoginFailed()
    {
        $this->post("/login", [
            "user" => "Opik",
            "password" => "rahasya"
        ])->assertSeeText("User or password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            "user" => "putra"
        ])->post("/logout")
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }

    public function testLogoutGuest(){
        $this->post('logout')->assertRedirect("/");
    }

    public function testLoginPageForMember(){
        $this->withSession([
            "user" => "putra"
        ])->get("login")->assertRedirect("/");
    }

    public function testLoginForUserAlredyLogin(){
        $this->withSession([
            "user" => "putra"
        ])->post("/login", [
            "user" => "Opik",
            "password" => "rahasia"
        ])->assertRedirect("/");
    }
}
