<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Pitches extends Model{
    protected $fillable = [
		'title', 'description', 'images', 'proposed_budget', 'budget_sheet',
		'user_id', 'where', 'why', 'what', 'how', 'who',
		'rel_link_1', 'rel_link_2', 'rel_link_3', 'approved_by',
	];
	
    protected $hidden = [
        
    ];

    protected $casts = [
        
    ];
}
