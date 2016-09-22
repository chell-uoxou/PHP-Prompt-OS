<?php
namespace AutoLoader;

class AutoLoader
{
    protected $dirs;

    public function register()
    {
        spl_autoload_register(array($this, 'autoLoad'));
    }

    public function registerDir($dir, $parent=True)
    {
      if($parent){
        $this->dirs[] = $dir . $file;
      }
      $files = scandir($dir);
      //echo $dir . $file;
      $list = [];
      foreach($files as $file){
          if($file == '.' || $file == '..'){
              continue;
          } else if (is_file($dir .DIRECTORY_SEPARATOR. $file)){
              //require_once($dir . $file);
          } else if( is_dir($dir .DIRECTORY_SEPARATOR. $file) ) {
              $this->dirs[] = $dir .DIRECTORY_SEPARATOR. $file;
              $this->registerDir($dir .DIRECTORY_SEPARATOR. $file, False);
          }
        }
    }

    public function autoLoad($className)
    {

        $className = ltrim(strrchr( $className, "\\" ), '\\');
        foreach ($this->dirs as $dir) {
          echo $dir;
            $file = $dir .DIRECTORY_SEPARATOR. $className . '.php';
            if (is_file($file)) {
                require $file;
                echo 'LOADED: '.$file;
                return;
            }
        }
    }
}
