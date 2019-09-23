<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    // protected $fillable = [
    //     'title', 'description'
    // ];

    public function createItem(array $details) : self
    {
        $item = new self([
            'description' => $details['description'],
            'title' => $details['title']
        ]);
        $item->save();
        return $item;
    }
}
