<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::table('room_types')->insert ([
            ['typename'=> '4-bedded',  'place_count'=> 4],
            ['typename'=> '6-bedded',  'place_count'=> 6],
            ['typename'=> '10-bedded', 'place_count'=> 10]
        ]);


        DB::table('rooms')->insert([
            ['number'=> '1', 'room_type_id'=> '1'],
            ['number'=> '2', 'room_type_id'=> '1'],
            ['number'=> '3', 'room_type_id'=> '2'],
            ['number'=> '4', 'room_type_id'=> '3']
        ]);

        DB::table('prices')->insert([
            ['room_type_id'=>1, 'month'=>1,  'price'=>160],
            ['room_type_id'=>1, 'month'=>2,  'price'=>140],
            ['room_type_id'=>1, 'month'=>3,  'price'=>140],
            ['room_type_id'=>1, 'month'=>4,  'price'=>140],
            ['room_type_id'=>1, 'month'=>5,  'price'=>160],
            ['room_type_id'=>1, 'month'=>6,  'price'=>160],
            ['room_type_id'=>1, 'month'=>7,  'price'=>160],
            ['room_type_id'=>1, 'month'=>8,  'price'=>160],
            ['room_type_id'=>1, 'month'=>9,  'price'=>160],
            ['room_type_id'=>1, 'month'=>10, 'price'=>140],
            ['room_type_id'=>1, 'month'=>11, 'price'=>140],
            ['room_type_id'=>1, 'month'=>12, 'price'=>160],
            ['room_type_id'=>2, 'month'=>1,  'price'=>150],
            ['room_type_id'=>2, 'month'=>2,  'price'=>130],
            ['room_type_id'=>2, 'month'=>3,  'price'=>130],
            ['room_type_id'=>2, 'month'=>4,  'price'=>130],
            ['room_type_id'=>2, 'month'=>5,  'price'=>150],
            ['room_type_id'=>2, 'month'=>6,  'price'=>150],
            ['room_type_id'=>2, 'month'=>7,  'price'=>150],
            ['room_type_id'=>2, 'month'=>8,  'price'=>150],
            ['room_type_id'=>2, 'month'=>9,  'price'=>150],
            ['room_type_id'=>2, 'month'=>10, 'price'=>130],
            ['room_type_id'=>2, 'month'=>11, 'price'=>130],
            ['room_type_id'=>2, 'month'=>12, 'price'=>150],
            ['room_type_id'=>3, 'month'=>1,  'price'=>140],
            ['room_type_id'=>3, 'month'=>2,  'price'=>120],
            ['room_type_id'=>3, 'month'=>3,  'price'=>120],
            ['room_type_id'=>3, 'month'=>4,  'price'=>120],
            ['room_type_id'=>3, 'month'=>5,  'price'=>140],
            ['room_type_id'=>3, 'month'=>6,  'price'=>140],
            ['room_type_id'=>3, 'month'=>7,  'price'=>140],
            ['room_type_id'=>3, 'month'=>8,  'price'=>140],
            ['room_type_id'=>3, 'month'=>9,  'price'=>140],
            ['room_type_id'=>3, 'month'=>10, 'price'=>120],
            ['room_type_id'=>3, 'month'=>11, 'price'=>120],
            ['room_type_id'=>3, 'month'=>12, 'price'=>120]
        ]);

        DB::table('places')->insert([ 
            ['number'=> 1, 'room_id'=>1],
            ['number'=> 2, 'room_id'=>1],
            ['number'=> 3, 'room_id'=>1],
            ['number'=> 4, 'room_id'=>1],
            ['number'=> 5, 'room_id'=>2],
            ['number'=> 6, 'room_id'=>2],
            ['number'=> 7, 'room_id'=>2],
            ['number'=> 8, 'room_id'=>2],
            ['number'=> 9, 'room_id'=>3],
            ['number'=> 10, 'room_id'=>3],
            ['number'=> 11, 'room_id'=>3],
            ['number'=> 12, 'room_id'=>3],
            ['number'=> 13, 'room_id'=>3],
            ['number'=> 14, 'room_id'=>3],
            ['number'=> 15, 'room_id'=>4],
            ['number'=> 16, 'room_id'=>4],
            ['number'=> 17, 'room_id'=>4],
            ['number'=> 18, 'room_id'=>4],
            ['number'=> 19, 'room_id'=>4],
            ['number'=> 20, 'room_id'=>4],
            ['number'=> 21, 'room_id'=>4],
            ['number'=> 22, 'room_id'=>4],
            ['number'=> 23, 'room_id'=>4],
            ['number'=> 24, 'room_id'=>4]
        ]);


        DB::table('orders')->insert(
            ['guest_FN'=> 'test', 'guest_LN'=> 'test', 'guest_email'=> 'test@gmail.com' ]
        );

        DB::table('bookings')->insert(['place_id'=> 5, 'date_in'=>new DateTime("2018/6/23"), 'date_out'=> new DateTime("2018/6/27"), 'order_id'=>1]);
    }
}
