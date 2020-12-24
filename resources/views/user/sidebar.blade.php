@php
use App\Chat;
use App\User;
@endphp
<div class="col-sm-4 side">
  	<div class="side-one">
        <div class="row heading">
          <div class="col-sm-3 col-xs-3 heading-avatar">
            <div class="heading-avatar-icon">
              <img src="{{asset('public/images/avatar1.png')}}">
              <span>{{ucfirst(Auth::user()->first_name)}}
            </div>
          </div>
          <div class="col-sm-1 col-xs-1  heading-dot  pull-right">
            <i class="fa fa-power-off fa-2x  pull-right" aria-hidden="true"></i>
          </div>
        </div>

        <div class="row searchBox">
          <div class="col-sm-12 searchBox-inner">
            <div class="form-group has-feedback">
              <input id="searchText" type="text" class="form-control" name="searchText" placeholder="Search">
            </div>
          </div>
        </div>

        <div class="row sideBar side">
          	@if(!empty($latest_chat) && sizeof($latest_chat) > 0)
      			@foreach($users as $user)

      				@php
            		$checkUserLatestChatSender = Chat::where('receiver_id', $user->id)
            					->where('sender_id',  Auth::user()->id)
            					->orderBy('id', 'desc')->get()->unique('receiver_id');

					$checkUserLatestChat = Chat::where('sender_id', $user->id)
            					->where('receiver_id',  Auth::user()->id)
            					->where('status', 'unseen')
            					->orderBy('id', 'desc')->get()->unique('receiver_id');;
					$userLatestChatSeen = Chat::where('sender_id', $user->id)
            					->where('receiver_id',  Auth::user()->id)
            					->where('status', 'seen')
            					->orderBy('id', 'desc')->get()->unique('receiver_id');;				
            		
            		$userChatCount = Chat::where('sender_id', $user->id)->where('status', 'unseen')->count();

        			@endphp
        			@if(sizeof($checkUserLatestChat) > 0)
            			@foreach($checkUserLatestChat as $chat)            			
            				@if($chat['sender_id'] == $user['id'])
            					<div class="row sideBar-body">
									<div class="col-sm-3 col-xs-3 sideBar-avatar">
										<div class="avatar-icon">
											<img src="{{asset('public/images/avatar.png')}}">
										</div>
									</div>
									<div class="col-sm-9 col-xs-9 sideBar-main" onclick="startChat('{{$user->id}}')">
										<div class="row">
											<div class="col-sm-8 col-xs-8 sideBar-name">
												<span class="name-meta">{{ucwords($user->first_name.' '.$user->last_name)}}
												</span>
												<p class="para-meta">
												@if($chat['is_delete_id_user_first'] == Auth::user()->id || $chat['is_delete_id_user_second'] == Auth::user()->id) 
												@else
													{{substr_replace($chat['message'], "", 20)}}
												@endif
												</p>
											</div>
											<div class="col-sm-4 col-xs-4 pull-right sideBar-time latest-time">
												<span class="time-meta pull-right">
												{{date('h:i a', strtotime($chat['created_at']))}}
												</span>
												<div class="count-msg"><p>{{$userChatCount}}</p></div>
											</div>
										</div>
									</div>
								</div>
							@endif
						@endforeach
            		@elseif(sizeof($checkUserLatestChatSender) > 0)
            			@foreach($checkUserLatestChatSender as  $chat)
            				@if($chat['sender_id'] == Auth::user()->id)
            					<div class="row sideBar-body">
									<div class="col-sm-3 col-xs-3 sideBar-avatar">
										<div class="avatar-icon">
											<img src="{{asset('public/images/avatar.png')}}">
										</div>
									</div>
									<div class="col-sm-9 col-xs-9 sideBar-main" onclick="startChat('{{$user->id}}')">
										<div class="row">
											<div class="col-sm-8 col-xs-8 sideBar-name">
												<span class="name-meta">{{ucwords($user->first_name.' '.$user->last_name)}}
												</span>
												<p class="para-meta">
													@if($chat['is_delete_id_user_first'] == Auth::user()->id || $chat['is_delete_id_user_second'] == Auth::user()->id) 
												@else
													{{substr_replace($chat['message'], "", 20)}}
												@endif</p>
											</div>
											<div class="col-sm-4 col-xs-4 pull-right sideBar-time">
												<span class="time-meta pull-right">
												{{date('h:i a', strtotime($chat['created_at']))}}
												</span>
											</div>
										</div>
									</div>
								</div>
							@endif
						@endforeach		
            		
					@elseif(sizeof($userLatestChatSeen) > 0)
	            			@foreach($userLatestChatSeen as $chat)
	            				@if($chat['sender_id'] == $user['id'])
	            					<div class="row sideBar-body">
										<div class="col-sm-3 col-xs-3 sideBar-avatar">
											<div class="avatar-icon">
												<img src="{{asset('public/images/avatar.png')}}">
											</div>
										</div>
										<div class="col-sm-9 col-xs-9 sideBar-main" onclick="startChat('{{$user->id}}')">
											<div class="row">
												<div class="col-sm-8 col-xs-8 sideBar-name">
													<span class="name-meta">{{ucwords($user->first_name.' '.$user->last_name)}}
													</span>
													<p class="para-meta">
													@if($chat['is_delete_id_user_first'] == Auth::user()->id || $chat['is_delete_id_user_second'] == Auth::user()->id) 
												@else
													{{substr_replace($chat['message'], "", 20)}}
												@endif</p>
												</div>
												<div class="col-sm-4 col-xs-4 pull-right sideBar-time ">
													<span class="time-meta pull-right">
														{{ date('d M h:i a',$chat['timestamp']) }}
													</span>
												</div>
											</div>
										</div>
									</div>
								@endif
							@endforeach
						@else
							<div class="row sideBar-body">
								<div class="col-sm-3 col-xs-3 sideBar-avatar">
									<div class="avatar-icon">
										<img src="{{asset('public/images/avatar.png')}}">
									</div>
								</div>
								<div class="col-sm-9 col-xs-9 sideBar-main" onclick="startChat('{{$user->id}}')">
									<div class="row">
										<div class="col-sm-8 col-xs-8 sideBar-name">
											<span class="name-meta">{{ucwords($user->first_name.' '.$user->last_name)}}
											</span>
											<p class="para-meta">Say Hi to start chat with {{ucfirst($user->first_name)}}</p>
										</div>
										<!-- <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
											<span class="time-meta pull-right">18:18
											</span>
										</div> -->
									</div>
								</div>
							</div>
						@endif
				@endforeach
           @else
            	@foreach($users as $user)
            		@php
            		$checkUserLatestChat = Chat::where('sender_id', $user->id)
            					->where('receiver_id',  Auth::user()->id)
            					->where('status', 'unseen')
            					->orderBy('id', 'desc')->get()->unique('receiver_id');;
            		$userChatCount = Chat::where('sender_id', $user->id)->where('status', 'unseen')->count();

            		$userLatestChatSeen = Chat::where('sender_id', $user->id)
            					->where('receiver_id',  Auth::user()->id)
            					->where('status', 'seen')
            					->orderBy('id', 'desc')->get()->unique('receiver_id');;
            		@endphp
            		@if(sizeof($checkUserLatestChat) > 0)
            			@foreach($checkUserLatestChat as $chat)
            				@if($chat['sender_id'] == $user['id'])
            					<div class="row sideBar-body">
									<div class="col-sm-3 col-xs-3 sideBar-avatar">
										<div class="avatar-icon">
											<img src="{{asset('public/images/avatar.png')}}">
										</div>
									</div>
									<div class="col-sm-9 col-xs-9 sideBar-main" onclick="startChat('{{$user->id}}')">
										<div class="row">
											<div class="col-sm-8 col-xs-8 sideBar-name">
												<span class="name-meta">{{ucwords($user->first_name.' '.$user->last_name)}}
												</span>
												<p class="para-meta">@if($chat['is_delete_id_user_first'] == Auth::user()->id || $chat['is_delete_id_user_second'] == Auth::user()->id) 
												@else
													{{substr_replace($chat['message'], "", 20)}}
												@endif</p>
											</div>
											<div class="col-sm-4 col-xs-4 pull-right sideBar-time latest-time">
												<span class="time-meta pull-right">
												{{date('h:i a', strtotime($chat['created_at']))}}
												</span>
												<div class="count-msg"><p>{{$userChatCount}}</p></div>
											</div>
										</div>
									</div>
								</div>
							@endif
						@endforeach
					
					@elseif(sizeof($userLatestChatSeen) > 0)
	            			@foreach($userLatestChatSeen as $chat)
	            				@if($chat['sender_id'] == $user['id'])
	            					<div class="row sideBar-body">
										<div class="col-sm-3 col-xs-3 sideBar-avatar">
											<div class="avatar-icon">
												<img src="{{asset('public/images/avatar.png')}}">
											</div>
										</div>
										<div class="col-sm-9 col-xs-9 sideBar-main" onclick="startChat('{{$user->id}}')">
											<div class="row">
												<div class="col-sm-8 col-xs-8 sideBar-name">
													<span class="name-meta">{{ucwords($user->first_name.' '.$user->last_name)}}
													</span>
													<p class="para-meta">@if($chat['is_delete_id_user_first'] == Auth::user()->id || $chat['is_delete_id_user_second'] == Auth::user()->id) 
												@else
													{{substr_replace($chat['message'], "", 20)}}
												@endif</p>
												</div>
												<div class="col-sm-4 col-xs-4 pull-right sideBar-time ">
													<span class="time-meta pull-right">
														{{ date('d M h:i a',$chat['timestamp']) }}
													</span>
												</div>
											</div>
										</div>
									</div>
								@endif
							@endforeach
						@else
							<div class="row sideBar-body">
								<div class="col-sm-3 col-xs-3 sideBar-avatar">
									<div class="avatar-icon">
										<img src="{{asset('public/images/avatar.png')}}">
									</div>
								</div>
								<div class="col-sm-9 col-xs-9 sideBar-main" onclick="startChat('{{$user->id}}')">
									<div class="row">
										<div class="col-sm-8 col-xs-8 sideBar-name">
											<span class="name-meta">{{ucwords($user->first_name.' '.$user->last_name)}}
											</span>
											<p class="para-meta">Say Hi to start chat with {{ucfirst($user->first_name)}}</p>
										</div>
										<!-- <div class="col-sm-4 col-xs-4 pull-right sideBar-time">
											<span class="time-meta pull-right">18:18
											</span>
										</div> -->
									</div>
								</div>
							</div>
						@endif
				@endforeach
        	@endif
    	</div>
      </div>
      <div class="side-two">
        <div class="row compose-sideBar">         
        </div>
      </div>
    </div>