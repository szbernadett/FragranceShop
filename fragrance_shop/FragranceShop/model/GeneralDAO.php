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
    private array $brands_by_id;
    private array $brands_by_name;
    private array $genders_by_id;
    private array $genders_by_value;
    private array $categories_by_id;
    private array $categories_by_value;
    private array $sizes_by_id;
    private array $sizes_by_value;
    private array $price_sizes;
    private array $fragrances;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
        try {
            $this->brands_by_id = $this->get_all_brands();
            $this->set_brands_by_name($this->brands_by_id);
            $this->genders_by_id = $this->get_all_genders();
            $this->set_genders_by_value($this->genders_by_id);
            $this->categories_by_id = $this->get_all_categories();
            $this->set_categories_by_value($this->categories_by_id);
            $this->sizes_by_id = $this->get_all_sizes();
            $this->set_sizes_by_value($this->sizes_by_id);
            $this->price_sizes = $this->get_all_price_sizes();
            $this->fragrances = $this->get_all_fragrances();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function get_brands_by_id(): array {
        return $this->brands_by_id;
    }

    public function get_brands_by_name(): array {
        return $this->brands_by_name;
    }

    public function get_genders_by_id(): array {
        return $this->genders_by_id;
    }

    public function get_genders_by_value(): array {
        return $this->genders_by_value;
    }

    public function get_categories_by_id(): array {
        return $this->categories_by_id;
    }

    public function get_categories_by_value(): array {
        return $this->categories_by_value;
    }

    public function get_sizes_by_id(): array {
        return $this->sizes_by_id;
    }

    public function get_sizes_by_value(): array {
        return $this->sizes_by_value;
    }

    public function get_price_sizes(): array {
        return $this->price_sizes;
    }

    public function get_fragrances(): array {
        return $this->fragrances;
    }

    public function set_brands_by_id(array $brands_by_id): void {
        $this->brands_by_id = $brands_by_id;
    }

    public function set_brands_by_name(array $brands_by_id): void {
        $this->brands_by_name = [];
        foreach ($brands_by_id as $id => $brand) {
            $this->brands_by_name[$brand->get_brand_name()] = $brand;
        }
    }

    public function set_genders_by_id(array $genders_by_id): void {
        $this->genders_by_id = $genders_by_id;
    }

    public function set_genders_by_value(array $genders_by_id): void {
        $this->genders_by_value = [];
        foreach ($genders_by_id as $id => $gender) {
            $this->genders_by_value[$gender->value] = $gender;
        }
    }

    public function set_categories_by_id(array $categories_by_id): void {
        $this->categories_by_id = $categories_by_id;
    }

    public function set_categories_by_value(array $categories_by_id): void {
        $this->categories_by_value = [];
        foreach ($categories_by_id as $id => $cat) {
            $this->categories_by_value[$cat->value] = $cat;
        }
    }

    public function set_sizes_by_id(array $sizes_by_id): void {
        $this->sizes_by_id = $sizes_by_id;
    }

    public function set_sizes_by_value(array $sizes_by_id): void {
        $this->sizes_by_value = [];
        foreach ($sizes_by_id as $id => $size) {
            $this->sizes_by_value[$size->value] = $size;
        }
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

    public function delete_fragrance(int $frag_id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM fragrance WHERE id= :id");
            $stmt->execute(array(":id" => $frag_id));
            unset($this->fragrances[$frag_id]);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function update_fragrance(Fragrance $fragrance): void {
        $stmt = $this->db->prepare("UPDATE fragrance SET name = :name, brand_id = :brand_id,"
                . "gender_id = :gender_id, description = :description, img_src = :img_src
                  WHERE id = :id");
        $stmt->execute(array(":name" => $fragrance->get_name(), ":brand_id" => 
                       $fragrance->get_brand()->get_id(), ":gender_id" => 
                       array_search($fragrance->get_gender(), $this->genders_by_id),
                       ":description" => $fragrance->get_description(), ":img_src"
                       => $fragrance->get_img_src(), ":id" => $fragrance->get_id()));
        
        $this->update_fragrance_category($fragrance);
        
    }
    
    public function update_fragrance_category(Fragrance $fragrance): void {
        $stmt = $this->db->prepare("DELETE FROM fragrance_category WHERE "
                                   . "fragrance_id = :frag_id");
        $stmt->execute(array(":frag_id" => $fragrance->get_id()));
        
         $stmt_insert = $this->db->prepare("INSERT INTO fragrance_category "
                 . "(fragrance_id, category_id) VALUES (:frag_id, :cat_id)");
         $cats = $fragrance->get_categories();
         if($cats){
             foreach($cats as $cat){
                 $stmt_insert->execute(array(":frag_id" => $fragrance->get_id(), 
                                       ":cat_id" => array_search($cat, $this->categories_by_id)));
             }
         }
    }

    public function save_fragrance(Fragrance $fragrance): void {
        try {
            $stmt = $this->db->prepare("INSERT INTO fragrance (name, brand_id, "
                    . "gender_id, description, img_src) VALUES"
                    . "(:name, :brand_id, :gender_id, :description, :img_src);");
            $stmt->execute(array(":name" => $fragrance->get_name(),
                ":brand_id" => $fragrance->get_brand()->get_id(),
                ":gender_id" => $this->get_gender_id($fragrance->get_gender()),
                ":description" => $fragrance->get_description(),
                ":img_src" => $fragrance->get_img_src()));
            $this->save_frag_categories($fragrance);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    private function save_frag_categories($fragrance): void {
        try {
            $frag_cat_stmt = $this->db->prepare("INSERT INTO fragrance_category VALUES"
                    . "(:fragrance_id, :category_id)");
            $cat_id = null;
            foreach ($fragrance->get_categories() as $cat) {
                foreach ($this->categories_by_id as $id => $cat_inner) {
                    if ($cat_inner === $cat) {
                        $cat_id = $id;
                    }
                }
                $frag_cat_stmt->execute(array(":fragrance_id" => $fragrance->get_id(),
                    ":category_id" => $cat_id));
            }
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function get_all_brands(): array {
        $brands = [];

        try {
            $stmt = $this->db->query("SELECT * FROM brand");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $brand = new Brand($row["id"],
                        $row["brand_name"],
                        $this->get_brand_price_sizes($row["id"])
                );
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
                    $categories[$row["id"]] = Category::from($row["category_value"]);
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
                            $row["name"],
                            $this->get_brands_by_id()[$row["brand_id"]],
                            $this->get_genders_by_id()[$row["gender_id"]],
                            $row["description"],
                            $row["img_src"],
                            $this->get_frag_categories($row["id"]),
                            $row["id"]
                    );
                    $fragrances[$fragrance->get_id()] = $fragrance;
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
                    $genders[$row["id"]] = Gender::from($row["gender_value"]);
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
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows) {
                foreach ($rows as $row) {
                    $price_size = new PriceSize(
                            $row["id"],
                            $this->sizes_by_id[$row["size_id"]],
                            $row["price_value"]
                    );
                    $price_sizes[$price_size->get_id()] = $price_size;
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
                    $sizes[$row["id"]] = Size::from($row["size_value"]);
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

    private function get_frag_categories(int $frag_id): array {
        $matches = [];
        try {
            $stmt = $this->db->prepare("SELECT category_id FROM fragrance_category WHERE fragrance_id = :id");
            $stmt->execute(array(":id" => $frag_id));
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows) {
                $cat_ids = [];
                foreach ($rows as $row) {
                    $cat_ids[] = $row["category_id"];
                }
                if ($cat_ids) {
                    foreach ($cat_ids as $cid) {
                        $matches[] = $this->categories_by_id[$cid];
                    }
                }
            }
        } catch (PDOException $e) {
            throw $e;
        } finally {
            return $matches;
        }
    }

    private function get_brand_price_sizes(int $brand_id): array {
        $matches = [];

        try {
            $stmt = $this->db->prepare("SELECT price_size_id FROM brand_price_size WHERE brand_id = :id");
            $stmt->execute(array(":id" => $brand_id));
            $prs_ids = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $prs_ids[] = $row["price_size_id"];
            }

            if ($prs_ids) {
                foreach ($prs_ids as $prsid) {
                    $matches[] = $this->price_sizes[$prsid];
                }
            }
        } catch (PDOException $e) {
            throw $e;
        } finally {
            return $matches;
        }
    }

    private function get_gender_id(Gender $gender): int {
        $gen_id = -1;
        foreach ($this->genders_by_id as $id => $gen) {
            if ($gen === $gender) {
                $gen_id = $id;
            }
        }
        return $gen_id;
    }
}
