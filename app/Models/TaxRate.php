<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    static public function get_data()
    {
        return Self::where('status', 1)->get();
    }
}
