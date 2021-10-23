<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\ChatBot;

class ImportCommands implements ToModel, WithHeadingRow
{
   

/**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ChatBot([
          'chat_command' => $row['command'],
          'chat_response' => $row['description'],
        ]);
    }








}
