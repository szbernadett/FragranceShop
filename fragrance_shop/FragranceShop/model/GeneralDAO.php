<?php

require_once 'pdo.php';
require_once 'Fragrance.php';
require_once 'Member.php';
require_once 'Size.php';
require_once 'Gender.php';
require_once 'Category.php';
require_once 'PriceSize.php';
require_once 'Brand.php';
require_once 'DAOInterface.php';

/**
 * 
 */
class GeneralDAO implements DAOInterface {

    private PDO $db;
    private array $brands;
    private array $genders;
    private array $categories;
    private array $sizes;
    private array $price_sizes;
    private array $fragrances;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
        try{
        $this->brands = $this->get_all_brands();
        $this->genders = $this->get_all_genders();
        $this->categories = $this->get_all_categories();
        $this->sizes = $this->get_all_sizes();
        $this->price_sizes = $this->get_all_price_sizes();
        $this->fragrances = $this->get_all_fragrances();
        } catch (PDOException $e){
            throw $e;
        }
    }
    
    public function get_brands(): array {
        return $this->brands;
    }

    public function get_genders(): array {
        return $this->genders;
    }

    public function get_categories(): array {
        return $this->categories;
    }

    public function get_sizes(): array {
        return $this->sizes;
    }

    public function get_price_sizes(): array {
        return $this->price_sizes;
    }

    public function get_fragrances(): array {
        return $this->fragrances;
    }

    public function set_brands(array $brands): void {
        $this->brands = $brands;
    }

    public function set_genders(array $genders): void {
        $this->genders = $genders;
    }

    public function set_categories(array $categories): void {
        $this->categories = $categories;
    }

    public function set_sizes(array $sizes): void {
        $this->sizes = $sizes;
    }

    public function set_price_sizes(array $price_sizes): void {
        $this->price_sizes = $price_sizes;
    }

    public function set_fragrances(array $fragrances): void {
        $this->fragrances = $fragrances;
    }

    
    public function get_db(): PDO {
        return $this->db;
    }

    public function set_db(PDO $db): void {
        $this->db = $db;
    }

    public function get_fragrance_by_id(int $frag_id): Fragrance {
        $fragrance = null;

        try {
            $stmt = $this->db->prepare("SELECT * FROM fragrance WHERE id= :id");
            $stmt->execute(array("id" => $frag_id));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $fragrance = new Fragrance(
                        $row["id"],
                        $row["name"],
                        this->brands[$row['brand_id']],
                        this->genders[$row['gender_id']],
                        $row["description"],
                        $row["img_src"],
                        $this->get_frag_categories($row["id"]),
                        $this->get_frag_price_sizes($row["id"])
                );
            }
        } catch (PDOException $e) {
            throw $e;
        } finally {
            return $fragrance;
        }
    }

    public function delete_fragrance($frag_id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM fragrance WHERE id= :id");
            $stmt->execute(array(":id" => $frag_id));
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function edit_fragrance($frag_id) {
        
    }

    public function get_all_brands(): array {
        $brands = [];

        try {
            $stmt = $this->db->query("SELECT * FROM brand");
            $rows = $stmt->fetchAll(PDO::FETCH_NUM);
            foreach ($rows as $row) {
                $brand = new Brand(...$row);
                $brands[$brand->get_id()] = $brand;
            }
        } catch (PDOException $e) {
            throw $e;
        } finally {
            return $brands;
        }
    }

    public function get_all_categories(): array {
        $categories = [];

        try {
            $stmt = $this->db->query("SELECT * FROM category");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows) {
                foreach ($rows as $row) {
                    $categories[row["id"]] = $row["category_name"];
                }
            }
        } catch (PDOException $e) {
            throw $e;
        } finally {
            return $categories;
        }
    }

    public function get_all_fragrances(): array {
        $fragrances = [];
        try {
            $stmt = $this->db->query("SELECT * FROM fragrance;");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows) {
                foreach ($rows as $row) {
                    $fragrance = new Fragrance(
                            $row["id"],
                            $row["name"],
                            $this->get_brands()[$row['brand_id']],
                            $this->get_genders()[$row['gender_id']],
                            $row["description"],
                            $row["img_src"],
                            $this->get_frag_categories($row["id"]),
                            $this->get_frag_price_sizes($row["id"])
                    );
                    $fragrances[] = $fragrance;
                }
            }
        } catch (PDOException $e) {
            throw $e;
        } finally {
            return $fragrances;
        }
    }

    public function get_all_genders(): array {
        $genders = [];

        try {
            $stmt = $this->db->query("SELECT * FROM gender");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows) {
                foreach ($rows as $row) {
                    $genders[$row["id"]] = $row["gender_name"];
                }
            }
        } catch (PDOException $e) {
            throw $e;
        } finally {
            return $genders;
        }
    }

    public function get_all_price_sizes(): array {
        $price_sizes = [];

        try {
            $stmt = $this->db->query("SELECT * FROM price_size");
            $rows = $stmt->fetchall();
            if ($rows) {
                foreach ($rows as $row) {
                    $price_size = new PriceSize(
                            $row["id"],
                            self::sizes[$row["size_id"]],
                            $row["price_value"]
                    );
                    $price_sizes[$price_size . get_id()] = $price_size;
                }
            }
        } catch (PDOException $e) {
            throw $e;
        } finally {
            return $price_sizes;
        }
    }

    public function get_all_sizes(): array {
        $sizes = [];

        try {
            $stmt = $this->db->query("SELECT * FROM size");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($rows) {
                foreach ($rows as $row) {
                    $sizes[row["id"]] = $row["size_name"];
                }
            }
        } catch (PDOException $e) {
            throw $e;
        } finally {
            return $sizes;
        }
    }

    public function get_member(string $username): ?Member {
        $member = null;

        try {
            $stmt = $this->db->prepare("SELECT * FROM member WHERE username= :username");
            $stmt->execute(array("username" => $username));
            $row = $stmt->fetch(PDO::FETCH_NUM);

            if ($row) {
                $member = new Member(...$row);
            }
        } catch (PDOException $e) {
            throw $e;
        } finally {
            return $member;
        }
    }

    public function get_frag_categories($frag_id): array {
        $matches = [];

        try {
            $stmt = $this->db->prepare("SELECT category_id FROM fragrance_category WHERE fragrance_id = :id");
            $stmt->execute(array(":id" => $frag_id));
            $cat_ids = $stmt->fetchAll(PDO::FETCH_NUM);

            if ($cat_ids) {
                $cat_keys = array_flip(self::categories);
                $matches = array_intersect_key($cat_ids, $cat_keys);
            }
        } catch (PDOException $e) {
            throw $e;
        } finally {
            return $matches;
        }
    }

    public function get_frag_price_sizes($frag_id): array {
        $matches = [];

        try {
            $stmt = $this->db->prepare("SELECT price_size_id FROM fragrance_price_size WHERE fragrance_id = :id");
            $stmt->execute(array(":id" => $frag_id));
            $prs_ids = $stmt->fetchAll(PDO::FETCH_NUM);

            if ($prs_ids) {
                $prs_keys = array_flip(self::price_sizes);
                $matches = array_intersect_key($prs_ids, $prs_keys);
            }
        } catch (PDOException $e) {
            throw $e;
        } finally {
            return $matches;
        }
    }
}
    