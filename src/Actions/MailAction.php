<?php

namespace Petun\Forms\Actions;

/**
 * Class MailAction
 * @package Petun\Forms\Actions
 * @author Petr Marochkin <petun911@gmail.com>
 * @link http://petun.ru/
 * @copyright 2015, Petr Marochkin
 */
class MailAction extends BaseAction
{

	/**
	 * @var
	 */
	public $subject;

	/**
	 * @var
	 */
	public $from;

	/**
	 * @var
	 */
	public $fromName;

	/**
	 * if array - try to eval string in key 'eval'. If string - use string.
	 * @var string|array
	 */
	public $to;

	/**
	 * @var bool
	 */
	public $processFiles = true;


	/**
	 * @param \Petun\Forms\BaseForm $form
	 */
	public function __construct(\Petun\Forms\BaseForm $form) {
		$this->_form = $form;
	}

	/**
	 * @return string
	 */
	private function _getBody() {
		//todo добавить стиль для письма
		$html = "<h2>".$this->subject."</h2>\n\n<ul>";
		foreach ($this->_form->fieldValues() as $label => $value) {
			$value = is_array($value) ? implode(', ', $value) : $value;
			$html .= sprintf("<li><strong>%s</strong>: %s</li>\n", $label, $value ? $value : '-');

		}
		$html .= '</ul>';
		return $html;
	}


	/**
	 * @return bool
	 * @throws \Exception
	 * @throws \phpmailerException
	 */
	function run() {
		//Create a new PHPMailer instance
		$mail = new \PHPMailer;

		$mail->CharSet = 'utf-8';

		// Set PHPMailer to use the sendmail transport
		$mail->isSendmail();

		// from
		$mail->setFrom($this->from, $this->fromName);

		$mail->addAddress($this->_getTo());

		//Set the subject line
		$mail->Subject = $this->subject;


		$mail->msgHTML($this->_getBody());

		if ($this->processFiles && !empty($_FILES)) {
			foreach ($_FILES as $file) {
				if ($file['error'] == UPLOAD_ERR_OK) {
					$mail->addAttachment($file['tmp_name'], $file['name']);
				}
			}
		}

		if (!$mail->send()) {
			return false;
		} else {
			return true;
		}
	}


	protected function _getTo() {
		//Set who the message is to be sent to
		if (is_array($this->to) && array_key_exists('eval', $this->to)) {
			return $this->evaluateExpression($this->to['eval']);
		} else {
			return (string)$this->to;
		}
	}

}