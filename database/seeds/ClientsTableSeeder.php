<?php

use Illuminate\Database\Seeder;
use App\Domains\Clients\Client;
class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Client::class, 10)->create();

        DB::table('clients')->insert([
            'name' => str_random(10),
            'email' => str_random(10).'@gmail.com'
        ]);
    }
}
