<?php

require 'constants.php';

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Affirm PoC</title>
    <script>
        const public_api_key = '<?=$_ENV['public_key'] ?>';
    </script>
    <script src="js/affirm.js"></script>
</head>
<body>
    <button id="checkout">
        Checkout
    </button>
    <script>
        const base_url = '<?= $_ENV['base_url'] ?>';

        const addressObject = {
            "line1":"260 Rue Labelle",
            "line2":"Floor 7",
            "city":"Saint-Jerome",
            "state":"QC",
            "zipcode":"J7Z5L1",
            "country":"CA"
        };
        const currency = 'CAD';


        document.querySelector('#checkout').onclick = function() {
            affirm.checkout({

                "merchant": {
                    "user_confirmation_url": `${base_url}/confirm.php`,
                    "user_cancel_url": `${base_url}/cancel.php`,
                    "user_confirmation_url_action": "POST",
                    "name": "BigCommerce PoC"
                },
                "shipping":{
                    "name":{
                        "first":"Joe",
                        "last":"Doe"
                    },
                    "address": addressObject,
                    "phone_number": "4153334567",
                    "email": "joedoe@123fakestreet.com"
                },
                "billing":{
                    "name":{
                        "first":"Joe",
                        "last":"Doe"
                    },
                    "address": addressObject,
                    "phone_number": "4153334567",
                    "email": "joedoe@123fakestreet.com"
                },
                "items": [{
                    "display_name":         "Awesome Pants",
                    "sku":                  "ABC-123",
                    "unit_price":           1999,
                    "qty":                  3,
                    "item_image_url":       "http://merchantsite.com/images/awesome-pants.jpg",
                    "item_url":             "http://merchantsite.com/products/awesome-pants.html",
                    "categories": [
                        ["Home", "Bedroom"],
                        ["Home", "Furniture", "Bed"]
                    ]
                }
                ],
                "discounts":{
                    "RETURN5":{
                        "discount_amount":500,
                        "discount_display_name":"Returning customer 5% discount"
                    },
                    "PRESDAY10":{
                        "discount_amount":1000,
                        "discount_display_name":"President's Day 10% off"
                    }
                },
                "metadata":{
                    "shipping_type":"UPS Ground",
                    "mode":"modal"
                },
                "order_id":"JKLMO4321",
                "currency": currency,
                "financing_program":"flyus_3z6r12r",
                "shipping_amount":1000,
                "tax_amount":500,
                "total":100000
            });

            affirm.checkout.open();
        };
    </script>
</body>
</html>
