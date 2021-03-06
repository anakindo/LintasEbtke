<?php

namespace App\Models;

use App\Models\BaseModel;

/**
 * Class Contact Us
 */

class ContactUs extends BaseModel
{
    protected $table = 'contact_us';

    public $timestamps = false;

    protected $fillable = [
        'fullname',
        'email',
        'question',
        'message'
    ];

    protected $guarded = [];

    /**
     * @param $query
     */
    public function scopeContactUsId($query, $params)
    {
        return $query->where('id', $params);
    }
}