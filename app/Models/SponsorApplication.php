<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SponsorApplication extends Model
{
    protected $fillable = [
        'organisation', 'contact_name', 'email', 'phone',
        'website_url', 'tier', 'message', 'logo_path', 'status',
    ];
}
