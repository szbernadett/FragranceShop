<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Gender
 *
 * @author igbin
 */
class Gender{
    
    private const MEN="nmen";
    private const WOMEN="women";
    private const UNISEX="unisex";
    
    public static function getMen(): string {
        return self::MEN;
    }
    
     public static function getWomens(): string {
        return self::WOMEN;
    }
    
     public static function getUnisex(): string {
        return self::UNISEX;
    }
}
