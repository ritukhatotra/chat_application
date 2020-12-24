<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $primaryKey = "id";

    protected $table = 'chats';
    protected $fillable = ['sender_id', 'receiver_id', 'message', 'timestamp', 'status', 'is_delete_id_user_first', 'is_delete_id_user_second', 'created_at', 'updated_at'];

}