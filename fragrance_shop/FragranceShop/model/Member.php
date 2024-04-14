<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * The Member class represents a registered member of the Fragrance Shop.
 *  @var int $id Auto incremented identifier
 * @var string $username A chosen nick name or real name
 * @var string $email Email address
 * @var string $password Encrypted password
 */
class Member {
    
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    
    public function __construct(int $id, string $username, string $email, string $password) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }
    
    public function get_id(): int {
        return $this->id;
    }

    public function get_username(): string {
        return $this->username;
    }

    public function get_email(): string {
        return $this->email;
    }

    public function get_password(): string {
        return $this->password;
    }

    public function set_id(int $id): void {
        $this->id = $id;
    }

    public function set_username(string $username): void {
        $this->username = $username;
    }

    public function set_email(string $email): void {
        $this->email = $email;
    }

    public function set_password(string $password): void {
        $this->password = $password;
    }



    
}
