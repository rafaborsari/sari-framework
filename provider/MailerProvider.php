<?php
namespace Sari\Provider;

use Sari\Provider\DataBaseProvider;
use Sari\Provider\RouterProvider;

use PHPMailer;

class MailerProvider
{

	public function __construct()
	{
		$this->dbh = new DataBaseProvider;
		$this->router = new RouterProvider;

		$this->config = $this->dbh->findOneBy('Configuracao', 'id', 1);

		$this->mh = new PHPMailer;
		$this->mh->CharSet = 'UTF-8';
		$this->mh->isSMTP();
		$this->mh->SMTPAuth = true;
		$this->mh->SMTPSecure = 'tls';
		$this->mh->SMTPOptions = array(
			'ssl' => array(
				'verify_peer'		=> false,
				'verify_peer_name'	=> false,
				'allow_self_signed'	=> true
			),
		);
		$this->mh->isHTML(true);
		$this->mh->Port = 587;

		$this->mh->Host = $this->config['smtpEmail'];		
		$this->mh->Username = $this->config['contatoEmail'];
		$this->mh->Password = base64_decode($this->config['senhaEmail']);
	}

	public function setAddress($to = array(), $cc = array(), $bcc = array())
	{
		// setManyAddress
		$this->mh->addAddress($to[0]);
		$this->mh->FromName = $to[1];
		$this->mh->From = $to[2];

		// setCc
		foreach ($cc as $value) {
			$this->mh->addCC($value);
		}

		// setBcc
		foreach ($bcc as $value) {
			$this->mh->addBCC($value);
		}
	}

	public function setSubject($subject = '')
	{
		$this->mh->Subject = $subject;
	}

	public function setBody($body)
	{
		include('templates/emails/email-topbar.php');
		include('templates/emails/email-header.php');
		include('templates/emails/email-banner.php');
		include('templates/emails/email-footer.php');
		$view['body'] = $body;
		
		include('templates/emails/email-template.php');

		$template = $buffer;
		$this->mh->Body = $template;
	}

	public function send()
	{
		if(!$this->mh->send()) {
			return $this->mh->ErrorInfo;
		} else {
			return true;
		}
	}

}


