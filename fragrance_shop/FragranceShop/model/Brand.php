<?php


/**
 * Description of Brand
 *
 * @author igbin
 * 
 * @var int $id The auto incremented identifier
 * @var string $brand_name The name of the brand
 * 
 * 
 */
class Brand {
    
    private int $id;
    private string $brand_name;
    private array $price_sizes;
    
    public function __construct(int $id, string $brand_name, array $price_sizes) {
        $this->id = $id;
        $this->brand_name = $brand_name;
        $this->price_sizes = $price_sizes;
    }

    public function get_id(): int {
        return $this->id;
    }

    public function get_brand_name(): string {
        return $this->brand_name;
    }

    public function set_id(int $id): void {
        $this->id = $id;
    }

    public function set_brand_name(string $brand_name): void {
        $this->brand_name = $brand_name;
    }

    public function get_price_sizes(): array {
        return $this->price_sizes;
    }

    public function set_price_sizes(array $price_sizes): void {
        $this->price_sizes = $price_sizes;
    }


}
