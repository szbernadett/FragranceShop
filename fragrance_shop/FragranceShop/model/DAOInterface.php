<?php


/**
 *
 * @author igbin
 */
interface DAOInterface {
    public function get_fragrance_by_id(int $frag_id);
    public function get_all_fragrances();
    public function edit_fragrance($frag_id);
    public function delete_fragrance($frag_id);
    
    public function get_member(string $username);
    public function get_all_brands();
    public function get_all_categories();
    public function get_all_genders();
    public function get_all_price_sizes();
    public function get_all_sizes();
}
