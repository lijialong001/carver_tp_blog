<?php
declare (strict_types = 1);

namespace app\admin\controller;

use think\Request;
use Nette\Mail\Message;
use Nette\Mail\SmtpMailer;

class Email
{
	public function postSend(){
		return view("email/sendEmail");
	}

	/**
	 * @desc 处理发送的邮件
	 * @author  Carver
	 */
	public function checkEmail(Request $request){
		$email_title=input("email_title");//邮件标题
		$email_people=input("email_people");//邮件收件人
		$email_content=input("email_content");//邮件内容
		$message = "
					<html>
					<head>
					<title>{$email_title}</title>
					</head>
					<body>
					正在向您申请友情链接...<button type='checkbox' ><a href='{$email_content}'>点击查看~</a></button>
					</body>
					</html>
					";
		if($email_people){
			//自定义发送邮件
			$mailer = new SmtpMailer([
				'host' => config("email.HOST"),//发送端口
				'username' => config("email.USERNAME"),//发送方邮件地址
				'password' => config("email.PASSWORD") ]);//发送密码
			$mail = new Message;
			$mail->setFrom(config("email.USERNAME"))//发送方邮件地址
				 ->addTo($email_people)//收件人邮箱
				 ->setSubject($email_title)//邮件标题
				 ->setHtmlBody($message);
			$status=$mailer->send($mail);//发送邮件
			if(empty($status)){
				echo "<script>alert('邮箱发送成功!');location.href='postSend'</script>";
			}else{
				echo "<script>alert('邮箱发送失败!');location.href='postSend'</script>";
			}
		}

	}
}
