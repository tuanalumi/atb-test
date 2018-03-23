<?php

require_once 'vendor/autoload.php';

$faker = Faker\Factory::create();

$noOfUsers = $_GET['no'] ?? 10;

$query = new \Lib\Query();

for ($i = 0; $i < $noOfUsers; $i++) {
    try {
        $data = [
            ':email'    => $faker->email,
            ':password' => password_hash('123456', PASSWORD_DEFAULT),
            ':name'     => $faker->name,
            ':address'  => $faker->address,
            ':tel'      => $faker->e164PhoneNumber,
            ':age'      => $faker->randomDigitNotNull
        ];

        $query->query(
            "INSERT INTO user (email, password, name, address, tel, age) 
        VALUE(:email, :password, :name, :address, :tel, :age)",
            $data
        );

        echo 'Inserted.';
    } catch (\Exception $exception) {
        echo $exception->getMessage();
    }

}

echo 'Done.';
