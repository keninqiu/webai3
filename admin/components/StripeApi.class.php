<?php
	namespace app\components;

	require_once __DIR__ . '/../../class/Config.class.php';
	use Webai\Api\Config;

	class StripeApi {
		public function __construct() {
			\Stripe\Stripe::setApiKey(Config::getStripePrivateKey());
		}
 
		public function save($name,$params,$customer) {
			/*
			$params = json_encode($params);","\\\"",$params);

			$customer_id = $customer->id;
			$customer = json_encode($customer);			
			$customer = preg_replace("/\"/","\\\"",$customer);

			$sql = "insert into stripe_activity(user_id,name,params,result_id,result,created_at,updated_at) values(".$this->user_id.",\"$name\",\"$params\",\"$customer_id\",\"$customer\", now(), now())";

			Logger::userApilog("sql in save=$sql");
			$this->db->executeSql($sql);
			*/

		}

		public function savePlan($plan,$subscription_id) {
			$sql = "insert into user_plan(user_id,plan_id,subscription_id) values($this->user_id,\"$plan\",\"$subscription_id\")";
			$this->db->executeSql($sql);
		}

		public function getPlans() {
			$sql = "select user_plan.*,stripe_plan.name,stripe_plan.amount as price from user_plan,stripe_plan where user_plan.plan_id=stripe_plan.id and user_plan.status = 1 and user_plan.user_id=".$this->user_id;
			return $this->db->querySql($sql);
		}

		public function createChargeWithCustomer($amount,$currency,$customer,$description) {
			$params = array(
              "amount" => $amount,
              "currency" => $currency,
              "customer" => $customer,
              "description" => $description
            );
            $charge = \Stripe\Charge::create($params);

            self::save("Charge::create",$params,$charge);
            return $charge;
		}

		public function createToken($number,$exp_month,$exp_year,$cvc) {
			$params = array(
	          "card" => array(
	            "number" => $number,
	            "exp_month" => $exp_month,
	            "exp_year" => $exp_year,
	            "cvc" => $cvc
	          )
	        );
	        $state = 0;
	        $msg = "create Token successfully";
			$token = null;
	        try {
	        	$token = \Stripe\Token::create($params);
	        }
	        
	        catch(\Stripe\Error\Card $e) {
	        	$state = -1;
	        	$body = $e->getJsonBody();
  				$err  = $body['error'];
  				$msg = $err['message'];
	        }

	        self::save("Token::create",$params,$token);
	        return [
	        	"state" => $state,
	        	"msg" => $msg,
	        	"token" => $token
	        ];
		}

		public function createCharge($amount,$currency,$source,$description) {
			$params = array(
              "amount" => $amount,
              "currency" => $currency,
              "source" => $source,
              "description" => $description
            );

	        $state = 0;
	        $msg = "create Charge successfully";
            $customer = null;
	        try {
	        	$customer = \Stripe\Charge::create($params);
	        }
	        catch(\Stripe\Error\Card $e) {
	        	$state = -1;
	        	$body = $e->getJsonBody();
  				$err  = $body['error'];
  				$msg = $err['message'];	        	
	        }
            self::save("Charge::create",$params,$customer);
            return [
	        	"state" => $state,
	        	"msg" => $msg,
	        	"customer" => $customer
	        ];
		}

		public function getCustomer($customer_id) {
			return \Stripe\Customer::retrieve($customer_id);
		}

		public function saveCustomer($customer) {
			$customer->save();
		}

		public function createCustomer($description,$source) {
			$params = array(
			  "description" => $description,
			  "source" => $source // obtained with Stripe.js
			);
			$customer = \Stripe\Customer::create($params);
            self::save("Customer::create",$params,$customer);
            return $customer;
		}

		public function listPlan() {
			$sql = "select * from stripe_plan";
			$result = $this->db->querySql($sql);
			$plans = [];
			foreach($result as $item) {
				$id = $item["id"];
				$amount = $item["amount"];
				$name = $item["name"];
				$subscription_id = "";
				$created_at = "";
				$sql = "select * from user_plan where user_id=".$this->user_id." and plan_id=\"$id\"";
				$userPlan = $this->db->querySql($sql);
				if($userPlan) {
					$subscription_id = $userPlan[0]["subscription_id"];
					$created_at = $userPlan[0]["created_at"];
				}
				$plans[] = [
					"id" => $id,
					"amount" => $amount,
					"name" => $name,
					"subscription_id" => $subscription_id,
					"created_at" => $created_at
				];
			}

			return $plans;
		}

		public function changePlan($customer,$from_plan_id,$to_plan_id) {
			$sql = "select * from user_plan where user_id=".$this->user_id." and plan_id='$from_plan_id'";
			$result = $this->db->querySql($sql);

			if($result) {
				$result = $result[0];
				$user_plan_id = $result["id"];
                $sql = "update user_plan set plan_id = \"$to_plan_id\" where id=".$user_plan_id;

                $this->db->executeSql($sql);

				$subscription_id = $result["subscription_id"];
				$sub = null;

				/*
				if($subscription_id === -1 || $subscription_id == 0 || $subscription_id == 1) {
					Logger::yiilog("why here?");
					$sub = self::createSubscription($customer,$to_plan_id);
					Logger::yiilog("555");
				}
				else {
					Logger::yiilog("666");
					$sub = \Stripe\Subscription::retrieve($subscription_id);
					Logger::yiilog("777");
					Logger::yiilog("to_plan_id=$to_plan_id");
					$sub->plan = $to_plan_id;
					$sub->save();
					$params = [
						"customer" => $customer,
						"from_plan_id" => $from_plan_id,
						"to_plan_id" => $to_plan_id,
					];	
					Logger::yiilog("888");
					self::save("Subscription::change",$params,$sub);										
				}
				*/
				$sub = \Stripe\Subscription::retrieve($subscription_id);
				if($sub) {
					Logger::yiilog("change it");
					$sub->plan = $to_plan_id;
					$sub->save();					
				}
				else {
					Logger::yiilog("create it");
					$sub = self::createSubscription($customer,$to_plan_id);
				}

				$params = [
						"customer" => $customer,
						"from_plan_id" => $from_plan_id,
						"to_plan_id" => $to_plan_id,
				];	
				self::save("Subscription::change",$params,$sub);					
				return $sub;
			}
			else {
				$sub = self::createSubscription($customer,$to_plan_id);

			}
			return null;			
		}

		public function cancelPlan($plan_id) {
			$sql = "select * from user_plan where user_id=".$this->user_id." and plan_id='$plan_id'";
			$result = $this->db->querySql($sql);

			if($result) {
				$result = $result[0];
                $sql = "delete from user_plan where user_id=".$this->user_id." and plan_id='$plan_id'";
                $this->db->executeSql($sql);
				$subscription_id = $result["subscription_id"];
				if(in_array($subscription_id,[-1,0,1])) {
					return null;
				}
				$params = [
					"subscription_id" => $subscription_id
				];
				$sub = \Stripe\Subscription::retrieve($subscription_id);
				$sub->cancel();
				self::save("Subscription::retrieve",$params,$sub);
				return $sub;
			}
			return null;
		}

		public function createSubscription($customer,$plan) {
			$sql = "select * from stripe_plan where id='".$plan."'";
			$result = $this->db->querySql($sql);

			$amount = 0;
			if($result) {
				$result = $result[0];
				$amount = $result["amount"];
			}

			if($amount) {
				$params = array(
	                "customer" => $customer,
	                "plan" => $plan
	            );
				$subscription = \Stripe\Subscription::create($params);
				self::save("Subscription::create",$params,$subscription);	
				$subscription_id = isset($subscription->id)?$subscription->id:-1;		
			}
			else {
				$subscription_id = 1;
			}

			if(isset($subscription_id)) {
				self::savePlan($plan,$subscription_id);
			}

            return $subscription_id;
		}
	}
