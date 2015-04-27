<?php

//$mailTo = 'petun911@gmail.com';
$mailTo = 'petun@Air-Petr.Dlink';
$siteName = 'example.com';

$config = array(
	'feedbackForm' => array(
		'fields' => array(
			'name' => 'Ваше имя',
			'telephone' => 'Ваш телефон',
			'email' => 'Email',
			'select-box' => 'select-box',
			'check-test' => 'test check',
			'regexText' => 'Regex Text',

		),
		'rules' => array(
			array('name', 'required'),
			array('telephone', 'required'),
			array('email', 'email'),
			array('regexText', 'regex', 'rule' => '/\d+/', 'errorMessage' => 'В поле %s должны быть только числа'),
		),
		'actions' => array(
			array(
				'mail', 'subject' => 'Новое письмо с сайта',
				'from' => 'no-reply@' . $siteName,
				'fromName' => 'Администратор',
				'to' => $mailTo
			),
			array(
				'redirect',
				'to' => 'success.html',
			),
			array(
				'modxResource',
				'coreCmsPath' => '/Users/petun/Sites/modx/core/',
				'resource' => array(
					'pagetitle' => array('eval' => '$this->_form->fieldValue("name")'),
					'parent' => array('value' => '0'),
					'template' => array('value' => '1'),
					'published' => array('value' => '1'),
					'description' => array('value' => 'sample description'),
					'introtext' => array('eval' => '$this->_form->fieldValue("telephone") . $this->_form->fieldValue("email")'),
					'tv' => array(
						'date' => array('value' => '2013-01-01 12:12'),
						'typeId' => array('value' => '3')
					)
				)
			)
		)
	),

	'feedbackFormSimple' => array(
		'fields' => array(
			'name' => 'Ваще имя',
			'telephone' => 'Ваш телефон',
			'email' => 'Email',
		),
		'rules' => array(
			array('name', 'required'),
			array('telephone', 'required'),
			array('email', 'email'),
		),
		'actions' => array(
			array(
				'mail', 'subject' => 'Новое письмо с сайта',
				'from' => 'no-reply@' . $siteName,
				'fromName' => 'Администратор',
				'to' => $mailTo
			),
		)
	),
);