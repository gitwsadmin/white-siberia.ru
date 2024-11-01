<?

namespace Itconstruct;

final class Application 
{
    private static $instance = null;
    private static $autoLoadFiles = false;
	
    public static function initializeApp($splMode = false)
    {
        self::$autoLoadFiles = $splMode;
		if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct()
    {
        if (self::$autoLoadFiles) {
            $this->loadFiles();
        }
		
        $this->registerAppEvents();
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
	
    private function loadFiles() 
    {
        $files = $this->scanConfigs();
        foreach ($files as $file) {
            require_once($file);
        }
    }
	
    private function registerAppEvents() 
    {
        $files = $this->scanEvents();
        $baseDir = explode('/', __DIR__);
        $baseDir = ucfirst(array_pop($baseDir));
        
        foreach ($files as $file) {
            $className = $baseDir.str_replace(".php", "", str_replace("/", "\\", str_replace(__DIR__, '', $file)));
            if (method_exists($className, 'registerEvents')) {
                $events = $className::loadEvents();
            }
        }
    }
	
    private function scanConfigs()
    {
        $eventFiles = [];
        $it = new \RecursiveDirectoryIterator(__DIR__."/Configs", \RecursiveDirectoryIterator::SKIP_DOTS);

        foreach(new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST) as $file) {
            $eventFiles[] = $file->getPathname();
        }

        return $eventFiles;
    }
	
    private function scanEvents() 
    {
        $eventFiles = [];
        $it = new \RecursiveDirectoryIterator(__DIR__);

        foreach(new \RecursiveIteratorIterator($it) as $file) {
            if ($file->getBasename() == 'Events.php') {
                $eventFiles[] = $file->getPathname();
            }			
        }

        return $eventFiles;
    }
}