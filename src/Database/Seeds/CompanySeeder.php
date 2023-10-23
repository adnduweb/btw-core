<?php

namespace Btw\Core\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Btw\Core\Models\CompanyModel;
use Faker\Factory;
use Ramsey\Uuid\Uuid;

class CompanySeeder extends Seeder
{
    /**
     * Seed the application's database.
     * php spark db:seed Btw\\Core\\Database\\Seeds\\CompanySeeder
     *
     * @return void
     */
    public function run()
    {

        if (count(model(CompanyModel::class)->findAll())) {
            return;
        }

        $faker = Factory::create('fr_FR');
        $myuuid = Uuid::uuid4();
        $this->db->table('companies')->insert([
            'id' => 1,
            'uuid' => $myuuid,
            'code_company' => 'company_' . passwdGen(8),
            'country' => 'FR',
            'state' => '',
            'currency_code' => 3,
            'company' => $faker->userName,
            'lastname' => $faker->lastName,
            'firstname' => $faker->firstNameMale,
            'email' => $faker->email,
            'address1' => $faker->streetAddress,
            'address2' => '',
            'postcode' => $faker->postcode,
            'city' => $faker->city,
            'phone' => $faker->phoneNumber,
            'phone_mobile' => '',
            'vat_number' => $faker->vat(),
            'siret' => $faker->siret,
            'ape' => 'ze45612',
            'active' => 1,
            'order' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
