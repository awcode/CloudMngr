<?php
/* Copyright Mark Walker (AWcode) 2014
 *
 * CloudMngrLoadBalancer Class
 */

use Aws\Common\Aws;
use Aws\Common\Credentials\Credentials;

class CloudMngrInstanceAWS extends CloudMngr{
	private $credentials;

	function __construct($group_id="", $region_id=""){
		parent::__construct($group_id, $region_id);

		require_once($this->class_path."/../AWS/aws-autoloader.php");
		$this->credentials = new Credentials($this->config['aws_access_key_id'], $this->config['aws_secret_access_key']);
		
		$region = $this->region()->getRegion();

		$this->AWS = Aws::factory(array(
			'credentials' 	=> $this->credentials,
			'region'	=> $region['id']
		));
	}


	function launchNewInstance($imageId, $min, $max, $securityGroups, $instanceType, $placement, $subnetId){
		$this->runHooks("beforeLaunchNewInstance", $this->module_name);
		$this->runHooks("beforeAWSLaunchNewInstance", $this->module_name);
		
		$ec2 = $this->AWS->get('ec2');
		$res = $ec2->runInstances(array(
			'ImageId' => $imageId,
			'MinCount' => $min,
			'MaxCount' => $max,
			'SecurityGroupIds' => $securityGroups,
			'InstanceType' => $instanceType,
			'Placement' => $placement,
			'SubnetId' => $subnetId
		));
		$instances = $res['Instances'];

		$this->runHooks("afterLaunchNewInstance", $this->module_name);
		$this->runHooks("afterAWSLaunchNewInstance", $this->module_name);
		return $instances;
	}

	function setInstanceTags($resources, $tags){
		$this->runHooks("beforeSetInstanceTags", $this->module_name);
		$this->runHooks("beforeAWSSetInstanceTags", $this->module_name);

		$ec2 = $this->AWS->get('ec2');
		$res = $ec2->createTags(array(
			'Resources' => $resources,
			'Tags' => $tags
		));
		$instances = $res['Instances'];

		$this->runHooks("afterSetInstanceTags", $this->module_name);
		$this->runHooks("afterAWSSetInstanceTags", $this->module_name);

		return $instances;
	}

	function waitInstanceState($instanceIds, $state, $timeout=60){
		$time = time();
		$ec2 = $this->AWS->get('ec2');

		if(!is_array($instanceIds)){$instanceIds = array($instanceIds);}

		while($secs < $timeout){
			$chk = $ec2->describeInstances(array(
				'InstanceIds' => $instanceIds
			));
			if(($chk['Reservations'][0]['Instances'][0]['InstanceId'] == $instanceIds[0]) && ($chk['Reservations'][0]['Instances'][0]['State']['Name'] ==  $state)){ return true;}
			sleep(1);
			$secs = time() - $time;
		}
		return false;
	}

	function assignPublicIp($instanceId){
		$this->runHooks("beforeAssignPublicIP", $this->module_name);
		$this->runHooks("beforeAWSAssignPublicIP", $this->module_name);

		$ec2 = $this->AWS->get('ec2');
		
		if(!$this->waitInstanceState($instanceId, "running")){ echo("notrun"); return false;}
		$res = $ec2->allocateAddress(array(
			'Domain' => 'vpc'
		));
		
		$res2 = $ec2->associateAddress(array(
			'InstanceId' => $instanceId,
			'AllocationId' => $res['AllocationId']
		));

		$this->runHooks("afterAssignPublicIP", $this->module_name);
		$this->runHooks("afterAWSAssignPublicIP", $this->module_name);

		if($res2['AssociationId']) return $res['PublicIp'];
	
	}

	function terminateInstance($instanceIds){
		$this->runHooks("beforeTerminateInstance", $this->module_name);
		$this->runHooks("beforeAWSTerminateInstance", $this->module_name);

		$ec2 = $this->AWS->get('ec2');

		if(!is_array($instanceIds)){$instanceIds = array($instanceIds);}

		$chk = $ec2->describeInstances(array(
			'InstanceIds' => $instanceIds
		));

		$res = $ec2->terminateInstances(array(
			'InstanceIds' => $instanceIds
		));

		if($res['TerminatingInstances'][0]['InstanceId']){
			if(!$this->waitInstanceState($instanceIds, "terminated")){return false;}
			foreach($chk['Reservations'][0]['Instances'] as $inst){
				if($inst['PublicIpAddress']){
					$addr = $ec2->describeAddresses(array(
						'PublicIps' => array($inst['PublicIpAddress'])
					));
					if($addr['Addresses'][0]['AssociationId']){
						$ec2->disassociateAddress(array(
							'PublicIp' => $inst['PublicIpAddress'],
							'AssociationId' => $addr['Addresses'][0]['AssociationId']
						));
					}
					sleep(5);
					if($addr['Addresses'][0]['AllocationId']){
						$ec2->releaseAddress(array(
							'AllocationId' => $addr['Addresses'][0]['AllocationId']
						));
					}else{
						$ec2->releaseAddress(array(
							'PublicIp' => $inst['PublicIpAddress']
						));
					}
				}
			}
		}
		$this->runHooks("afterTerminateInstance", $this->module_name);
		$this->runHooks("afterAWSTerminateInstance", $this->module_name);
	}

}
