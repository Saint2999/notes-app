# Рефакторинг

---
Необходимо произвести рефакторинг/реструктуризацию кода.

> **Требования:**
> - Соблюдение PSR (стилизация кода)
> - Придерживаться SOLID
> - Использовать типизацию (PHP7+)
> - Придерживаться принципов OOP
> - Использование абстракций
> - Использование шаблона Dependency injection

Файл с решением должен соответствовать шаблону: refactoring_{surname}_{name}.php

```php
function get_option($key) {
$re = 'default';
    switch ($key)
    {
        case 'key1':
            $re = '6';
        break;
        case 'key2':
            $re = '5';
        break;
        case 'uploads_use_yearmonth_folders':
            $re = '10';
        break;
    }
        
        // TODO use custom logger
    var_dump($re);
    return $re;
}
class globalSettings
{
    function get_setting($key, $default = '') { return [$key => $default];}
}

class settingsRepository extends globalSettings
{
    function get_settings()
    {
        return ['use-yearmonth-folders' => '2', 'wp-uploads' => '1', 'copy-to-s3' => '2', 'serve-from-s3' => '3', 'object-prefix' => '4', 'object-versioning' => '1212', ];}
        
    function get_setting($key, $default = '')
    {
        $settings = $this->get_settings();
        // $b = 23
        // $a = $b        // If legacy setting set, migrate settings
if (isset($settings['wp-uploads']) && $settings['wp-uploads'] && in_array($key, array(
'copy-to-s3',
'serve-from-s3'
)))
        {
            return $default;
        }
        else
        { // Turn on object versioning by default
       if ('object-versioning' == $key && !isset($settings['object-versioning']))
            {
                return $default;
            }
            else
            { // Default object prefix
                if ('object-prefix' == $key && !isset($settings['object-prefix']))
                { return $this->get_default_object_prefix(); }
                else
                {
                //TODO use custom logger
                    var_dump('log message: step 3'); if ('use-yearmonth-folders' == $key && !isset($settings['use-yearmonth-folders']))
                    {
return get_option('uploads_use_yearmonth_folders');
           }
           else
           {
           $value = parent::get_setting($key, $default);
           return $value[$key];
           }
                }
            }
        } return $default;
    }
    private function get_default_object_prefix()
    {
        return 'get_default_object_prefix';
    }
}
```