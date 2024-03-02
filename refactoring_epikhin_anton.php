<?php

class Helper 
{
    public function getOption(string $key): string
    {
        $option = match($key) {
            'key1' => '6',
            'key2' => '5',
            'uploads_use_yearmonth_folders' => '10',
            default => 'default'
        };
    
        // TODO use custom logger
        var_dump($option);
    
        return $option;
    }
}

abstract class GlobalSettings
{
    abstract public function getSetting(string $key, string $default = ''): string;
}

class SettingsRepository extends GlobalSettings
{
    private $helper;

    private $defaultObjectPrefix = 'default_object_prefix';

    private $settings = [
        'use-yearmonth-folders' => '2',
        'wp-uploads' => '1',
        'copy-to-s3' => '2',
        'serve-from-s3' => '3',
        'object-prefix' => '4',
        'object-versioning' => '1212'
    ];

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function __construct(Helper $helper) 
    {
        $this->helper = $helper;
    }

    public function getSetting(string $key, string $default = ''): string
    {
        $settings = $this->settings;

        // If legacy setting set, migrate settings
        if (
            isset($settings['wp-uploads']) &&
            $settings['wp-uploads'] &&
            in_array(
                $key,
                array(
                    'copy-to-s3',
                    'serve-from-s3'
                )
            )
        ) {
            return $default;
        } 

        // Turn on object versioning by default
        if (
            !isset($settings['object-versioning']) &&
            $key == 'object-versioning'
        ) {
            return $default;
        }

        // Default object prefix
        if (
            !isset($settings['object-prefix']) &&
            $key == 'object-prefix'
        ) {
            return $this->defaultObjectPrefix;
        }

        //TODO use custom logger
        var_dump('log message: step 3');

        if (
            !isset($settings['use-yearmonth-folders']) &&
            $key == 'use-yearmonth-folders'
        ) {
            return $this->helper->getOption('uploads_use_yearmonth_folders');
        }

        return $default;
    }
}