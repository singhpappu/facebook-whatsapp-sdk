<?php
return [
    /**
     * Meta graph api app version 
     */
    'meta_app_version' => env('META_APP_VERSION', 'v14.0'),

    /**
     * Whatsapp phone number id to authenticate the app, you will get it from meta apps.  
     */
    'phone_number_id' => env("WHATSAPP_PHONE_NUMBER_ID", null),

     /**
     * Whatsapp access token, in development mode the token will expire in 23 hrs.
     */
    'token' => env("WHATSAPP_ACCESS_TOKEN", null)

];