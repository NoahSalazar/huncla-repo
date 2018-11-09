<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class post extends MX_Controller {
	public $table;
	public $module;
	public $module_name;
	public $module_icon;

	public function __construct(){ 
		parent::__construct();

		$this->tb_accounts = LINKEDIN_ACCOUNTS;
		$this->tb_posts = LINKEDIN_POSTS;
		$this->module = get_class($this);
		$this->module_name = lang("linkedin_accounts");
		$this->module_icon = "fa fa-linkedin";
		$this->load->model(get_class($this).'_model', 'model');
	}

	public function index(){
		$data = array(
			'module'       => $this->module,
			'module_name'  => $this->module_name,
			'module_icon'  => $this->module_icon,
			'accounts'     => $this->model->fetch("id, username, avatar, ids, type", $this->tb_accounts, "uid = '".session("uid")."'")
		);
		$this->template->build('post/index', $data);
	}

	public function block_report(){
		$data = array();
		$this->load->view('post/block_report', $data);
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
		$accounts  = $this->input->post("account");
		$media     = $this->input->post("media");
		$time_post = post("time_post");
		$caption   = post("caption");
		$url       = post("link");
		$type      = ($url != "")?"link":"photo";
		
		if(!$accounts){
			ms(array(
	        	"status"  => "error",
	        	"stop"    => true,
	        	"message" => lang('please_select_an_account')
	        ));
		}

		if(!$media && empty($media)){
			ms(array(
	        	"status"  => "error",
	        	"stop"    => true,
	        	"message" => lang('please_select_a_media')
	        ));
		}

		if(!post("is_schedule")){
			if(!empty($accounts)){
				foreach ($accounts as $account_id) {
					$linkedin_accounts = $this->model->get("id, username, pid, access_token, type", $this->tb_accounts, "ids = '".$account_id."' AND uid = '".session("uid")."'");
					if(!empty($linkedin_accounts)){
						$data = array(
							"ids" => ids(),
							"uid" => session("uid"),
							"account" => $linkedin_accounts->id,
							"type" => $type,
							"data" => json_encode(array(
										"media"   => $media,
										"caption" => $caption,
										"url"     => $url
									)),
							"time_post" => NOW,
							"delay" => 0,
							"time_delete" => 0,
							"changed" => NOW,
							"created" => NOW
						);

						$li = new LinkedinAPI(LINKEDIN_CLIENT_ID, LINKEDIN_CLIENT_SERECT);
						$li->set_access_token($linkedin_accounts->access_token);
						$result = $li->post($data, $linkedin_accounts);
						if(is_array($result)){
							$data['status'] = 3;
							$data['result'] = $result['message'];

							//Save report
							update_setting("linkedin_post_error_count", get_setting("linkedin_post_error_count", 0) + 1);
							update_setting("linkedin_post_count", get_setting("linkedin_post_count", 0) + 1);

							$this->db->insert($this->tb_posts, $data);

							ms($result);
						}else{
							$data['status'] = 2;
							$data['result'] = $result;

							//Save report
							update_setting("linkedin_post_success_count", get_setting("linkedin_post_success_count", 0) + 1);
							update_setting("linkedin_post_count", get_setting("linkedin_post_count", 0) + 1);
							update_setting("linkedin_post_{$type}_count", get_setting("linkedin_post_{$type}_count", 0) + 1);

							$this->db->insert($this->tb_posts, $data);

							ms(array(
					        	"status"  => "success",
					        	"message" => lang('post_successfully')
					        ));
						}

					}else{
						ms(array(
				        	"status"  => "error",
				        	"message" => lang("linkedin_account_not_exists")
				        ));
					}
				}
			}

			ms(array(
	        	"status"  => "error",
	        	"message" => lang("processing_is_error_please_try_again")
	        ));
		}else{
			if(!empty($accounts)){
				foreach ($accounts as $account_id) {
					$instagram_account = $this->model->get("id, username, pid, access_token, type", $this->tb_accounts, "ids = '".$account_id."' AND uid = '".session("uid")."'");
					if(!empty($instagram_account)){
						$data = array(
							"ids" => ids(),
							"uid" => session("uid"),
							"account" => $instagram_account->id,
							"type" => ($url != "")?"link":"photo",
							"data" => json_encode(array(
										"media"   => $media,
										"caption" => $caption,
										"url"     => $url
									)),
							"time_post" => get_timezone_system($time_post),
							"delay" => 0,
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
		$schedule_list = $this->db->select('post.*, account.access_token, account.type as account_type, account.pid')
		->from($this->tb_posts." as post")
		->join($this->tb_accounts." as account", "post.account = account.id")
		->where("(post.status = 1 OR post.status = 4) AND post.time_post <= '".NOW."' AND account.status = 1")->get()->result();

		if(!empty($schedule_list)){
			foreach ($schedule_list as $key => $schedule) {
				if(!permission("pinterest/post", $schedule->uid)){
					$this->db->delete($this->tb_posts, array("uid" => $schedule->uid, "time_post >=" => NOW));
				}

				$li = new LinkedinAPI(LINKEDIN_CLIENT_ID, LINKEDIN_CLIENT_SERECT);
				$li->set_access_token($schedule->access_token);
				$result = $li->post($schedule);
 
				$data = array();
				if(is_array($result) && $result["status"] == "error"){
					$data['status'] = 3;
					$data['result'] = json_encode(array("message" => $result["message"]));

					//
					update_setting("linkedin_post_error_count", get_setting("linkedin_post_error_count", 0, $schedule->uid) + 1, $schedule->uid);
					update_setting("linkedin_post_count", get_setting("linkedin_post_count", 0, $schedule->uid) + 1, $schedule->uid);
					
					//Save report
					$this->db->update($this->tb_posts, $data, "id = '{$schedule->id}'");
					echo $result["message"]."<br/>";
				}else{

					//Save report
					update_setting("linkedin_post_success_count", get_setting("linkedin_post_success_count", 0, $schedule->uid) + 1, $schedule->uid);
					update_setting("linkedin_post_count", get_setting("linkedin_post_count", 0, $schedule->uid) + 1, $schedule->uid);
					update_setting("linkedin_post_photo_count", get_setting("linkedin_post_photo_count", 0, $schedule->uid) + 1, $schedule->uid);

					$data['status'] = 2;
					$data['result'] = json_encode(array("message" => "successfully", "id" => $result));;
					$this->db->update($this->tb_posts, $data, "id = '{$schedule->id}'");

					echo '<a target=\'_blank\' href=\'https://www.linkedin.com/feed/update/urn:li:activity:'.$result.'\'>'.lang('post_successfully').'</a><br/>';
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
				    <name>	&lt;i class="fa fa-linkedin" &gt; &lt;/i &gt; '.$row->total.' '.lang("auto_post").'</name>
				    <startdate>'.$row->time_post.'</startdate>
				    <enddate></enddate>
				    <color>#0d77b7</color>
				    <url>'.PATH."linkedin/post/schedules/".date("Y/m/d", strtotime($row->time_post)).'</url>
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
		$timezone_first = get_timezone_system(session("schedule_date")." 00:00:00");
		$timezone_last = get_timezone_system(session("schedule_date")." 23:59:59");

		$ids = post("id");

		if($ids == -1){
			$this->db->delete($this->tb_posts, array(
				"uid" => session("uid"), 
				"time_post >=" => $timezone_first,
				"time_post <=" => $timezone_last,
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