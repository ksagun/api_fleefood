<?php
$GET_RESTAURANT_LIST_BY_LOCATION = 'SELECT 
                                    id,
                                    business_name,
                                    business_logo,
                                    business_email,
                                    business_contact,
                                    business_location,
                                    address_line_2,
                                    city,
                                    province,
                                    municipality,
                                    zip_code
                                    FROM merchant 
                                    WHERE business_location LIKE :location';

$GET_RESTAURANT_DETAILS = 'SELECT 
                           m.id as "id",
                           m.business_name as "restaurant",
                           m.banner_image as "bannerImage",
                           m.opening as "opening",
                           m.closing as "closing",
                           m.business_location as "location",
                           m.address_line_1 as "address1",
                           m.address_line_2 as "address2",
                           m.province as "province",
                           m.city as "city",
                           m.municipality as "municipality",
                           m.zip_code as "zip"
                           FROM merchant m
                           WHERE m.id = :id AND 
                           m.business_name = :name';

$GET_RESTAURANT_CATEGORY = 'SELECT 
                            c.category_name
                            FROM menu_category c 
                            INNER JOIN merchat m ON m.id = c.merchant_id
                            WHERE c.merchant_id = :id';

$GET_RESTAURANT_MENU = 'SELECT 
                        mp.id as "itemId",
                        mp.product_name as "itemName",
                        mp.product_price as "itemPrice",
                        mp.in_stock as "inStock",
                        mp.is_available as "isAvailable",
                        mc.category_name as "category",
                        pi.image_path as "productImage"
                        FROM merchant m
                        INNER JOIN merchant_products mp ON merchant_id = m.id
                        INNER JOIN menu_category mc ON mc.id = mp.category_id
                        INNER JOIN product_images pi ON pi.id = mp.product_image_id
                        WHERE m.business_name = :name AND m.id = :id';
