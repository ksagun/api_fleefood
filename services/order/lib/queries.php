<?php
$CREATE_ORDER = "INSERT INTO orders(customer_id, item_id, quantity, order_date)
VALUES((SELECT id FROM customers WHERE email = :email), :item_id, :quantity, :order_date)";
