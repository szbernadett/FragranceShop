<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Category
 *
 * @author igbin
 */
class Category{
    
   private const FLORAL="floral";
   private const OUD="oud";
   private const VANILLA="vanilla";
   private const FRUITY="fruity";
   private const AROMATIC="aromatic";
   private const CITRUS="citrus";
   private const AQUATIC="aquatic";
   private const GOURMAND="gourmand";
   private const POWDERY="powdery";
   
   public static function getFloral(): string{
       return self::FLORAL;
   }
   
     public static function getOud(): string{
       return self::OUD;
   }
   
     public static function getVanilla(): string{
       return self::VANILLA;
   }
   
     public static function getFruity(): string{
       return self::FRUITY;
   }
   
     public static function getAromatic(): string{
       return self::AROMATIC;
   }
   
     public static function getCitrus(): string{
       return self::CITRUS;
   }
   
     public static function getAquatic(): string{
       return self::AQUATIC;
   }
   
     public static function getGourmand(): string{
       return self::GOURMAND;
   }
   
     public static function getPowdery(): string{
       return self::POWDERY;
   }
}
