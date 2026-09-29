CREATE TABLE categories (
    id_category INT UNSIGNED NOT NULL AUTO_INCREMENT,
    category VARCHAR(30) NOT NULL,
    PRIMARY KEY (id_category),
    UNIQUE KEY categories_category_uindex (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE colors (
    id_color INT UNSIGNED NOT NULL AUTO_INCREMENT,
    color VARCHAR(30) NOT NULL,
    PRIMARY KEY (id_color),
    UNIQUE KEY colors_color_uindex (color)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE weights (
    id_weight INT UNSIGNED NOT NULL AUTO_INCREMENT,
    weight VARCHAR(30) NOT NULL,
    PRIMARY KEY (id_weight),
    UNIQUE KEY weights_weight_uindex (weight)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE products (
    id_product INT UNSIGNED NOT NULL AUTO_INCREMENT,
    category VARCHAR(30) NOT NULL,
    title VARCHAR(30) NOT NULL,
    color VARCHAR(30) NOT NULL,
    weight VARCHAR(30) NOT NULL,
    PRIMARY KEY (id_product),
    KEY products_category_index (category),
    KEY products_color_index (color),
    KEY products_weight_index (weight),
    CONSTRAINT products_category_foreign_key
        FOREIGN KEY (category) REFERENCES categories (category)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT products_color_foreign_key
        FOREIGN KEY (color) REFERENCES colors (color)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT products_weight_foreign_key
        FOREIGN KEY (weight) REFERENCES weights (weight)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
