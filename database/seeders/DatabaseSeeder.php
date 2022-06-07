<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyItem;
use App\Models\SearchProfile;
use App\Models\SearchProfileItem;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $sample_data = [
            'name' => $faker->name(),
            'propertyType' => $faker->regexify('[_A-Za-z0-9]{20}'),
        ];
        $property_object = Property::create(array_merge($sample_data, [
            'address' => $faker->address()
        ]));
        $profile_object = SearchProfile::create(array_merge($sample_data, [
            'returnActual' => ["15", null]
        ]));

        PropertyItem::create([
            "area" => "180",
            "yearOfConstruction" => "2010",
            "rooms" => "5",
            "heatingType" => "gas",
            "parking" => $faker->boolean(),
            "returnActual" => "12.8",
            "price" => "1500000",
            "propertyId" => $property_object->id
        ]);
        SearchProfileItem::create([
            "price" => ["0", "2000000"],
            "area" => ["150", null],
            "yearOfConstruction" => ["2010", null],
            "rooms" => ["4", null],
            "searchProfileId" => $profile_object->id
        ]);
    }
}
