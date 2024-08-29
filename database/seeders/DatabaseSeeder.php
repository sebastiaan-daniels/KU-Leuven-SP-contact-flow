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
                    'description'=>'Voor algemene vragen kan je het ICTS Servicepunt contacteren',
                    'email'=>'https://www.kuleuven.be/wieiswie/nl/person/ue707990',
                    'phone'=>'+32 16 32 28 00',
                    'logo'=>null,
                    'website'=>'https://admin.kuleuven.be/icts/servicepunt',
                    'active'=>true
                ],
                //Studentenadministratie
                [
                    'name'=>'KU Leuven Studentenadministratie',
                    'description'=>'Voor al je administratieve vragen als student, contacteer je best de Studentenadministratie
                    . Wij zijn de IT dienst en kunnen je hier niet bij helpen.',
                    'email'=>'https://www.kuleuven.be/wieiswie/nl/person/ue706877',
                    'phone'=>'+32 16 32 40 40',
                    'logo'=>null,
                    'website'=>'https://associatie.kuleuven.be/support/sa',
                    'active'=>true
                ],
                //personeelsdienst
                [
                    'name'=>'KU Leuven Personeelsdienst',
                    'description'=>'Voor al je administratieve vragen als medewerker, contacteer je best de Personeelsdienst
                    . Wij zijn de IT dienst en kunnen je hier niet bij helpen.',
                    'email'=>'https://www.kuleuven.be/wieiswie/nl/person/ue707101',
                    'phone'=>'+32 16 32 83 00',
                    'logo'=>null,
                    'website'=>'https://admin.kuleuven.be/personeel/wegbeschrijving.html',
                    'active'=>true
                ],
                // studiegelden
                [
                    'name'=>'KU Leuven Studiegelden',
                    'description'=>'Voor al je financiële vragen als student, contacteer je best de dienst Studiegelden
                    . Wij zijn de IT dienst en kunnen je hier niet bij helpen.',
                    'email'=>'https://www.kuleuven.be/wieiswie/nl/person/ue707174',
                    'phone'=>'+32 16 32 37 70',
                    'logo'=>null,
                    'website'=>'https://www.kuleuven.be/onderwijs/student/studiegelden',
                    'active'=>true
                ]
            ]
        );

        DB::table('questions')->insert(
            [
                // questions here
                // Niet aanpassen in de seeder bij Production!
                // Onderstaande vragen zijn voor testing!
                [
                    'type_id'=>1,
                    'contact_id'=>null,
                    'name'=>'START CONTACT FLOW',
                    'child_question'=>'Wat voor type ben je?',
                    'parent_id'=>null,
                    'active'=>true
                ],
                [
                    'type_id'=>1,
                    'contact_id'=>1,
                    'name'=>'Medewerker',
                    'child_question'=>null,
                    'parent_id'=>1,
                    'active'=>true
                ],
                [
                    'type_id'=>1,
                    'contact_id'=>null,
                    'name'=>'Student',
                    'child_question'=>'Wat is je probleem?',
                    'parent_id'=>1,
                    'active'=>true
                ],
                [
                    'type_id'=>1,
                    'contact_id'=>null,
                    'name'=>'Toekomstige student',
                    'child_question'=>'Wat is je probleem?',
                    'parent_id'=>1,
                    'active'=>true
                ],
                [
                    'type_id'=>1,
                    'contact_id'=>1,
                    'name'=>'ICT vraag',
                    'child_question'=>null,
                    'parent_id'=>3,
                    'active'=>true
                ],
                [
                    'type_id'=>1,
                    'contact_id'=>2,
                    'name'=>'Jobstudenten vraag',
                    'child_question'=>null,
                    'parent_id'=>3,
                    'active'=>true
                ],
                [
                    'type_id'=>1,
                    'contact_id'=>1,
                    'name'=>'Ik kan niet inloggen op Toledo',
                    'child_question'=>null,
                    'parent_id'=>4,
                    'active'=>true
                ],
                [
                    'type_id'=>1,
                    'contact_id'=>4,
                    'name'=>'Ik heb een financiële vraag',
                    'child_question'=>null,
                    'parent_id'=>4,
                    'active'=>true
                ],
                [
                    'type_id'=>1,
                    'contact_id'=>1,
                    'name'=>'Iets anders',
                    'child_question'=>null,
                    'parent_id'=>4,
                    'active'=>true
                ],

            ]
        );
    }
}
