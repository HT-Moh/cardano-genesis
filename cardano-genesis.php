<?php
/*
Plugin Name: Koios REST API Tip Plugin
*/

function koios_rest_api_tip() {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.koios.rest/api/v0/tip",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "accept: application/json"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $response_array = json_decode($response, true);
        if (is_array($response_array)) {
            echo "<ul>";
            foreach ($response_array as $block_summary) {
                echo "<li>Hash: " . $block_summary['hash'] . "</li>";
                echo "<li>Epoch Number: " . $block_summary['epoch_no'] . "</li>";
                echo "<li>Absolute Slot Number: " . $block_summary['abs_slot'] . "</li>";
                echo "<li>Slot Number in Epoch: " . $block_summary['epoch_slot'] . "</li>";
                echo "<li>Block Height: " . $block_summary['block_no'] . "</li>";
                echo "<li>Block Time: " . date('Y-m-d H:i:s', $block_summary['block_time']) . "</li>";
            }
            echo "</ul>";
        }
    }
}

add_shortcode('koios_tip', 'koios_rest_api_tip');
