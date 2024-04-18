<?php


/**
 * Description of PriceSize
 *
 * @author igbin
 * 
 * @var int $id The auto incremented identifier
 * @var Size $size A Size enum 
 * @var string $price_value The price corresponding to the size in string format('£120')
 * 
 * 
 */
class PriceSize {

    private int $id;
    private Size $size;
    private string $price_value;

    public function __construct(int $id, Size $size, string $price_value) {
        $this->id = $id;
        $this->size = $size;
        $this->price_value = $price_value;
    }

    public function get_id(): int {
        return $this->id;
    }

    public function get_size(): Size {
        return $this->size;
    }

    public function get_price_value(): string {
        return $this->price_value;
    }

    public function set_id(int $id): void {
        $this->id = $id;
    }

    public function set_size(Size $size): void {
        $this->size = $size;
    }

    public function set_price_value(string $price_value): void {
        $price = preg_replace("/[^0-9]/", $price_value, "");
        if ($price . isNumeric()) {
            if (filter_var($price, FILTER_VALIDATE_INT)) {
                $price = "£" . $price;
                $this->price_value = $price;
            }
        }
        
    }
}
