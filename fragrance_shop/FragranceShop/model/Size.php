<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Size
 *
 * @author igbin
 */
class Size{
   private const _30="30_ml";
   private const _50="50 ml";
   private const _60="60 ml";
   private const _100="100 ml";
   private const _120="120 ml";
   
   public static function getSize30(): string{
       return self::_30;      
   }
   
    public static function getSize50(): string{
       return self::_50;      
   }
   
    public static function getSize60(): string{
       return self::_60;      
   }
   
    public static function getSize100(): string{
       return self::_100;      
   }
   
    public static function getSize120(): string{
       return self::_120;      
   }
}
