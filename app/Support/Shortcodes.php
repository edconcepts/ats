<?php

namespace App\Support;

use App\Models\Application;
use Exception;

class Shortcodes
{
    private static array $shortcodes = [
        'naam_sollicitant' => 'name',
        'email_sollicitant' => 'email',
        'telefoon_sollicitant' => 'phone_number',
        'naam_vacature' => 'vacancy.title',
        'naam_filiaal' => 'vacancy.location.name',
        'adres_filiaal' => 'vacancy.location.location_address',
        'naam_filiaalmanager' => 'vacancy.location.manager.name',
        'datum_sollicitatie' => 'interview.storeManagerTimeSlot.start',
    ];

    /**
     * @throws Exception
     */
    public static function replaceShortcodes(Application $application, string $emailTemplate): string
    {
        foreach (static::$shortcodes as $shortcode => $field) {
            $value = static::resolveField($application, $field);
            $emailTemplate = str_replace("[$shortcode]", $value, $emailTemplate);
        }

        return $emailTemplate;
    }

    /**
     * @throws Exception
     */
    private static function resolveField(Application $application, string $field)
    {
        $value = $application;

        $parts = explode('.', $field);

        if(count($parts)>1){

            foreach ($parts as $part) {
                if(!isset($value->$part)){
                    $value = '';
                }
                else {
                    $value = $value->$part;
                }
            }
        }else{

            if(!isset($value->$field)){
                throw new Exception("Invalid field: $field");
            }
            $value = $value->$field;
        }

        return $value;
    }

    public static function getShortcodes(): array
    {
        return static::$shortcodes;
    }
}
