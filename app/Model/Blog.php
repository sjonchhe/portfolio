<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    
 /*protected $fillable = [
        'title', 'blog', 'addedby','image','status','views',
    ];
*/
     public function user()
    {
      return $this->belongsTo('App\User','addedby');
    }

}
