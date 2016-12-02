<?php

use Illuminate\Database\Seeder;
use \App\Folder;

class FoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $folder= new Folder;
        $folder->name='Sample Folder';
        $folder->save();
    }
}
