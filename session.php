<?php
//ob_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
//ini_set('session.save_handler', 'user');

//ob_start(function($buffer){
////        return nl2br($buffer);
//    });
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/23/13
 * Time: 5:13 AM
 * To change this template use File | Settings | File Templates.
 */

define('NSP_ROOT', __DIR__);
include_once 'autoloadClass.php';

$appl = new \Vendor\Application\Application();

$appl->run();

//session_regenerate_id();

//$appl->getSession()->write(uniqid(), 'testdata');
//session_regenerate_id(true);
echo 'user session name: ' . session_id() . '<br>';
//\Vendor\ISession\ServiceSqliteSessionData::createTables();
//if (isset($_SESSION['counter'])) {
//    $_SESSION['counter'] = 1;
//} else {
//    $_SESSION['counter']++;
//}
$_SESSION['new_info'] = 'sadd';
//$_SESSION['new'] = array(1,2,3,4);
var_dump($_SESSION);
//var_dump($_SESSION);
//var_dump(ini_get('session.save_handler'));
//var_dump($_SESSION);
//\Vendor\ISession\ServiceSqliteSessionData::removeAll();

//$sessions = \Vendor\Session\ServiceSqliteSessionData::getAllSessions();
//$userSession = \Vendor\Session\ServiceSqliteSessionData::getBySessionId(session_id(), NULL);

//$sessions = \Vendor\Session\ServiceMongodbSessionData::getAllSessions();
//$userSession = \Vendor\Session\ServiceMongodbSessionData::getBySessionId(session_id(), NULL);
//var_dump($userSession);

//$sessions = \Vendor\Session\ServiceApcSessionData::getAllSessions();
////var_dump($sessions);die;
//$userSession = \Vendor\Session\ServiceApcSessionData::getBySessionId(session_id(), NULL);

$sessions = \Vendor\Session\ServiceMemcacheSessionData::getAllSessions();
$userSession = \Vendor\Session\ServiceMemcacheSessionData::getBySessionId(session_id(), NULL);

?>

<style>
    table td{
        padding:5px;
    }
</style>
    <hr>
<caption>User session</caption>
<table border=1>
    <thead>
        <th>Name</th>
        <th>Data</th>
        <th>Time</th>
    </thead>
    <tbody>
    <tr >
        <td><?php echo !empty($userSession['_id']) ? $userSession['_id'] : $userSession['name']; ?></td>
        <td><?php echo $userSession['data']; ?></td>
        <td><?php echo $userSession['time']; ?></td>
    </tr>
    </tbody>
</table>
<caption>All sesions</caption>
<table border=1>
    <thead>
    <th>Id</th>
    <th>Name</th>
    <th>Data</th>
    <th>Time</th>
    </thead>
<?php foreach ($sessions as $key => $row): ?>
    <tbody>
    <tr >
        <td><?php echo $key; ?></td>
        <td><?php echo !empty($row['_id']) ? $row['_id'] : $row['name']; ?></td>
        <td><?php echo $row['data']; ?></td>
        <td><?php echo $row['time']; ?></td>
    </tr>
    </tbody>
<?php endforeach; ?>
</table>

<?php
//ob_end_flush();

?>



