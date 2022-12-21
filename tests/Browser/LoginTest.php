<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @test
     * @return void
     * @throws \Throwable
     */
    public function usuarios_sin_credenciales_pueden_ingresar_al_sistema(): void
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('admin/login')
                ->type('edgvega@gmail.com', 'email')
                ->dump();
        });
    }
}
