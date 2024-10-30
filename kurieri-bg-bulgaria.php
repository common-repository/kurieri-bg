<?php
/**
 * Plugin Name: Kurieri-bg
 * Description: С тази добавка имате възможност да добавите информация за Куриер и номер на товарителница към поръчките си. Това позволява след това да изпратите известие към клиента по имейл, СМС или WhatsApp за да може той да проследи самата доставка. Проследяването може да се извърши и в страницата с "поръчки" на клиента.
 * Version: 0.1.0
 * Author: BsmsApp.com | Mehmed Halil
 * Author URI: https://bsmsapp.com
 */


//Add Menu to WPadmin ktkp=kBG
include 'BsmsApp-helper.php';
include 'kurieri-bg-helper.php';
include 'kurieri-bg-order-list.php';
add_action( 'admin_menu', 'kurieriBG_register_admin_menu' );
function kurieriBG_register_admin_menu() {
    $menu_slug = 'kurieri-bg-bulgaria';
    // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    add_menu_page( 'Куриери България', 'Куриери-БГ', 'read', $menu_slug, false, 'dashicons-car', 20 );
    add_submenu_page( $menu_slug, 'Куриери България Настройки', 'Настройки', 'read', $menu_slug, 'kurieriBG_setting_page' );

    add_action( 'admin_init', 'kurieriBG_register_settings' );
}

function kurieriBG_register_settings() {
    $args = array(
        'default' => 'yes',
    );
//kargo_hazirlaniyor_text=tracking_ready_text
    register_setting( 'kurieriBG-settings-group', 'tracking_ready_text',$args  );

    register_setting( 'kurieriBG-settings-group', 'mail_send_general',$args  );
    register_setting( 'kurieriBG-settings-group', 'sms_provider',$args  );

    register_setting( 'kurieriBG-settings-group', 'sms_send_general',$args  );

    register_setting( 'kurieriBG-settings-group', 'BsmsApp_UserName',$args  );
    register_setting( 'kurieriBG-settings-group', 'BsmsApp_Password',$args  );
    register_setting( 'kurieriBG-settings-group', 'BsmsApp_Header',$args  );
    register_setting( 'kurieriBG-settings-group', 'BsmsApp_sms_url_send',$args  );
	register_setting( 'kurieriBG-settings-group', 'BsmsApp_footer',$args  );
    register_setting( 'kurieriBG-settings-group', 'BsmsApp_sender',$args  );
    register_setting( 'kurieriBG-settings-group', 'BsmsApp_type',$args  );
	register_setting( 'kurieriBG-settings-group', 'Bsmsapp_sim',$args  );
	register_setting( 'kurieriBG-settings-group', 'Bsmsapp_mode',$args  );
	register_setting( 'kurieriBG-settings-group', 'Bsmsapp_device',$args  );
	register_setting( 'kurieriBG-settings-group', 'Bsmsapp_deviceid',$args  );
	register_setting( 'kurieriBG-settings-group', 'Bsmsapp_waid',$args  );
	    register_setting( 'kurieriBG-settings-group', 'BsmsApp_m1',$args  );
		    register_setting( 'kurieriBG-settings-group', 'BsmsApp_m2',$args  );
}


