<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class post extends MX_Controller {
	public $tb_account;
	public $module;
	public $tb_posts;

	public function __construct(){
		parent::__construct();

		$this->tb_account = FACEBOOK_ACCOUNTS;
		$this->tb_posts = FACEBOOK_POSTS;
		$this->module = get_class($this);
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		$data = array(
			'accounts' => $this->model->fetch("id, fullname, avatar, ids", $this->tb_account, "uid = '".session("uid")."'")
		);
		$this->template->build('post/index', $data);
	}

	public function preview(){
		$data = array();
		$this->load->view('post/preview', $data);
	}

	public function block_report(){
		$data = array();
		$this->load->view('post/block_report', $data);
	}

	public function block_general_settings(){
		$data = array();
		$this->load->view('post/general_settings', $data);
	}

	public function ajax_get_link(){
		$link = post("link");
		if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$link)) {
			return ms(array(
				"status" => "error",
				"message" => lang("invalid_url")
			));
		}

		$parse = parse_url($link);
		$data = get_info_link($link);
		$data['host'] = str_replace("www.", "", $parse['host']);
		$data['status'] = "success";
		ms($data);
	}

	public function ajax_post(){
		$ids = post("list_ids");
		$type = post("type");
		$caption = post("caption");
		$link = post("link");
		$media = $this->input->post("media");
		$time_post = post("time_post");
		$delay = post("delay");
		$type = post("type");
		$repeat = (int)post("repeat_every");
		$repeat_end = post("repeat_end");
		
		if($ids == ""){
			ms(array(
	        	"status"  => "error",
	        	"stop"    => true,
	        	"message" => lang('please_select_an_item_to_post')
	        ));
		}

		$ids = explode(",", $ids);

		switch ($type) {
			case 'text':
				if($caption == ""){
					ms(array(
			        	"status"  => "error",
			        	"stop"    => true,
			        	"message" => lang('caption_is_required')
			        ));
				}
				break;

			case 'link':
				if($link == ""){
					ms(array(
			        	"status"  => "error",
			        	"stop"    => true,
			        	"message" => lang('link_is_required')
			        ));
				}
				break;

			case 'media':
				if(!$media && empty($media)){
					ms(array(
			        	"status"  => "error",
			        	"stop"    => true,
			        	"message" => lang('please_select_a_media')
			        ));
				}
				break;
			
			default:
				ms(array(
		        	"status"  => "error",
		        	"stop"    => true,
		        	"message" => lang('please_select_a_post_type')
		        ));
				break;
		}

		if(!post("is_schedule")){

			$group_type = "";
			if(strlen($ids[0]) == 32){
				$groups = $this->model->get_group($ids[0]);
				$group_type = !empty($groups)?$groups->type:"";
				$account = $groups->account;
			}else{
				$groups = $this->model->get("*", $this->tb_account, "pid = '".$ids[0]."' AND uid = '".session("uid")."' AND status = 1");
				$group_type = !empty($groups)?"profile":"";
				$account = $groups->id;
			}

			if(!empty($groups)){
				$data = array(
					"ids" => ids(),
					"uid" => session("uid"),
					"account" => $account,
					"group" => $groups->pid,
					"category" => $group_type,
					"type" => $type,
					"data" => json_encode(array(
								"media"      => $media,
								"caption"    => $caption,
								"link"       => $link
							)),
					"time_post" => NOW,
					"delay" => 0,
					"time_delete" => 0,
					"changed" => NOW,
					"created" => NOW 
				);

				$fb   = new FacebookAPI();
				$fb->set_access_token($groups->access_token);
				$result = $fb->create_post($type, $data, $groups->pid, $group_type);

				if(is_string($result)){
					$data['status'] = 3;
					$data['result'] = json_encode(array("message" => $result));

					//
					update_setting("fb_post_error_count", get_setting("fb_post_error_count", 0) + 1);
					update_setting("fb_post_count", get_setting("fb_post_count", 0) + 1);
					
					//Save report
					$this->db->insert($this->tb_posts, $data);

					ms(array(
			        	"status"  => "error",
			        	"ids"     => $ids[0],
			        	"result"    => '<i class="text-danger webuiPopover fa fa-exclamation-circle" data-content="<p>'.$result.'</p>" data-delay-show="300" data-target="webuiPopover0"></i>'
			        ));
				}else{

					//Save report
					update_setting("fb_post_success_count", get_setting("fb_post_success_count", 0) + 1);
					update_setting("fb_post_count", get_setting("fb_post_count", 0) + 1);
					update_setting("fb_post_{$type}_count", get_setting("fb_post_{$type}_count", 0) + 1);

					$data['status'] = 2;
					$data['result'] = json_encode(array("message" => "successfully", "id" => $result->id));;
					$this->db->insert($this->tb_posts, $data);

					ms(array(
			        	"status"  => "success",
			        	"ids"     => $ids[0],
			        	"result"    => '<a target=\'_blank\' href=\'http://fb.com/'.$result->id.'\'><i class="text-success fa fa-check-circle"></i></a>'
			        ));
				}
			}else{
				ms(array(
		        	"status"  => "error",
		        	"ids"     => $ids[0],
		        	"result"    => '<i class="text-danger webuiPopover fa fa-exclamation-circle" data-content="<p>Facebook account does not exist</p>" data-delay-show="300" data-target="webuiPopover0"></i>'
		        ));
				
			}
		}else{
			if(!empty($ids)){
				foreach ($ids as $key => $id) {
					$group_type = "";
					if(strlen($id) == 32){
						$groups = $this->model->get_group($id);
						$group_type = !empty($groups)?$groups->type:"";
						$account = $groups->account;
					}else{
						$groups = $this->model->get("*", $this->tb_account, "pid = '".$id."' AND uid = '".session("uid")."'");
						$group_type = !empty($groups)?"profile":"";
						$account = $groups->id;
					}

					$time_post_save = get_to_time($time_post) + $delay*$key;

					if(!empty($groups)){
						$data = array(
							"ids" => ids(),
							"uid" => session("uid"),
							"account" => $account,
							"group" => $groups->pid,
							"category" => $group_type,
							"type" => $type,
							"data" => json_encode(array(
										"media"      => $media,
										"caption"    => $caption,
										"link"       => $link,
										"repeat"     => $repeat*86400, 
										"repeat_end" => get_timezone_system($repeat_end)
									)),
							"time_post" => get_timezone_system($time_post_save),
							"delay" => $delay,
							"time_delete" => 0,
							"status" => 1,
							"changed" => NOW,
							"created" => NOW
						);

						$this->db->insert($this->tb_posts, $data);
					}
				}
			}

			ms(array(
	        	"status"  => "success",
	        	"message" => lang('add_schedule_successfully')
	        ));
		}
	}

                                        
                                    
	/****************************************/
	/* CRON                                 */
	/* Time cron: once_per_minute           */
	/****************************************/
	public function cron(){
		$schedule_list = $this->db->select('post.*, account.access_token')
		->from($this->tb_posts." as post")
		->join($this->tb_account." as account", "post.account = account.id")
		->where("(post.status = 1 OR post.status = 4) AND post.time_post <= '".NOW."' AND account.status = 1")->get()->result();


		if(!empty($schedule_list)){
			foreach ($schedule_list as $key => $schedule) {
				if(!permission("facebook/post", $schedule->uid)){
					$this->db->delete($this->tb_posts, array("uid" => $schedule->uid, "time_post >=" => NOW));
				}
				
				$fb   = new FacebookAPI();
				$fb->set_access_token($schedule->access_token);
				$result = $fb->create_post($schedule->type, $schedule, $schedule->group, $schedule->category);

				if(is_string($result)){
					//Save report
					update_setting("fb_post_error_count", get_setting("fb_post_error_count", 0, $schedule->uid) + 1, $schedule->uid);
					update_setting("fb_post_count", get_setting("fb_post_count", 0, $schedule->uid) + 1, $schedule->uid);
					
					$data['result'] = json_encode(array("message" => $result));
					$this->db->update($this->tb_posts, $data, "id = '{$schedule->id}'");

					echo $result."<br/>";
				}else{
					$schedule_data = $schedule->data;
					if( isset($schedule_data->repeat) 
						&& isset($schedule_data->repeat_end) 
						&& $schedule_data->repeat > 0 
						&& strtotime(NOW) < strtotime($schedule_data->repeat_end)
					){
						$time_post_next = date("Y-m-d H:i:s",get_to_time($schedule->time_post) + $schedule_data->repeat);
						$data['status'] = 1;
						$data['time_post'] = $time_post_next;
					}else{
						$data['status'] = 2;
					}

					//Save report
					update_setting("fb_post_success_count", get_setting("fb_post_success_count", 0, $schedule->uid) + 1, $schedule->uid);
					update_setting("fb_post_count", get_setting("fb_post_count", 0, $schedule->uid) + 1, $schedule->uid);
					update_setting("fb_post_{$schedule->type}_count", get_setting("fb_post_{$schedule->type}_count", 0, $schedule->uid) + 1, $schedule->uid);

					$data['result'] = json_encode(array("message" => "successfully", "id" => $result->id));;
					$this->db->update($this->tb_posts, $data, "id = '{$schedule->id}'");

					echo '<a target=\'_blank\' href=\'http://fb.com/'.$result->id.'\'>'.lang('post_successfully').'</a><br/>';
				}
			}
		}else{
			
		}

	}
	//****************************************/
	//               END CRON                */
	//****************************************/


	/****************************************/
	/*           SCHEDULES POST             */
	/****************************************/
	public function block_schedules_xml(){
		$this->load->library('user_agent');
		if($this->agent->browser() != ""){
			redirect(cn());
		}

		$result = $this->model->get_calendar_schedules();
		
		$data = "";
		if(!empty($result)){
			foreach ($result as $key => $row) {
				$data .= '<event>
				    <id>'.ids().'</id>
				    <name>	&lt;i class="fa fa-facebook-square" &gt; &lt;/i &gt; '.$row->total.' Auto post</name>
				    <startdate>'.$row->time_post.'</startdate>
				    <enddate></enddate>
				    <color>#4267b2</color>
				    <url>'.PATH."facebook/post/schedules/".date("Y/m/d", strtotime($row->time_post)).'</url>
				  </event>';
			}
		}else{
			return false;
		}

		print_r($data);
	}

	public function schedules(){
		$year = segment(4);
		$month = segment(5);
		$day = segment(6);
		$date = $year."/".$month."/".$day;
		if(!validateDate($date, "Y/m/d")){
			redirect(cn("schedules"));
		}else{
			set_session("schedule_date", str_replace("/", "-", $date));
		}

		$data = array(
			'accounts' => $this->model->count_post_on_each_account(),
			'date' => $date,
			'count_status' => $this->model->count_schedules()
		);
		$this->template->build('post/schedules', $data);
	}

	public function ajax_schedules(){
		$data = array(
			'schedules' => $this->model->get_schedules((int)post("page"))
		);

		$this->load->view('post/ajax_schedules', $data);
	}

	public function ajax_delete_schedules(){
		$ids = post("id");

		if($ids == -1){
			$this->db->delete($this->tb_posts, array(
				"uid" => session("uid"), 
				"time_post >=" => get_timezone_system(session("schedule_date")." 00:00:00"),
				"time_post <=" => get_timezone_system(session("schedule_date")." 23:59:59"),
				"status" => session("schedule_type")
			));
		}else{
			$this->db->delete($this->tb_posts, array("uid" => session("uid"), "ids" => $ids ));
		}

		ms(array(
        	"status"  => "success",
        	"message" => lang('delete_successfully')
        ));
	}

	//****************************************/
	//         END SCHEDULES POST            */
	//****************************************/
}