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
            ]
        );

        DB::table('users')->insert(
            [
                // users here
            ]
        );

        DB::table('parameters')->insert(
            [
                // parameters here
            ]
        );

        DB::table('contacts')->insert(
            [
                // contacts here
                // DEFAULTS
                //ICTS
                //Studentenadministratie
                //personeelsdienst
            ]
        );

        DB::table('questions')->insert(
            [
                // questions here
            ]
        );
    }
}
