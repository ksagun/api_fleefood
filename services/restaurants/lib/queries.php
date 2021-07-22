<?php
$GET_RESTAURANT_LIST_BY_LOCATION = 'SELECT 
                                    id,
                                    business_name,
                                    business_logo,
                                    business_email,
                                    business_contact,
                                    business_location,
                                    address_line_1,
                                    city,
                                    municipality,
                                    zip_code
                                    FROM merchant 
                                    WHERE business_location LIKE :location';

$GET_RESTAURANT_MENU = 'SELECT 
                        mp.id,
                        m.business_name as "restaurant",
                        m.business_location as "location",
                        mp.product_name as "itemName",
                        mp.product_price as "itemPrice",
                        mp.in_stock as "inStock",
                        mp.is_available as "isAvailable",
                        mc.category_name as "category"
                        FROM merchant m
                        INNER JOIN merchant_products mp ON merchant_id = m.id
                        INNER JOIN menu_category mc ON mc.id = mp.category_id
                        WHERE m.business_name = :name AND m.id = :id';
