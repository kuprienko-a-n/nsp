<?php
class NspXml extends \SimpleXMLElement{

    /*
     * @see http://www.php.net/manual/en/book.simplexml.php#105330
     */
    public static function xmlToJson($xmlstring){
        $xml = simplexml_load_string($xmlstring);
        return json_encode($xml);
    }

    /*
     * @see http://www.php.net/manual/en/book.simplexml.php#105330
     */
    public static function xmlToArray($xmlstring){
        return json_decode(self::xmlToJson($xmlstring), true);
    }

    /*
     * @see http://www.php.net/manual/en/book.simplexml.php#105330
     */
    public function toJson(){
        return json_encode($this);
    }

    /*
     * @see http://www.php.net/manual/en/book.simplexml.php#105330
     */
    public function toArray(){
        return json_decode($this->toJson(), true);
    }

    public static function  toXml($dataArray, &$xmlInfo = null, $parentTag = 'root' ){
        if(!isset($xmlInfo) || !($xmlInfo instanceof parent)){
            $xmlInfo = new parent("<?xml version=\"1.0\" encoding='UTF-8'?><{$parentTag}></{$parentTag}>");
        }
        foreach ($dataArray as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {//assoc
                    $subNode = $xmlInfo->addChild("$key");
                    self::toXml($value, $subNode);
                } else {
                    self::toXml($value, $xmlInfo);
                }
            } else {
                $xmlInfo->addChild("$key", "$value");
            }
        }

        return $xmlInfo;
    }

    public static  function  toXmlString($dataArray, $xmlInfo = null, $rootTag = 'root'){
        return self::toXml($dataArray, $xmlInfo, $rootTag)->asXML();
    }
}





// function defination to convert array to xml
function array_to_xml($student_info, &$xml_student_info) {
    foreach($student_info as $key => $value) {
        if(is_array($value)) {
            if(!is_numeric($key)){
                $subnode = $xml_student_info->addChild("$key");
                array_to_xml($value, $subnode);
            }
            else{
                array_to_xml($value, $xml_student_info);
            }
        }
        else {
            $xml_student_info->addChild("$key","$value");
        }
    }
}



?>

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/31/13
 * Time: 12:50 PM
 * To change this template use File | Settings | File Templates.
 */

$string = <<<XML
<?xml version='1.0'?>
<document>
    <cmd>login</cmd>
    <login>Richard</login>
</document>
XML;

$str2 = <<<XML
<?xml version='1.0'?>
<root>
    <store>
        <name>store1</name>
        <substore>
            <name>substore1</name>
        </substore>
    </store>
    <store>
        <name>store2</name>
        <substore>
            <name>substore2</name>
        </substore>
    </store>
</root>
XML;


$str4Xml = <<<XML
<?xml version='1.0'?>
<root>
    <store>
        <name>store1</name>
        <substore>
            <name>substore1</name>
        </substore>
    </store>
    <store>
        <name>store2</name>
        <substore>
            <name>substore2</name>
        </substore>
    </store>
</root>
XML;

$str3 = array(
    'store' => array(
        array(
            'name' => 'substore1',
            'substore' => array(
                'name' => 'substore1',
            ),
            'index' => 1,
        ),
        array(
            'name' => 'substore2',
            'substore' => array(
                'name' => 'substore2',
            ),
            'index' => 2,
        ),
    )
);

//$str = $string;
$str = $str2;
//
//var_dump(htmlentities($str) . '<hr>');
$xml = simplexml_load_string($str);
////print_r($xml);
$xmlJson = json_encode($xml);
////var_dump($xmlJson);
$xmlArray = json_decode($xmlJson);
//var_dump(json_decode($xmlJson));

//$login = $xml->login;
//print_r($login);
//$login = (string) $xml->login;
//print_r($login);//actual srting


var_dump($str3);
//$nspXml = NspXml::toXml($str3);
//var_dump($nspXml);
//var_dump(new \SimpleXMLElement($str4Xml));
$books = array(
    '@attributes' => array(
        'type' => 'fiction'
    ),
    'book' => array(
        array(
            '@attributes' => array(
                'author' => 'George Orwell'
            ),
            'title' => '1984'
        ),
        array(
            '@attributes' => array(
                'author' => 'Isaac Asimov'
            ),
            'title' => array('@cdata'=>'Foundation'),
            'price' => '$15.61'
        ),
        array(
            '@attributes' => array(
                'author' => 'Robert A Heinlein'
            ),
            'title' =>  array('@cdata'=>'Stranger in a Strange Land'),
            'price' => array(
                '@attributes' => array(
                    'discount' => '10%'
                ),
                '@value' => '$18.00'
            )
        )
    )
);

try{
    $xml = Array2XML::createXML('books', $str3);
    var_dump($xml->saveXML());

}catch(\Exception $e){
    var_dump($e->getMessage());
}


//$student_info = $str3;
//
//// creating object of SimpleXMLElement
//
//// function call to convert array to xml
//array_to_xml($student_info,$xml_student_info);

//saving generated xml file



?>