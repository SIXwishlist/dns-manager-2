<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Hash;
use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\Filesystem as Flysystem;
use Illuminate\Support\Arr;
use Storage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('record_value', function ($attribute, $value, $parameters, $validator) {
            return true;
        });

        Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {
            $oldPassword = $parameters[0];

            if (!$oldPassword) {
                return true;
            }

            return Hash::check($value, $oldPassword);
        });

        Validator::replacer('record_value', function ($message, $attribute, $rule, $parameters) {
            return 'Giá trị của bản ghi không hợp lệ';
        });

        Validator::replacer('old_password', function ($message, $attribute, $rule, $parameters) {
            return 'Mật khẩu cũ không chính xác';
        });

        Storage::extend('sftp', function ($app, $config) {
            $config2 = Arr::only($config, ['visibility', 'disable_asserts', 'url']);

            $adapter = new SftpAdapter($config);

            return new Flysystem($adapter, count($config2) > 0 ? $config2 : null);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
