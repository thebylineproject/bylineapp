<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class White_labels extends Model{
    protected $fillable = [
		'publisher_name', 'description', 'logo', 'created_by',
		'physical_address', 'publisher_website', 'status',
		'address_1', 'address_2', 'city', 'state', 'zip',
		'contact_email', 'contact_info', 'created_at', 'google_email',
	];
		
    protected $hidden = [
        
    ];

    protected $casts = [
        
    ];
}
