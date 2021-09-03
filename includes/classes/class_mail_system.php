<?php
/**
 *
 * @ EvolutionScript FULL DECODED & NULLED
 *
 * @ Version  : 5.1
 * @ Author   : MTIMER
 * @ Release on : 2014-09-01
 * @ Website  : http://www.mtimer.net
 *
 **/

class MailSystem {
	function MailSystem($data_mail) {
		global $cache;
		global $db;

		$email_template = $cache->get("email_template");

		if ($email_template == null) {
			$q = $db->query("SELECT * FROM email_template");

			while ($r = $db->fetch_array($q)) {
				$email_template[$r['id']] = $r;
			}

			$cache->set("email_template", $email_template, 604800);
		}

		$this->mailtpl = $email_template[$data_mail['mail_id']];
		$this->mail_message = ($this->mailtpl['type'] == "plain" ? $this->mailtpl['message_plain'] : $this->mailtpl['message_html']);
		$this->load_info($data_mail['str2find'], $data_mail['str2change']);
		$this->mail_receiver = $data_mail['receiver'];
	}

	function load_info($str2find, $str2change) {
		$this->mail_subject = str_replace($str2find, $str2change, $this->mailtpl['subject']);
		$this->mail_message = str_replace($str2find, $str2change, $this->mail_message);
	}

	function send() {
		$mail = new mail();
		$mail->setFrom();
		$mail->addTo($this->mail_receiver);
		$mail->setSubject($this->mail_subject);

		if ($this->mailtpl['type'] == "plain") {
			$mail->setBodyText($this->mail_message);
		}
		else {
			$mail->setBodyHtml($this->mail_message);
		}

		$mail->send();
	}
}

?>