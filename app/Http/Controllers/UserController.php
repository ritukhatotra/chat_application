<?php
namespace App\Http\Controllers;

use App\User;
use App\Chat;
use DB;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');        
    }
    
    public function index() {
        $data['title'] = 'Chat Application | User';
        $data['users'] = User::where('id', '!=', Auth::user()->id)->get();
        $data['latest_chat'] = Chat::where('sender_id', Auth()->user()->id)->orderBy('id', 'desc')->get();
        return view('user.dashboard', $data);
    }

    public function logout() {
        Auth::logout();
        return redirect('login');
    }

    /* get user chat by id */
    public function userChat(Request $request) {
        $input = $request->all();
        $user = User::find($input['user_id']);
        $current_timestamp = strtotime(date('Y-m-d H:i:s'));
        $before_five_min = date("Y-m-d H:i:s", strtotime('-5 minutes', $current_timestamp));
        $timestamp_before_five_min = strtotime($before_five_min);

        $chats = Chat::where('sender_id', $input['user_id'])->where('receiver_id', Auth::user()->id)
                ->where('status', 'unseen')->get();
        if(sizeof($chats) > 0) {
            $update = array('status' => 'seen');
            foreach($chats as $chat) {
                Chat::where('id', $chat['id'])->update($update);
            }

            $html = '<div class="row heading">
                <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
                    <div class="heading-avatar-icon">
                        <img src="'.asset('public/images/avatar.png').'">
                    </div>
                </div>
                <div class="col-sm-8 col-xs-7 heading-name">
                    <a class="heading-name-meta">'.ucwords($user->first_name.' '.$user->last_name).'
                    </a>';
                    if(strtotime($user->last_logged_in) >= $timestamp_before_five_min
                    && strtotime($user->last_logged_in) <= $current_timestamp) {
                        $html .= '<span class="heading-online">Online</span>';
                    }
                $html .= '</div>
                <div class="col-sm-1 col-xs-1  heading-dot pull-right">
                    <i class="fa fa-ellipsis-v fa-2x  pull-right"></i>
                </div>            
            </div>
            <div class="row message" id="conversation">';
                $allChats = Chat::where('sender_id', $input['user_id'])
                            ->where('receiver_id', Auth::user()->id)
                            ->orWhere('sender_id', Auth::user()->id)
                            ->where('receiver_id', $input['user_id'])->get();
                foreach($allChats as $chatt) {
                    if($chatt['sender_id'] == $input['user_id']) {
                        if($chatt['is_delete_id_user_first'] == Auth::user()->id || $chatt['is_delete_id_user_second'] == Auth::user()->id) {

                        } else {
                            $html .= '<div class="row message-body msg_'.$chatt['id'].'">
                                  <div class="col-sm-12 message-main-receiver">
                                    <div class="receiver">
                                      <div class="message-text">'.$chatt['message'].'</div>
                                      <span class="message-time pull-right">'.
                                            date('d-M-Y h:i a', $chatt['timestamp']).'
                                          </span>
                                    </div>
                                  </div>
                                  <button class="btn btn-danger" onclick="deleteMsg('.$chatt['id'].', '.Auth::user()->id.')"><i class="fa fa-trash"></i></button>
                                </div>';
                        }
                    }

                    if($chatt['sender_id'] == Auth::user()->id) {
                        if($chatt['is_delete_id_user_first'] == Auth::user()->id || $chatt['is_delete_id_user_second'] == Auth::user()->id) {

                        } else {
                            $html .= '<div class="row message-body msg_'.$chatt['id'].'">
                                  <div class="col-sm-12 message-main-sender">
                                    <div class="sender">
                                      <div class="message-text">'.$chatt['message'].'</div>
                                      <span class="message-time pull-right">'.
                                            date('d-M-Y h:i a', $chatt['timestamp']).'
                                          </span>
                                    </div>
                                  </div>
                                  <button class="btn btn-danger" onclick="deleteMsg('.$chatt['id'].', '.Auth::user()->id.')"><i class="fa fa-trash"></i></button>
                                </div>';
                        }
                    }
                }
                $html .=  '<div class="row reply blank-msg">
                    <div class="col-sm-1 col-xs-1 reply-emojis">
                      <i class="fa fa-smile-o fa-2x"></i>
                    </div>
                    <div class="col-sm-9 col-xs-9 reply-main">
                      <textarea class="form-control" rows="1" id="comment"></textarea>
                    </div>
                    <div class="col-sm-1 col-xs-1 reply-recording">
                      <i class="fa fa-microphone fa-2x" aria-hidden="true"></i>
                    </div>
                    <div class="col-sm-1 col-xs-1 reply-send" onclick="sendMessage('.Auth::user()->id.', '.$user->id.')">
                      <i class="fa fa-send fa-2x" aria-hidden="true"></i>
                    </div>
                </div>';
        } else {        
            $html = '<div class="row heading">
                <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
                    <div class="heading-avatar-icon">
                        <img src="'.asset('public/images/avatar.png').'">
                    </div>
                </div>
                <div class="col-sm-8 col-xs-7 heading-name">
                    <a class="heading-name-meta">'.ucwords($user->first_name.' '.$user->last_name).'
                    </a>';
                    if(strtotime($user->last_logged_in) >= $timestamp_before_five_min
                    && strtotime($user->last_logged_in) <= $current_timestamp) {
                        $html .= '<span class="heading-online">Online</span>';
                    }
                $html .= '</div>
                <div class="col-sm-1 col-xs-1  heading-dot pull-right">
                    <i class="fa fa-ellipsis-v fa-2x  pull-right"></i>
                </div>            
            </div>
            <div class="row message" id="conversation">';                
                
                $allChats = Chat::where('sender_id', $input['user_id'])
                            ->where('receiver_id', Auth::user()->id)
                            ->orWhere('sender_id', Auth::user()->id)
                            ->where('receiver_id', $input['user_id'])->get();
                foreach($allChats as $chatt) {
                    if($chatt['sender_id'] == $input['user_id']) {
                        if($chatt['is_delete_id_user_first'] == Auth::user()->id || $chatt['is_delete_id_user_second'] == Auth::user()->id) {

                        } else {
                            $html .= '<div class="row message-body msg_'.$chatt['id'].'">
                                  <div class="col-sm-12 message-main-receiver">
                                    <div class="receiver">
                                      <div class="message-text">'.$chatt['message'].'</div>
                                      <span class="message-time pull-right">'.
                                            date('d-M-Y h:i a', $chatt['timestamp']).'
                                          </span>
                                    </div>
                                  </div>
                                  <button class="btn btn-danger receiver-btn" onclick="deleteMsg('.$chatt['id'].', '.Auth::user()->id.')"><i class="fa fa-trash"></i></button>
                                </div>';
                        
                        }
                    }

                    if($chatt['sender_id'] == Auth::user()->id) {
                        if($chatt['is_delete_id_user_first'] == Auth::user()->id || $chatt['is_delete_id_user_second'] == Auth::user()->id) {

                        } else {
                            $html .= '<div class="row message-body msg_'.$chatt['id'].'">
                                  <div class="col-sm-12 message-main-sender">
                                    <div class="sender">
                                      <div class="message-text">'.$chatt['message'].'</div>
                                      <span class="message-time pull-right">'.
                                            date('d-M-Y h:i a', $chatt['timestamp']).'
                                          </span>
                                    </div>
                                  </div>
                                  <button class="btn btn-danger sender-btn" onclick="deleteMsg('.$chatt['id'].', '.Auth::user()->id.')"><i class="fa fa-trash"></i></button>
                                </div>';
                        }
                    }
                }


                $html .= '<div class="row reply blank-msg">
                    <div class="col-sm-1 col-xs-1 reply-emojis">
                      <i class="fa fa-smile-o fa-2x"></i>
                    </div>
                    <div class="col-sm-9 col-xs-9 reply-main">
                      <textarea class="form-control" rows="1" id="comment"></textarea>
                    </div>
                    <div class="col-sm-1 col-xs-1 reply-recording">
                      <i class="fa fa-microphone fa-2x" aria-hidden="true"></i>
                    </div>
                    <div class="col-sm-1 col-xs-1 reply-send" onclick="sendMessage('.Auth::user()->id.', '.$user->id.')">
                      <i class="fa fa-send fa-2x" aria-hidden="true"></i>
                    </div>
                </div>';
        }

        return $html;
    }  

    public function sendMessage(Request $request) {
        $input = $request->all();
        $chat = new Chat();
        $chat->sender_id = $input['sender_id'];
        $chat->receiver_id = $input['receiver_id'];
        $chat->message = $input['message'];
        $chat->timestamp = strtotime(date('Y-m-d H:i:s'));
        $chat->save();

        $current_timestamp = strtotime(date('Y-m-d H:i:s'));
        $before_five_min = date("Y-m-d H:i:s", strtotime('-5 minutes', $current_timestamp));
        $timestamp_before_five_min = strtotime($before_five_min);

        $user = User::find($input['receiver_id']);

        $html = '<div class="row heading">
                <div class="col-sm-2 col-md-1 col-xs-3 heading-avatar">
                    <div class="heading-avatar-icon">
                        <img src="'.asset('public/images/avatar.png').'">
                    </div>
                </div>
                <div class="col-sm-8 col-xs-7 heading-name">
                    <a class="heading-name-meta">'.ucwords($user->first_name.' '.$user->last_name).'
                    </a>';
                    if(strtotime($user->last_logged_in) >= $timestamp_before_five_min
                    && strtotime($user->last_logged_in) <= $current_timestamp) {
                        $html .= '<span class="heading-online">Online</span>';
                    }
                $html .= '</div>
                <div class="col-sm-1 col-xs-1  heading-dot pull-right">
                    <i class="fa fa-ellipsis-v fa-2x  pull-right"></i>
                </div>            
            </div>
            <div class="row message" id="conversation">';                
                
                $allChats = Chat::where('sender_id', $input['receiver_id'])
                            ->where('receiver_id', Auth::user()->id)
                            ->orWhere('sender_id', Auth::user()->id)
                            ->where('receiver_id', $input['receiver_id'])->get();
                foreach($allChats as $chatt) {
                    if($chatt['sender_id'] == $input['receiver_id']) {
                        if($chatt['is_delete_id_user_first'] == Auth::user()->id || $chatt['is_delete_id_user_second'] == Auth::user()->id) {

                        } else {
                            $html .= '<div class="row message-body msg_'.$chatt['id'].'">
                                  <div class="col-sm-12 message-main-receiver">
                                    <div class="receiver">
                                      <div class="message-text">'.$chatt['message'].'</div>
                                      <span class="message-time pull-right">'.
                                            date('d-M-Y h:i a', $chatt['timestamp']).'
                                          </span>
                                    </div>
                                  </div>
                                  <button class="btn btn-danger receiver-btn" onclick="deleteMsg('.$chatt['id'].', '.Auth::user()->id.')"><i class="fa fa-trash"></i></button>
                                </div>';
                        }
                    }

                    if($chatt['sender_id'] == Auth::user()->id) {
                        if($chatt['is_delete_id_user_first'] == Auth::user()->id || $chatt['is_delete_id_user_second'] == Auth::user()->id) {

                        } else {
                            $html .= '<div class="row message-body msg_'.$chatt['id'].'">
                                  <div class="col-sm-12 message-main-sender">
                                    <div class="sender">
                                      <div class="message-text">'.$chatt['message'].'</div>
                                      <span class="message-time pull-right">'.
                                            date('d-M-Y h:i a', $chatt['timestamp']).'
                                          </span>
                                    </div>
                                  </div>
                                  <button class="btn btn-danger sender-btn" onclick="deleteMsg('.$chatt['id'].', '.Auth::user()->id.')"><i class="fa fa-trash"></i></button>
                                </div>';
                        }
                    }
                }


                $html .= '<div class="row reply blank-msg">
                    <div class="col-sm-1 col-xs-1 reply-emojis">
                      <i class="fa fa-smile-o fa-2x"></i>
                    </div>
                    <div class="col-sm-9 col-xs-9 reply-main">
                      <textarea class="form-control" rows="1" id="comment"></textarea>
                    </div>
                    <div class="col-sm-1 col-xs-1 reply-recording">
                      <i class="fa fa-microphone fa-2x" aria-hidden="true"></i>
                    </div>
                    <div class="col-sm-1 col-xs-1 reply-send" onclick="sendMessage('.Auth::user()->id.', '.$user->id.')">
                      <i class="fa fa-send fa-2x" aria-hidden="true"></i>
                    </div>
                </div>';

                return $html;


    }

    function deleteMsgSender($user_id, $chat_id) {
        $chat = Chat::find($chat_id);
        if($chat->is_delete_id_user_first != '') {
            $update = array('is_delete_id_user_second' => $user_id);
        } else {
            $update = array('is_delete_id_user_first' => $user_id);
        }

        Chat::where('id', $chat_id)->update($update);
        return 'success';

    }

}