function kurieriBG_setting_page() {
    $tracking_ready_text = get_option('tracking_ready_text');
    $mail_send_general_option = get_option('mail_send_general');
    $sms_provider = get_option('sms_provider');

    $BsmsApp_UserName = get_option('BsmsApp_UserName');
    $BsmsApp_Password = get_option('BsmsApp_Password');
    $BsmsApp_Header = get_option('BsmsApp_Header');
    $BsmsApp_sms_url_send = get_option('BsmsApp_sms_url_send');
	$BsmsApp_UserName = get_option('BsmsApp_UserName');
    $BsmsApp_Password = get_option('BsmsApp_Password');
    $BsmsApp_sender = get_option('BsmsApp_sender');
    $BsmsApp_sms_url_send = get_option('BsmsApp_sms_url_send');
	$BsmsApp_footer = get_option('BsmsApp_footer');
    $BsmsApp_type = get_option('BsmsApp_type');
    $BsmsApp_sender = get_option('BsmsApp_sender');
	$BsmsApp_m1 = get_option('BsmsApp_m1');
	$BsmsApp_m2 = get_option('BsmsApp_m2');
	$Bsmsapp_sim = get_option('Bsmsapp_sim');
	$Bsmsapp_mode = get_option('Bsmsapp_mode');
	$Bsmsapp_device = get_option('Bsmsapp_device');
	$Bsmsapp_deviceid = get_option('Bsmsapp_deviceid');
	$Bsmsapp_waid = get_option('Bsmsapp_waid');

    ?>
    <div class="wrap">
        <h1>Куриери България</h1>

        <form method="post" action="options.php">
            <?php settings_fields( 'kurieriBG-settings-group' ); ?>
            <?php do_settings_sections( 'kurieriBG-settings-group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row" style="width:50%">
                        <?php _e( 'Преди да въведете информацията за товарителница, трябва ли да се показва текстът за подготовка на пакета, показван в поръчките?', 'kurieriBG' ) ?>
                    </th>
                    <td>
                        <input type="radio" id="evet" <?php if( $tracking_ready_text == 'yes' ) echo 'checked'?>
                            name="tracking_ready_text" value="yes">
                        <label for="evet">Да</label><br>
                    </td>
                    <td>
                        <input type="radio" id="hayir" <?php if( $tracking_ready_text == 'no' ) echo 'checked'?>
                            name="tracking_ready_text" value="no">
                        <label for="hayir">Не</label><br>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row" style="width:50%">
                        <?php _e( 'Да се изпрати ли автоматично имейл когато се въведат данни за товарителница ?', 'kurieriBG' ) ?>
                    </th>
                    <td>
                        <input type="radio" id="evetmail" <?php if( $mail_send_general_option == 'yes' ) echo 'checked'?> name="mail_send_general" value="yes">
                        <label for="evetmail">Да</label><br>
                    </td>
                    <td>
                        <input type="radio" id="hayirmail" <?php if( $mail_send_general_option == 'no' ) echo 'checked'?> name="mail_send_general" value="no">
                        <label for="hayirmail">Не</label><br>
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="width:50%"><hr></th>
                    <td><hr></td>
                    <td><hr></td>
                </tr>
                <tr valign="top">
                    <th scope="row" style="width:50%">
                        <?php _e( 'Изпращане на автоматичен SMS или WhatsApp? Изберете фирма, чрез която да бъде изпратено<br>
						
						<i>За изпращането на съобщения имате нужда от акаунт в системата на <a href="https://bsmsapp.com" target="_blank">BsmsAPP*</a></i>
						
						', 'kurieriBG' ) ?>
                    </th>
                    <td>
                        <input type="radio" id="yokSms" <?php if( $sms_provider == 'no' ) echo 'checked'?> name="sms_provider" value="no">
                        <label for="yokSms">Не</label><br>
                    </td>
                    <td>
                        <input type="radio" id="BsmsApp" <?php if( $sms_provider == 'BsmsApp' ) echo 'checked'?> name="sms_provider" value="BsmsApp">
                        <label for="BsmsApp">BsmsApp</label><br>
                    </td>
                </tr>

                <tr class="BsmsApp" <?php if( $sms_provider != 'BsmsApp' ) echo 'style="display:none"'?>>
                    <th scope="row" style="width:50%"><hr></th>
					<tr valign="top" class="BsmsApp"  <?php if( $sms_provider != 'BsmsApp' ) echo 'style="display:none"'?>>
                    <th scope="row" style="width:25%">
                        <?php _e( 'Bsmsapp.com Account <br> Api key <br>


						Запишете след въвеждане на Api key.', 'kurieriBG' ) ?>
						
						
                    </th>
                    <td>
                        <label for="BsmsApp_UserName" class="label-bold">Api key </label>  <br>
                        <input type="text" id="BsmsApp_UserName" name="BsmsApp_UserName" value="<?php echo esc_attr( $BsmsApp_UserName ); ?>">
                    </td>
                    <td><hr></td>
                    <td><hr></td>
                </tr>

               <!-- Съдържание СМС -->
                <tr class="BsmsApp" <?php if( $sms_provider != 'BsmsApp' ) echo 'style="display:none"'?>>
                    <th scope="row" style="width:50%"><hr></th>
                    <td><hr></td>
                    <td><hr></td>
                </tr>

                <tr valign="top" class="BsmsApp"  <?php if( $sms_provider != 'BsmsApp' ) echo 'style="display:none"'?>>
                    <th scope="row" style="width:25%">
                        <?php _e( 'Съдържание на СМС / WhatsApp <br> Част 1 и част 2 <br> Въведете текст който да се изпрати за <font color="green">част</font> 1 *** след нея ще се добави номер на товаарителница *** след нея следва текст от <font color="green">част 2</font>, последвано от *** Наименование на куриерска фирма *** <font color="green">Текст за край на събщение</font> <br><b>Template:  <i>SMS M1 #Pacel Number SMS M2 #PARCEL COMPANY Footer</i></b> ', 'kurieriBG' ) ?>
                    <b> Real Result</b> <font color="red"> <?php echo esc_attr( $BsmsApp_m1 ); ?> #Tracking_Number <?php echo esc_attr( $BsmsApp_m2 ); ?> #Parcel_Company <?php echo esc_attr( $BsmsApp_footer ); ?></th>
                    <td>
                        <label for="BsmsApp_m1" class="label-bold">SMS M1 - Част 1 </label>  <br>
                        <input type="text" id="BsmsApp_m1" name="BsmsApp_m1" value="<?php echo esc_attr( $BsmsApp_m1 ); ?>"><br>
                    </td>
                    <td>
                        <label for="BsmsApp_m2" class="label-bold">SMS M2 - Част 2</label>  <br>
					
                        <input type="text" id="BsmsApp_m2" name="BsmsApp_m2" value="<?php echo esc_attr( $BsmsApp_m2 ); ?>"><br>
                        <br>
                    </td><br>
					<td>
                        <label for="BsmsApp_sender" class="label-bold">SMS Footer (след фирма текст за край) </label>  <br>
						 
                        <input type="text" id="BsmsApp_footer" name="BsmsApp_footer" value="<?php echo esc_attr( $BsmsApp_footer ); ?>"><br>
                    </td>
                </tr>

<!-- Съдържание СМС  Kraj-->
<!-- Тайп СМС -->
                <tr class="BsmsApp" <?php if( $sms_provider != 'BsmsApp' ) echo 'style="display:none"'?>>
                    <th scope="row" style="width:50%"><hr></th>
                    <td><hr></td>
                    <td><hr></td>
                </tr>

                <tr valign="top" class="BsmsApp"  <?php if( $sms_provider != 'BsmsApp' ) echo 'style="display:none"'?>>
                    <th scope="row" style="width:25%">
                        <?php _e( 'Meesage Type | Тип Съобщение', 'kurieriBG' ) ?>
                    </th>
                    <td>
                        <input type="radio" id="type_t" <?php if( $BsmsApp_type == 'https://cloud.bsmsapp.com/api/send/sms' ) echo 'checked'?> name="BsmsApp_type" value="https://cloud.bsmsapp.com/api/send/sms">
                        <label for="type_t">SMS</label><br>
                    </td>
                    <td>

                        
                         <input type="radio" id="type_tf" <?php if( $BsmsApp_type == 'https://cloud.bsmsapp.com/api/send/whatsapp' ) echo 'checked'?> name="BsmsApp_type" value="https://cloud.bsmsapp.com/api/send/whatsapp">
                        <label for="type_tf">WhatsApp </label>
                    </td>
					
				
                </tr>

<!-- Тайп СМС  Kraj-->

     <!-- SIM  -->
                <tr class="BsmsApp" <?php if( $sms_provider != 'BsmsApp' ) echo 'style="display:none"'?>>
                    <th scope="row" style="width:50%"><hr></th>
                    <td><hr></td>
                    <td><hr></td>
                </tr>

                <tr valign="top" class="BsmsApp"  <?php if( $sms_provider != 'BsmsApp' ) echo 'style="display:none"'?>>
                    <th scope="row" style="width:25%">
                        <?php _e( 'Ако е избрана опцията за изпращане като СМС от коя сим карта да се изпрати? (ако телефона ви е с 1 сим карта, изберете СИМ 1) SIM ', 'kurieriBG' ) ?>
                    </th>
                    <td>
                        <input type="radio" id="type_t" <?php if( $Bsmsapp_sim == '1' ) echo 'checked'?> name="Bsmsapp_sim" value="1">
                        <label for="type_sim1">SIM 1</label><br>
                    </td>
                    <td>

                        
                         <input type="radio" id="type_tf" <?php if( $Bsmsapp_sim == '2' ) echo 'checked'?> name="Bsmsapp_sim" value="2">
                        <label for="type_sim2">SIM 2 </label>
                    </td>
					
					
                </tr>

<!-- Тайп SIM  Kraj-->

 <tr valign="top" class="BsmsApp"  <?php if( $sms_provider != 'BsmsApp' ) echo 'style="display:none"'?>>
                    <th scope="row" style="width:25%">
                        <?php _e( 'Accounts ID <br>
						<i>Тези данни следва да вземете от <a href="https://bsmsapp.com" target="_blank">BsmsAPP*</a> акаунта си, необходимо е да въведете номер на устройство или номер на WhatsApp от системата на <a href="https://bsmsapp.com" target="_blank">BsmsAPP*</a> Данните се намирар в меню WhatsApp->Акаунт->Използвайте иконката за копиране
						
						
						
						' ) ?>
 
                    </th>
                    <td>
                        <label for="Bsmsapp_deviceid" class="label-bold">Device ID </label>  <br>
						
                        <input type="text" id="Bsmsapp_deviceid" name="Bsmsapp_deviceid" value="<?php echo esc_attr( $Bsmsapp_deviceid ); ?>"><br>
						 
                    </td>
					 <td>
                        <label for="Bsmsapp_waid" class="label-bold">WhatsApp ID </label>  <br>
						
                        <input type="text" id="Bsmsapp_waid" name="Bsmsapp_waid" value="<?php echo esc_attr( $Bsmsapp_waid ); ?>"><br>
						 
                    </td>
                    <td>
                       
                        <br>
                    </td>
                </tr>           

               

                <tr valign="top">
                    <th scope="row" style="width:50%">
                        <?php _e( 'Проследяване URL да се изпрати ли ? <br> Ако активирате тази опция е възможно СМС-а да стане по-дълъг и да бъдете таксувани допълнително.', 'kurieriBG' ) ?>
                    </th>
                    <td>
                        <input type="radio" id="yes_url_send" <?php if( $BsmsApp_sms_url_send == 'yes' ) echo 'checked'?> name="BsmsApp_sms_url_send" value="yes">
                        <label for="yes_url_send">Да</label><br>
                    </td>
                    <td>
                        <input type="radio" id="noUrlSend" <?php if( $BsmsApp_sms_url_send == 'no' ) echo 'checked'?> name="BsmsApp_sms_url_send" value="no">
                        <label for="noUrlSend">Не</label><br>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>

            <script>
                jQuery(document).ready(function($) {
                    $('input[type=radio][name=sms_provider]').change(function() {
                        if (this.value == 'no') {
                            $('.BsmsApp').hide();

                        } else if (this.value == 'BsmsApp') {
                            $('.BsmsApp').show(2000);
                        }
                    });
                })
            </script>

            <style>
                .label-bold{
                    text-align: center;
                    font-weight: bold;
                }
            </style>
        </form>
    </div>
<?php
}

// Register new status wc-kargo-verildi=wc-tovaritelnica
function kurieriBG_register_shipment_shipped_order_status() {
    register_post_status('wc-tovaritelnica', array(
        'label' => 'Добавена товарителница',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Генерирана товарителница(%s)', 'Генерирана товарителница (%s)'),
    ));
}

add_action('init', 'kurieriBG_register_shipment_shipped_order_status');
function kurieriBG_add_shipment_to_order_statuses($order_statuses) {
    $order_statuses['wc-tovaritelnica'] = _x('Генерирана товарителница', 'WooCommerce Order status', 'woocommerce');
    return $order_statuses;
}

add_filter('wc_order_statuses', 'kurieriBG_add_shipment_to_order_statuses');
add_action('woocommerce_admin_order_data_after_order_details', 'kurieriBG_general_shipment_details_for_admin');
function kurieriBG_general_shipment_details_for_admin($order) {
    $tracking_company = get_post_meta($order->get_id(), 'tracking_company', true);
    $tracking_code = get_post_meta($order->get_id(), 'tracking_code', true);
    ?>
        <br class="clear" />
    <?php

    woocommerce_wp_select(array(
        'id' => 'tracking_company',
        'label' => 'Куриерска фирма:',
        'description' => 'Моля изберете куриер',
        'desc_tip' => true,
        'value' => $tracking_company,
        'placeholder' => 'Не е избран куриер',
        'options' => kurieriBG_cargo_company_list(),
        'wrapper_class' => 'form-field-wide shipment-set-tip-style',
    ));

    ?>
        <script>
            jQuery(document).ready(function($) {
                $('#tracking_company').select2();
            });
        </script>
    <?php

    woocommerce_wp_text_input(array(
        'id' => 'tracking_code',
        'label' => 'Товарителница:',
        'description' => 'Моля въведете номер на товарителница.',
        'desc_tip' => true,
        'value' => $tracking_code,
        'wrapper_class' => 'form-field-wide shipment-set-tip-style',
    ));

}

add_action('woocommerce_process_shop_order_meta', 'kurieriBG_tracking_save_general_details');
function kurieriBG_tracking_save_general_details($ord_id) {
    $tracking_company = get_post_meta($ord_id, 'tracking_company', true);
    $tracking_code = get_post_meta($ord_id, 'tracking_code', true);
    $order_note = wc_get_order($ord_id);
    $mail_send_general_option = get_option('mail_send_general');
    $sms_provider = get_option('sms_provider');

    if (($tracking_company != $_POST['tracking_company']) && ($tracking_code == $_POST['tracking_code'])) {
        update_post_meta($ord_id, 'tracking_company', wc_clean($_POST['tracking_company']));

        $note = __("Обновенни данни за куриерска фирма.");

        $order_note->add_order_note($note);
    } elseif (($tracking_company == $_POST['tracking_company']) && ($tracking_code != $_POST['tracking_code'])) {
        update_post_meta($ord_id, 'tracking_code', wc_sanitize_textarea($_POST['tracking_code']));

        $note = __("Номера на товарителницата е обновен.");

        $order_note->add_order_note($note);
    } elseif (($tracking_company == $_POST['tracking_company']) && ($tracking_code == $_POST['tracking_code'])) {

    } elseif (!empty($_POST['tracking_company']) && !empty($_POST['tracking_code'])) {
        update_post_meta($ord_id, 'tracking_company', wc_clean($_POST['tracking_company']));
        update_post_meta($ord_id, 'tracking_code', wc_sanitize_textarea($_POST['tracking_code']));
        $order = new WC_Order($ord_id);
        $order->update_status('wc-tovaritelnica', 'Добавен е номер на товарителница');
        if ($mail_send_general_option == 'yes') do_action('order_ship_mail', $ord_id);
        if ($sms_provider == 'BsmsApp') do_action('order_send_sms', $ord_id);

    }
}

add_action('admin_head', 'kurieriBG_shipment_fix_wc_tooltips');
function kurieriBG_shipment_fix_wc_tooltips() {
    echo '<style>
	    #order_data .order_data_column .form-field.shipment-set-tip-style label{
		    display:inline-block;
	    }
	    .form-field.shipment-set-tip-style .woocommerce-help-tip{
		    margin-bottom:5px;
	    }
	    </style>';
}

function kurieriBG_shipment_details($order) {
    $tracking_company = get_post_meta($order->get_id(), 'tracking_company', true);
    $tracking_code = get_post_meta($order->get_id(), 'tracking_code', true);
    $tracking_ready_text_option = get_option('tracking_ready_text');
    if ( $order->get_status() != 'cancelled') {
        if ($tracking_company == '') {
            if ($tracking_ready_text_option =='yes') {
                echo "<blockquote>

			<td style='text-align:center'>Вашата пратка се подготвя</td>
		
</blockquote>";
            } else {
            ?>
            
            <?php
            }
        }
        else {
            ?>  <blockquote>
            <div class="shipment-order-page">
                <h2 id="kargoTakipSection">Проследяване на поръчката</h2>
                <h4>Вашата поръчка ще бъде доставена от: <span style='color:#1abc9c'><?php echo kurieriBG_get_company_name($tracking_company); ?></span></h4> 
                <h4><?php _e( 'Товарителница номер:','kurieriBG');?>  <?php echo esc_attr( $tracking_code ); ?></h4> 
                <?php echo '<a href="' . kurieriBG_getCargoTrack($tracking_company, $tracking_code) . '"target="_blank" rel="noopener noreferrer">'; _e( 'За да проследите вашата пратка кликнете тук.','kurieriBG' );  echo '</a>'; ?>
            </div></blockquote>
            <?php
        }
    }
}

add_action('woocommerce_after_order_details', 'kurieriBG_shipment_details');
add_filter('woocommerce_my_account_my_orders_actions', 'kurieriBG_add_kargo_button_in_order', 10, 2);
function kurieriBG_add_kargo_button_in_order($actions, $order) {
    $tracking_company = get_post_meta($order->get_id(), 'tracking_company', true);
    $tracking_code = get_post_meta($order->get_id(), 'tracking_code', true);
    $action_slug = 'kargoButonu';

    if (!empty($tracking_code)) {
        $cargoTrackingUrl = kurieriBG_getCargoTrack($tracking_company, $tracking_code);
        $actions[$action_slug] = array(
            'url' => $cargoTrackingUrl,
            'name' => 'Проследи пратката',
        );
        return $actions;
    } else {
        return $actions;
    }
}

function kurieriBG_kargo_bildirim_icerik($order, $mailer, $mail_title = false) {
    $template = 'email-shipment-template.php';
    $mailTemplatePath = untrailingslashit(plugin_dir_path(__FILE__)) . '/mail-template/';

    $tracking_company = get_post_meta($order->get_id(), 'tracking_company', true);
    $tracking_code = get_post_meta($order->get_id(), 'tracking_code', true);

    return wc_get_template_html($template, array(
        'order' => $order,
        'email_heading' => $mail_title,
        'sent_to_admin' => false,
        'plain_text' => false,
        'email' => $mailer,
        'tracking_company' => $tracking_company,
        'tracking_code' => $tracking_code,
    ), '', $mailTemplatePath);
}

function kurieriBG_SMS_gonder($order_id) {
    $order = wc_get_order($order_id);
    $phone = $order->get_billing_phone();

    $BsmsApp_UserName = get_option('BsmsApp_UserName');
    $BsmsApp_Password = urlencode(get_option('BsmsApp_Password'));
    $BsmsApp_Header = get_option('BsmsApp_Header');
    $BsmsApp_sms_url_send = get_option('BsmsApp_sms_url_send');
	$BsmsApp_sender = get_option('BsmsApp_sender');
	$BsmsApp_footer = get_option('BsmsApp_footer');
	$BsmsApp_type = get_option('BsmsApp_type');
	$BsmsApp_m1 = get_option('BsmsApp_m1');
	$BsmsApp_m2 = get_option('BsmsApp_m2');
	$Bsmsapp_sim = get_option('Bsmsapp_sim');
	$Bsmsapp_device = get_option('Bsmsapp_device');
	$Bsmsapp_mode = get_option('Bsmsapp_mode');
	$Bsmsapp_waid = get_option('Bsmsapp_waid');

    $tracking_company = get_post_meta($order_id, 'tracking_company', true);
    $tracking_code = get_post_meta($order_id, 'tracking_code', true);

    $message2 = "Tovaritelnicata na vashata porucka e: " . $tracking_code . ", s dostavka ot " . kurieriBG_get_company_name($tracking_company) . " " . $BsmsApp_footer . "";
    $message = "" . $BsmsApp_m1 . "" . $tracking_code . " " . $BsmsApp_m2 . " " . kurieriBG_get_company_name($tracking_company) . " " . $BsmsApp_footer . "";
   // $message = urlencode($message);

    if ($BsmsApp_sms_url_send == 'yes') {
        $message = $message." URL: ".urlencode("").kurieriBG_getCargoTrack($tracking_company, $tracking_code);
    }

     if($BsmsApp_sender == "yes"){
        $BsmsApp_sender = kurieriBG_get_BsmsApp_senders($BsmsApp_UserName, $BsmsApp_Password);
        $BsmsApp_sender = $BsmsApp_sender[0];
    }
  if ($BsmsApp_type == 'https://cloud.bsmsapp.com/api/send/sms') {
	    $BsmsApp_sender = urlencode($BsmsApp_sender);
      $url = "https://cloud.bsmsapp.com/api/send/sms?secret=$BsmsApp_UserName&mode=devices&phone=$phone&sim=$Bsmsapp_sim&message=$message&device=$Bsmsapp_deviceid";
	  
	    $request = wp_remote_get($url);

	  if ($request['body'] !=200 || $request['body'] !=20 || $request['body'] !=40 || $request['body'] !=50 || $request['body'] != 51 || $request['body'] != 70 || $request['body'] != 85) {
        $order->add_order_note("".explode(",",$request['body'])[1]);
    } else {
        $order->add_order_note("".$request['body']);
 
 
    
	}
 
  }
  
  
  
  
  if ($BsmsApp_type == 'https://cloud.bsmsapp.com/api/send/whatsapp') {
	  
	  	    $BsmsApp_sender = urlencode($BsmsApp_sender);

    
 $url = "https://cloud.bsmsapp.com/api/send/whatsapp?secret=$BsmsApp_UserName&account=$Bsmsapp_waid&recipient=$phone&type=text&message=$message";
  $request = wp_remote_get($url);
if ($request['body'] !=200 || $request['body'] !=20 || $request['body'] !=40 || $request['body'] !=50 || $request['body'] != 51 || $request['body'] != 70 || $request['body'] != 85) {
        $order->add_order_note("".explode(",",$request['body'])[1]);
    } else {
        $order->add_order_note("".$request['body']);
 
 
    
	}

//$order->add_order_note("Debug : ".$request['body']);
	
  
	
  }

   // $url= "https://api.BsmsApp.co/smsapi?username=$BsmsApp_UserName&password=$BsmsApp_Password&type=$BsmsApp_type&to=$phone&source=$BsmsApp_sender&message=$message"; -->
 
	

    
}



function kurieriBG_kargo_eposta_details($order_id) {
    $order = wc_get_order($order_id);
    $phone = $order->get_billing_phone();
    $alici = $order->get_shipping_first_name() . " " . $order->get_shipping_last_name();
    $mailer = WC()->mailer();

    $mailTo = $order->get_billing_email();
    $subject = "Добавена е товарителница за вашата поръчка";
    $details = kurieriBG_kargo_bildirim_icerik($order, $mailer, $subject);
    $mailHeaders[] = "Content-Type: text/html\r\n";

    $mailer->send($mailTo, $subject, $details, $mailHeaders);

    $note = __("На клиентския имейл " . $order->get_billing_email() . " е изпратено съобщение за куриер и товарителница.");
    $order->add_order_note($note);

    // Siparişi güncelle
    $order->save();
}

add_action('order_ship_mail', 'kurieriBG_kargo_eposta_details');
add_action('order_send_sms', 'kurieriBG_SMS_gonder');