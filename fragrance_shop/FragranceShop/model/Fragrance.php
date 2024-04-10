<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */
require_once 'Gender.php';
/**
 * Description of fragrance
 *
 * @var int £id The identifier, auto incremented value from MySQL
 * @var string $name The name of the fragrance
 * @var Gender $gender A  constant value defined in the Gender class. 
 *      Represents the intended target audience of the fragrance.
 * @var array $categories An array of Category constants. The Category class is a
 *      collection of constant values that represent the olfactory groups of
 *      that fragrances can belong to.
 * @var array $sizes An array of Size constants that represent the volumes of which
 *      the fragrance is available in
 * @var string $description The verbal description of the composition of the fragrance.
 * 
 * @author igbin
 * 
 * 
 * 
 */
class Fragrance{
   private $id;
   private $name;
   private $gender;
   private $categories;
   private $sizes;
   private $description;
   
   /**
    * 
    * @param int $id
    * @param string $name
    * @param Gender $gender A Gender constant
    * @param array $categories An array of Category constants
    * @param array $sizes An array of Size constants
    * @param string $description
    */
   
   public function __construct($id, $name, Gender $gender, array $categories, 
           array $sizes, $description) {
       $this->id = $id;
       $this->name = $name;
       $this->gender = $gender;
       $this->categories = $categories;
       $this->sizes = $sizes;
       $this->description = $description;
   }

   
   public function get_id(): int {
       return $this->id;
   }

   public function get_name(): string {
       return $this->name;
   }

   public function get_gender(): Gender {
       return $this->gender;
   }

   public function get_categories(): array {
       return $this->categories;
   }

   public function get_sizes(): array {
       return $this->sizes;
   }

   public function get_description(): string {
       return $this->description;
   }

   public function set_id($id): void {
       $this->id = $id;
   }

   public function set_name($name): void {
       $this->name = $name;
   }

   public function set_gender($gender): void {
       $this->gender = $gender;
   }

   public function set_categories($categories): void {
       $this->categories = $categories;
   }

   public function set_sizes($sizes): void {
       $this->sizes = $sizes;
   }

   public function set_description($description): void {
       $this->description = $description;
   }


}






