<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Submissions extends Model {
	
    protected $fillable = [
		'title', 'description', 'images',
		'user_id', 'where', 'why', 'what',
		'how', 'who', 'approved_by', 'status',
		'doc_id', 'fundraising_goal',
		'proposed_budget', 'budget_sheet','tip_enable',
	];
	
    protected $table = 'submissions';

    public static function updateSubmission($request) {                
        if (!empty($request)) {
            $Submissions = self::find($request['sid']);
            $Submissions->title = filter_var($request['title'], FILTER_SANITIZE_STRING);
            $Submissions->description = filter_var($request['description'], FILTER_SANITIZE_STRING);
            $Submissions->save();
        }
    }

}
