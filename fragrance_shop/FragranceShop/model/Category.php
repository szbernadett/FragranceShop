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
enum Category: string{
    
   case FLORAL="floral";
   case OUD="oud";
   case VANILLA="vanilla";
   case FRUITY="fruity";
   case AROMATIC="aromatic";
   case CITRUS="citrus";
   case AQUATIC="aquatic";
   case GOURMAND="gourmand";
   case POWDERY="powdery";
  
   
   public static function string_values($cat_array): array{
       $string_values = [];
       foreach($cat_array as $cat){
           $string_values[] = $cat->value;
       }
       
       return $string_values;
   }
}
