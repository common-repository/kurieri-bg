<?php

/*
 * Kargo anahtarını kullanarak ilgili kargo firma ismini verir.
 * 
 * 
 * @param   string $tracking_company kargo anahtarı
 * @return  string
 *  
 */
function kurieriBG_get_company_name($tracking_company) {
    $config = include("config.php");
    return $config["cargoes"][$tracking_company]["company"];
}

/*
 * Kargo anahtarı ve takip kodunu kullanarak ilgili 
 * gönderi için takip koduna ait takip sayfası bağlantısını verir.
 * 
 * 
 * @param   string $tracking_company kargo anahtarı
 * @return  string
 *  
 */
function kurieriBG_getCargoTrack($tracking_company = NULL, $tracking_code = NULL) {
    $config = include("config.php");
    return $config["cargoes"][$tracking_company]["url"] . $tracking_code;
}

/*
 * Kargo anahtarını kullanarak ilgili kargo firmasının 
 * kargo adini verir.
 * 
 * 
 * @param   string $tracking_company kargo anahtarı
 * @return  string
 *  
 */

function kurieriBG_getCargoName($tracking_company = NULL) {
    $config = include("config.php");
    return $config["cargoes"][$tracking_company]["name"];
}


/**
 * Sistemde tanimli kargo firmalarinin isim listesini verir
 * 
 * @return array kargo firma ismi ve anahtari
 */
function kurieriBG_cargo_company_list() : array {
    $config = include("config.php");
    $companies = ["" => "Изберете куриерска фирма"];
    foreach($config["cargoes"] as $key => $cargo) {
        $companies += array($key => $cargo["company"]);
    }
    return $companies;
}


/**
 * Order Numarasina gore kargo logusunu verir eger yoksa bos doner
 * 
 * @return array kargo firma ismi ve anahtari
 */

function kurieriBG_get_order_cargo_logo($order_id) {
    $order = wc_get_order($order_id);
    $tracking_company = get_post_meta($order->get_id(), 'tracking_company', true);

    if($tracking_company) {
        $config = include("config.php");
        $logo = $config["cargoes"][$tracking_company]["logo"];

        if($logo) {
            return $logo;
        } else {
            return "";
        }
        
    } else {
        return "";
    }
}

//Function return tracking code, company name and tracking url 

function KurieriBG_get_order_cargo_information($order_id) {
    $order = wc_get_order($order_id);
    $tracking_company = get_post_meta($order->get_id(), 'tracking_company', true);
    $tracking_code = get_post_meta($order->get_id(), 'tracking_code', true);

    if($tracking_company) {
        $config = include("config.php");
        $logo = $config["cargoes"][$tracking_company]["logo"];
        $company = $config["cargoes"][$tracking_company]["company"];
        $url = $config["cargoes"][$tracking_company]["url"] . $tracking_code;

        if($logo) {
            return array(
                "logo" => $logo,
                "company" => $company,
                "url" => $url
            );
        } else {
            return "";
        }
        
    } else {
        return "";
    }
}															   

																	  
																	  
																	  
																	  
																	  
																	  
																	  
																	  
																	  
																	  

																	  
																	  
																	  
																	  
																	  
																	  
																	  
																	  
																	  
																	  
																	  
																	  
																	  
																	  