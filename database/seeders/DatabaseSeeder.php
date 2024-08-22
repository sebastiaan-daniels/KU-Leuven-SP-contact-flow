<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\table;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('types')->insert(
            [
                // Types here
                [
                    'type' => 'standard',
                    'active' => true
                ],
                [
                    'type' => 'question',
                    'active' => true
                ]
            ]
        );

        DB::table('users')->insert(
            [
                // users here
                [
                    'name' => 'admin',
                    'email' => 'admin@admin.dev',
                    'password' => Hash::make('Admin1234'),
                    'active' => true,
                    'admin' => true
                ],
                [
                    'name' => 'user',
                    'email' => 'user@user.dev',
                    'password' => Hash::make('User1234'),
                    'active' => true,
                    'admin' => false
                ]

            ]
        );

        DB::table('parameters')->insert(
            [
                // parameters here
                /*
                Deze parameters zijn handig wanneer je een klant vraagt om u/r/b/g nummer
                Elke parameter (b,r,u, of geen) zal linken naar een QuestionID.

                Indien de klant bv u0123456 ingeeft, zal die naar bv vraag 4 gaan
                een student naar 5, etc...
                */
                [
                    'key'=>'r',
                    'value'=>null,
                    'active' => true
                ],
                [
                    'key'=>'u',
                    'value'=>null,
                    'active' => true
                ],
                [
                    'key'=>'b',
                    'value'=>null,
                    'active' => true
                ],
                [
                    'key'=>'c',
                    'value'=>null,
                    'active' => true
                ],
                [
                    'key'=>'g',
                    'value'=>null,
                    'active' => true
                ],
                [
                    'key'=>'s',
                    'value'=>null,
                    'active' => true
                ],
                [
                    'key'=>'q',
                    'value'=>null,
                    'active' => true
                ]

            ]
        );

        DB::table('contacts')->insert(
            [
                // contacts here
                /*
                 * $table->string('name');
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('active');*/
                // DEFAULTS
                //ICTS
                [
                    'name'=>'KU Leuven ICTS Servicepunt',
                    'email'=>'icts@kuleuven.be',
                    'phone'=>'+32 16 32 28 00',
                    'logo'=>null,
                    'website'=>'https://admin.kuleuven.be/icts/servicepunt',
                    'active'=>true
                ],
                //Studentenadministratie
                [
                    'name'=>'KU Leuven Studentenadministratie',
                    'email'=>'reg@kuleuven.be',
                    'phone'=>'+32 16 32 40 40',
                    'logo'=>null,
                    'website'=>'https://associatie.kuleuven.be/support/sa',
                    'active'=>true
                ],
                //personeelsdienst
                [
                    'name'=>'KU Leuven Personeelsdienst',
                    'email'=>'personeelsdienst@kuleuven.be',
                    'phone'=>'+32 16 32 83 00',
                    'logo'=>null,
                    'website'=>'https://admin.kuleuven.be/personeel/wegbeschrijving.html',
                    'active'=>true
                ]
            ]
        );

        DB::table('questions')->insert(
            [
                // questions here
                // Niet aanpassen in de seeder bij Production!
            ]
        );
    }
}
