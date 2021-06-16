<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Fundraising_requests extends Model{
    protected $fillable = [
		'user_id', 'submission_id', 'reason',
		'amount', 'expense_report', 'status', 'created_at', 'status_updated_by',
	];
	
    protected $hidden = [
        
    ];

    protected $casts = [
        
    ];
}
