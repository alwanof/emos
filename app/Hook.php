<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hook extends Model
{
    protected $fillable = [
        'category_id', 'user_id','ref'
    ];
    protected $appends = ['operator', 'cat'];

    public function getCatAttribute(){

        return Category::find($this->category_id)->name;

    }
    public function getOperatorAttribute(){
        return User::find($this->user_id)->name;
    }
}
