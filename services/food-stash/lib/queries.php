<?php
    $GET_FOOD_STASH_DATA = "SELECT * FROM food_stash fs
                            INNER JOIN food_stash_organizer fso ON fso.id = fs.organizer_id
                            WHERE fs.address_line_2  LIKE :location
                            ";
?>