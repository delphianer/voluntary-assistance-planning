<?php
declare(strict_types=1);

namespace Vokuro;

use Phalcon\Di;
use Phalcon\Di\DiInterface;

/**
 * Call Dependency Injection container
 *
 * @return mixed|null|DiInterface
 */
function container()
{
    $default = Di::getDefault();
    $args    = func_get_args();
    if (empty($args)) {
        return $default;
    }

    return call_user_func_array([$default, 'get'], $args);
}

/**
 * Get projects relative root path
 *
 * @param string $prefix
 *
 * @return string
 */
function root_path(string $prefix = ''): string
{
    /** @var Application $application */
    $application = container(Application::APPLICATION_PROVIDER);

    return join(DIRECTORY_SEPARATOR, [$application->getRootPath(), ltrim($prefix, DIRECTORY_SEPARATOR)]);
}

/**
 * @return string
 */
function getCurrentDateTimeStamp()
{
    return date("Y-m-d H:i:s");
}


/**
 * @return string
 */
function translateFromYesNo(string $yes)
{
    return ($yes == 'Yes') ? 'Y' : 'N';
}

/**
 * @return string
 */
function translateToYesNo(string $yes)
{
    return ($yes == 'Y') ? 'Yes' : 'No';
}

trait DateTimePicker
{
    public function setupDateTimePicker()
    {
        $this->assets->collection("js")->addJs("/js/jquery.datetimepicker.full.min.js", true, true);
        $this->assets->collection("css")->addCss("/css/jquery.datetimepicker.min.css", true, true);
        $this->assets->collection("js")->addJs("/js/activateControlls.js", true, true);
    }
}

trait MyTimestampable
{
    public function beforeCreate()
    {
        $this->created_at = date('r');
    }

    public function beforeUpdate()
    {
        $this->updated_at = date('r');
    }
}
