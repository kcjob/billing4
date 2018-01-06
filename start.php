<?php
require_once(__DIR__ .'/vendor/autoload.php');

use \Apps\DBConnect;
use \Apps\UserNamesDAO;
use \Apps\EquipmentUseDAO;
use \Apps\EquipmentUseDetails;
use \Apps\EmailMessageGenerator;
use \Apps\TemplateView;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('bills');
$dbStream = new StreamHandler('data/billing.log', Logger::ERROR);
$log->pushHandler($dbStream);

try {
    $connection = DBConnect::getConnection();
} catch (Exception $e) {
    $log->error($e->getMessage());
    echo "Problem connecting to the database\r\n";
    die();
}

try {
    $userNamesArray = UserNamesDAO::getUserNames($connection);
} catch (Exception $e) {
    $log->error($e->getMessage());
    echo "Problem retrieving names from database\r\n";
    die();
}

foreach($userNamesArray as $name){
    try {
        $useDetailsObject = EquipmentUseDAO::getEquipmentUseDetails($connection, $name);
    } catch (Exception $e) {
        $log->error($e->getMessage());
        echo "Problem retrieving data from database\r\n";
        die();
    }

    try{
        EmailMessageGenerator::createEmail($useDetailsObject);
    } catch(Exception $e){
        $log->error($e->getMessage());
        echo "Could not generate email message\r\n";
        die();
    }


    //print_r($useDetailsObject);

    //echo '***************************' . "\r\n";
    //echo '*CONFIGURE AND SEND EMAIL *' . "\r\n";
    //echo 'ß**************************' . "\r\n";


}
