<?php

namespace App\Providers;

use App\Models\MailSettings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config as Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $mailSettings=MailSettings::first();
            if($mailSettings){
                $data=[
                    'transport'  => $mailSettings->MAIL_MAILER,
                    'host'       => $mailSettings->MAIL_HOST,
                    'port'       =>$mailSettings->MAIL_PORT,
                    'encryption' =>$mailSettings->MAIL_ENCRYPTION,
                    'username'   =>$mailSettings->MAIL_USERNAME,
                    'password'   =>$mailSettings->MAIL_PASSWORD,
                    'from'      =>[
                        'address'=>$mailSettings->MAIL_FROM_ADDRESS,
                        'name' => 'Test Management',

                    ]
               ];

               Config::set('mail.mailers.smtp', $data);
            }


    }

}
