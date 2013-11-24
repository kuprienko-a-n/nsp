<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andrei_Kuprienka
 * Date: 5/20/13
 * Time: 6:00 AM
 * To change this template use File | Settings | File Templates.
 */

class SplClassLoader{

  private $_fileExtension = 'php';
  private $_includePath = 'inc';
  private $_namespaceSeparator = '\\';

  public function __construct($ext = NULL, $incPath = NULL){
    if($ext){
      $this->_fileExtension = $ext;
    }

    if($incPath){
      $this->_includePath = $incPath;
    }
  }

  public function getNamespaceSeparator() {
    return $this->_namespaceSeparator;
  }

  public function setNamespaceSeparator($namespaceSeparator) {
    $this->_namespaceSeparator = $namespaceSeparator;
  }

  public function setIncludePath($path){
    return $this->_includePath = $path;
  }

  public function getIncludePath(){
    return $this->_includePath;
  }

  /**
   * @param $ext
   */
  public function setFileExtension($ext){
    $this->_fileExtension = $ext;
  }

  /**
   * @param $ext
   */
  public function getFileExtension($ext){
    return $this->_fileExtension;
  }

  /**
   * Register class
   */
  public function register(){
    spl_autoload_register(array($this, 'loadClass'));
  }

  /**
   * Unregister class
   */
  public function unregister(){
    spl_autoload_unregister(array($this, 'loadClass'));
  }

  /**
   * Load class
   */
  public function loadClass($className){
      list($vendor, $namespace, $class) = explode($this->_namespaceSeparator, $className);

      if ($vendor && $namespace && $class) {
          require $this->_includePath
              . DIRECTORY_SEPARATOR
              . $vendor
              . DIRECTORY_SEPARATOR
              . $namespace
              . DIRECTORY_SEPARATOR
              . $class
              . '.' . $this->_fileExtension;
      }
  }

}

$loader = new  SplClassLoader();
$loader->register();