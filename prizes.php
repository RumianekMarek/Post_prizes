<?php
//Required data
require_once('dane.php');
$tableName = 'post_codes';
$prize_data = fetch_data($tableName);

// Function to display the prizes
function prize_table($prize_data){
    if($prize_data){
    $output = '
        <div>
            <a href="index.php">Calculator</a>
            <table style="border: 1px black solid">
                <tbody>
                    <tr>
                        <td style="border: 1px black solid; padding:2px 10px; text-align:center;">ORDER ZONE</td>
                        <td style="border: 1px black solid; padding:2px 10px; text-align:center;"">PRIZES</td>
                    </tr>';
                foreach($prize_data as $key){
                    $output .= '
                    <tr>
                        <td style="border: 1px black solid; padding:2px 10px; text-align:center;">'.$key["zone_number"].'</td>
                        <td style="border: 1px black solid; padding:2px 20px; text-align:center;"">'.$key["price"].'</td>
                    </tr>';
                }
                $output .= '
                </tbody>
            </table>
        </div>
    ';

    return $output;
    } else {
        echo '<p>Prices havent beean asinged to regions yet</p>';
    }

}

echo prize_table($prize_data);