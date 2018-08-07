<?php
/*
Plugin Name: Extra product options bd
Description: Able to add extra products to single product page's by Danny Huigen
Author: Danny Huigen
*/

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array (
        'key' => 'group_5b572e597e911',
        'title' => 'Extra producten',
        'fields' => array (
            array (
                'key' => 'field_5b572e5eade2a',
                'label' => 'extra producten',
                'name' => 'extra_producten',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'collapsed' => '',
                'min' => 0,
                'max' => 0,
                'layout' => 'table',
                'button_label' => 'Extra product toevoegen',
                'sub_fields' => array (
                    array (
                        'key' => 'field_5bcxzcxz573602e7ef8',
                        'label' => '',
                        'name' => 'product',
                        'type' => 'post_object',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array (
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'post_type' => array (
                            0 => 'product',
                        ),
                        // 'taxonomy' => array (
                        // ),
                        'allow_null' => 0,
                        'multiple' => 0,
                        'return_format' => 'object',
                        'ui' => 1,
                    ),
                ),
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));

endif;


if( function_exists('acf_add_options_page') ) {

    // add parent
    $parent = acf_add_options_page(array(
        'page_title'    => 'Extra product opties',
        'menu_title'    => 'Extra product opties',
        'menu_slug' =>      'extra-product-options',
        'redirect'      => false
    ));


}

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array (
        'key' => 'group_5b62aeeba9db6',
        'title' => 'Extra product options by Danny',
        'fields' => array (
            array (
                'key' => 'field_5b62aefa2baf0',
                'label' => 'Kleur code',
                'name' => 'color_code',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'center_lat' => '',
                'center_lng' => '',
                'zoom' => '',
                'height' => '',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'extra-product-options',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));

endif;

//inject extra products on product page
add_action( 'woocommerce_after_add_to_cart_button', 'd_extra_products', 20 );

function d_extra_products() {

    global $product;

    $index = 0;


    ?>

    <div class="dep__screen-wrapper">
        <div class="dep__message-wrapper">
            <p class="dep__message">
                U heeft 12x Eindkapjes pl1 toegevoegd in uw winkelwagen,<br>
                u kunt overal klikken om dit scherm te sluiten
            </p>
        </div>
    </div>

    <?php if( have_rows('extra_producten') ): ?>

    <div style="margin-top: 40px">

        <span class="dep__title">Afzonderlijke bijbehorende producten</span>

            <?php while( have_rows('extra_producten') ): the_row();
                $post_object = get_sub_field("product");
                $option_product = wc_get_product( $post_object->ID );
                $product_description = $option_product->get_description();
                ?>

                <div data-productname="<?php echo $option_product->get_title(); ?>" data-productid="<?php echo $option_product->get_id(); ?>" data-price="<?php echo $option_product->get_price(); ?>" data-amountselected="1" class="dep__wrapper <?php if ($index % 2 != 0) { echo "dep__wrapper--even";} ?>">

                    <div style="background-image: url('<?php echo get_the_post_thumbnail_url(  $post_object->ID ); ?> ');" class="dep__image"></div>
                    <div class="dep__toptext-wrapper">
                        <p class="dep__name "><?php echo $option_product->get_title(); ?></p>
                        <p class="dep__single-price">Prijs per stuk: €<?php echo $option_product->get_price(); ?></p>
                        <div class="dep__check-box"></div>

                        <div class="dep__info">
                            <i>?</i>
                            <div style="display: none;" class="dep__inner-info">
                                <h1><?php echo $option_product->get_title(); ?></h1>
                                <br>
                                <?php echo $product_description ?>
                            </div>
                        </div>
                    </div>

                    <input class="dep__amount dep__show-on-active" value="1" type="number" name="">
                    <p class="dep__total-price dep__show-on-active">Totaal: €<?php echo $option_product->get_price(); ?></p>
                    <div class="dep__add-to-cart dep__show-on-active">Voeg afzonderlijk product toe</div>

                </div>

                <?php $index = $index +1; ?>

            <?php endwhile; ?>

            <div style="display: block; margin-bottom: 30px;"></div>

    </div>

    <?php endif; ?>

    <?php $color_code = get_field('color_code', 'option'); ?>


    <style type="text/css">

        .dep__info{
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: <?php echo $color_code; ?>;
            right: -30px;
            top: 0;
            bottom: 0;
            margin: auto 0;
            border-radius: 50%;
            z-index: 10000;
            transition: all .3s;
        }

        .dep__info i{
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            position: absolute;
            left: 0;
            right: 0;
            top: -6px;
            bottom: 0;
            margin: auto;
            color: white;
        }

        /*.dep__info:before{*/
            /*content: "?";*/
        /*}*/

        .dep__info:hover{
            transform: scale(1.1);
        }

        .variations tr{
            display: block;
        }

        .variations tr label{
            font-size: 18px;
        }

        .woocommerce div.product form.cart .button{
            float: unset !important;
        }

        .woocommerce div.product form.cart .variations select{
            font-size: 16px;
            padding-left: 5px;
            margin-bottom: 10px;
        }

        .dep__wrapper{
            position: relative;
            width: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: distribute;
            justify-content: space-around;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            padding-right: 10px;
            padding-bottom: 20px;
        }
        .dep__wrapper--even{
            background-color: rgba(0,0,0,0.04);
        }
        .dep__image{
            width: 50px;
            height: 50px;
            background-color: white;
            background-size: cover;
            background-position: center;
            cursor: pointer;
        }
        .dep__title{
            font-size: 18px;
            font-weight: bold;
            margin: 30px 0 15px 0;
            display: block;
        }
        .dep__toptext-wrapper{
            width: calc(100% - 50px);
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            cursor: pointer;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            position: relative;
            /*max-height: 50px;*/
        }
        .dep__name{
            font-weight: bold;
            display: inline;
            margin: 0 10px 0 10px;
            font-size: 15px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            line-height: 22px;
        }
        .dep__single-price{
            display: inline;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            line-height: 22px;
            margin: 0 10px;
            width: 90px;
            min-width: 90px;
            margin-left: auto;
        }
        .dep__check-box{
            width: 30px;
            height: 30px;
            /*margin-left: auto;*/
            border: solid 1px gray;
            -ms-flex-negative: 0;
            flex-shrink: 0;
            background-color: white !important;
        }

        .dep__wrapper--active .dep__check-box{
            background-color: <?php echo $color_code; ?> !important;
        }

        .dep__amount{
            width: 70px !important;
            height: 40px !important;
            text-align: center;
            border: 1px solid black;
            background-color: white !important;
            margin-left: 10px;
            margin-top: 15px;
        }

        .dep__total-price{
            margin-left: 20px;
            font-weight: bold;
            font-size: 15px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            margin-top: 15px;
        }

        .dep__add-to-cart{
            height: 50px;
            padding: 0 10px;
            background-color: <?php echo $color_code; ?>;
            color: white;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;

            margin-left: auto;
            cursor: pointer;
            font-weight: bold;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            align-items: center;
            margin-top: 15px;
        }

        .dep__screen-wrapper{
            display: none;

            width: 100%;
            height: 100%;
            position: fixed;
            background-color: rgba(0,0,0,0.75);
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            padding: 40px;
            cursor: pointer;
            z-index: 100000;
        }

        .dep__Screen-wrapper--active{
            display: block;
        }

        .dep__message-wrapper{
            width: 500px;
            height: 700px;
            height: min-content;
            padding: 20px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            background-color: white;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            margin: auto;
            z-index: 1002;
            pointer-events: none;
        }

        .dep__message{
            font-size: 17px;
            /*text-align: center;*/
            color: black;
            pointer-events: none;
        }

    </style>



    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script type="text/javascript">

        $(".dep__show-on-active").each(function(){
            $(this).hide();
        });

        $(".dep__amount").change(function() {
            calculateTotal($(this));
        });

        $( ".dep__amount" ).keyup(function() {
            calculateTotal($(this));
        });


        $(".dep__add-to-cart").click(function(){

            var $depWrap = $(this).parents(".dep__wrapper");

            window.location.href = window.location.href + "?add-to-cart=" + $depWrap.data("productid") + "&quantity=" + $depWrap.data("amountselected");

        });


        $(".dep__toptext-wrapper").click(function(){
            d_toggleActiveClass($(this));
        });
        $(".dep__image").click(function(){
            d_toggleActiveClass($(this));
        });

        $(".dep__screen-wrapper").click(function(){
            $(".dep__screen-wrapper").removeClass("dep__Screen-wrapper--active");
        });

        $(".dep__info").click(function () {
//            var message = "<br><br>u kunt overal klikken om dit scherm te sluiten.";

            var message = $(this).find(".dep__inner-info").html();

            $(".dep__message").html(message);
            $(".dep__screen-wrapper").addClass("dep__Screen-wrapper--active");
        });

        function d_toggleActiveClass(eventSender){
            var $depWrap = eventSender.parents(".dep__wrapper");

            $depWrap.toggleClass("dep__wrapper--active");

            if ($depWrap.hasClass("dep__wrapper--active")) {
                $depWrap.find(".dep__show-on-active").css("display" , "flex");
            }
            else{
                $depWrap.find(".dep__show-on-active").css("display" , "none");
            }
        }

        function d_show_message(amount , productName){
            var message = "U heeft "+amount+"x "+productName+" toegevoegd in uw winkelwagen,<br><br>u kunt overal klikken om dit scherm te sluiten.";

            $(".dep__message").html(message);
            $(".dep__screen-wrapper").addClass("dep__Screen-wrapper--active");
        }

        function calculateTotal(eventSender){
            var $depWrap = eventSender.parents(".dep__wrapper");
            var singlePrice = $depWrap.data("price");
            var amountSelected = eventSender.val();
            var totalPrice = parseFloat(singlePrice * amountSelected).toFixed(2);

            $depWrap.data("amountselected" , eventSender.val());
            $depWrap.find(".dep__total-price").text("Totaal: €"+totalPrice);
        }

    </script>

    <?php
}
?>