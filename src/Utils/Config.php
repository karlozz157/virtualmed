<?php
 
namespace Virtualmed\Utils;

class Config
{
    /**
     * @var array $fileContent
     */
    protected static $fileContent = [];

    /**
     * @return array
     */
    protected static function getFileContent()
    {
        if (static::$fileContent) {
            return static::$fileContent;
        }

        $configFile = __DIR__ . '/../../config/params.json';

        if (!file_exists($configFile)) {
            throw new \Exception(sprintf('The file %s doesn\'t exists', $configFile));
        }

        return static::$fileContent = json_decode(file_get_contents($configFile), true);
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public static function getParam($key)
    {
        $fileContent = static::getFileContent();

        if (!isset($fileContent[$key])) {
            throw new \Exception(sprintf('The %s key doesn\'t exist!', $key));
        }

        return $fileContent[$key];
    }
}
