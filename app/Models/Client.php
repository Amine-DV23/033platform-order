<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = 'clients';


    protected $fillable = ['name', 'address', 'phone', 'note'];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public $timestamps = true;

}
