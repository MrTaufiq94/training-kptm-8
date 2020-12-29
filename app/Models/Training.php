<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Training extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable; //kene tambah '\' kerana x define atas
    
    protected $fillable = ['title', 'description', 'trainer', 'attachment'];
    // one training belongs to a user -FK
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    //getter $training->attachment_url
    //dari getAttachmentUrlAttribute (paskal case) kepada ini attachment_url (snake case) 
    public function getAttachmentUrlAttribute(){
        //kita guna $this kerana atrribute itu belong kepada function ini
        if($this->attachment){
            return asset('storage/'.$this->attachment);
        }else{
            return 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fpngtree.com%2Fso%2Fuser&psig=AOvVaw0tN7ArEP2a3Jtc9eotu5uQ&ust=1608696918061000&source=images&cd=vfe&ved=0CAIQjRxqFwoTCNi3mpXd4O0CFQAAAAAdAAAAABAD';
        }
    }
        
}
