<?php
    $GET_FOOD_STASH_DATA = "SELECT *, 
                            (SELECT COUNT(*) FROM food_stash_user WHERE food_stash_id = fs.id) AS joined
                            FROM food_stash fs
                            INNER JOIN food_stash_organizer fso ON fso.id = fs.organizer_id
                            WHERE fs.address_line_2  LIKE :location
                            ";

    $INSERT_FOOD_STASH_ENTRY = "INSERT INTO food_stash_user(food_stash_id, firstname, lastname, email, contact, address_line_1, address_line_2, reason)
                                VALUES(:stashid, :firstname, :lastname, :email, :contact, :address1, :address2, :reason)";

    $GET_EXISTING_STASH_USER = "SELECT * FROM food_stash_user WHERE contact = :contact AND food_stash_id = :stashid";
?>