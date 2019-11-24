<?php
// app/Providers/ToolsServiceProvider.php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Xml\xmlapi;
class ToolsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('xmlapi', function () {
            return new xmlapi;
        });
    }
}