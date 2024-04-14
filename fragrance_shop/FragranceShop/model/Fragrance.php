<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of fragrance
 *
 * @var int £id The auto incremented identifier
 * @var string $name The name of the fragrance
 * @var Brand brand A Brand object representing the manufacturer of the fragrance
 * @var string $gender A constant value defined in the Gender class. 
 *                     Represents the intended target audience of the fragrance.
 * @var array $categories An array of Category constants. The Category class is a
 *                        collection of constant values that represent the olfactory 
 *                        groups of that fragrances can belong to.
 * @var array $price_sizes An array of PriceSize objects that represent the 
 *                         volumes  and corresponding prices in which the 
 *                         fragrance is available 
 * @var string $description The verbal description of the composition of the fragrance.
 * @var string $img_src The path of the image of the fragrance
 * 
 * @author igbin
 * 
 * 
 * 
 */
class Fragrance {

    private int $id;
    private string $name;
    private Brand $brand;
    private string $gender;
    private string $description;
    private string $img_src;
    private array $categories;
    private array $price_sizes;

    /**
     * 
     * @param int $id
     * @param string $name
     * @param Brand $brand The brand of the fragrance
     * @param string $gender A constant of the Gender class
     * @param string $description
     * @param string $img_src The path to the fragrance image
     * @param array $categories An array of string  constants from the Category class
     * @param array $price_sizes An array of string constants from the Size class
     */
    public function __construct(int $id, string $name, Brand $brand, string $gender,
            string $description, string $img_src, array $categories,
            array $price_sizes) {
        $this->id = $id;
        $this->name = $name;
        $this->brand = $brand;
        $this->gender = $gender;
        $this->description = $description;
        $this->img_src = $img_src;
        $this->categories = $categories;
        $this->price_sizes = $price_sizes;
    }

    public function get_id(): int {
        return $this->id;
    }

    public function get_name(): string {
        return $this->name;
    }

    public function get_brand(): Brand {
        return $this->brand;
    }

    public function get_gender(): string {
        return $this->gender;
    }

    public function get_description(): string {
        return $this->description;
    }

    public function get_img_src(): string {
        return $this->img_src;
    }

    public function get_categories(): array {
        return $this->categories;
    }

    public function get_price_sizes(): array {
        return $this->price_sizes;
    }

    public function set_id(int $id): void {
        $this->id = $id;
    }

    public function set_name(string $name): void {
        $this->name = $name;
    }

    public function set_brand(Brand $brand): void {
        $this->brand = $brand;
    }

    public function set_gender(string $gender): void {
        $this->gender = $gender;
    }

    public function set_description(string $description): void {
        $this->description = $description;
    }

    public function set_img_scr(string $img_src): void {
        $this->img_src = $img_src;
    }

    public function set_categories(array $categories): void {
        $this->categories = $categories;
    }

    public function set_price_sizes(array $price_sizes): void {
        $this->price_sizes = $price_sizes;
    }
}
