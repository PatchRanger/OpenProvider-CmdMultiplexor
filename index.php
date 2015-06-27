<?php

// @todo Split into separate files compound together with Composer autoloading via namespaces.
/**
 * Original class of command.
 */
class Cmd {
  private $count = 0;
  public function getCount()
  {
    return $this->count;
  }
  public function setCount($v)
  {
    $this->count = $v;
  }
  public function increment()
  {
    return ++$this->count;
  }
}

/**
 * Singleton pattern.
 * @link https://en.wikipedia.org/wiki/Singleton_pattern
 */
trait Singleton {
  static private $instance;

  private function __construct() { /* ... @return Singleton */ }  // Protect from creation through new.
  private function __clone() { /* ... @return Singleton */ }  // Protect from creation through clone.
  private function __wakeup() { /* ... @return Singleton */ }  // Protect from creation through unserialize.

  public static function getInstance() {
    if (empty(static::$instance)) {
      static::$instance = static::_getInstance();
    }
    return static::$instance;
  }

  protected static function _getInstance() {
    return new static();
  }
}

/**
 * Singleton implementation persistent over requests for session.
 */
trait SingletonPersistent {
  use Singleton {
    _getInstance as getSingleton;
  }

  protected static function _getInstance() {
    $className = get_called_class();
    if (empty($_SESSION[$className])) {
      $_SESSION[$className] = serialize(static::getSingleton());
    }
    return unserialize($_SESSION[$className]);
  }

  public function __destruct() {
    // Store the state in the session.
    $className = get_called_class();
    $_SESSION[$className] = serialize($this);
  }
}

class CmdContainer {
  use SingletonPersistent;

  /**
   * @var Cmd[]
  */
  private $cmds = [];

  /**
   * @return Cmd
   */
  public function getCmd($index) {
    if (empty($this->cmds[$index])) {
      $this->cmds[$index] = new Cmd();
    }
    return $this->cmds[$index];
  }
}

session_id('cmd-multiplexor');
session_name('cmd-multiplexor');
session_start();

// Parse out the index from GET.
$matches = array();
$index = (($path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
  && preg_match('/cmd(\d+)/i', $path, $matches))
  ? $matches[1]
  : 0;
echo CmdContainer::getInstance()->getCmd($index)->increment();
