<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TabTemplate extends Model
{
    public $table = "tabtemplate";
    protected $fillable = [
        'id', 'baku', 'kolom', 'judul', 'title', 'sumber','source','subbab'
    ];
    public $timestamps = false;
}
