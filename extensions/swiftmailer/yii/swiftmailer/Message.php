<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\swiftmailer;

use yii\mail\BaseMessage;

/**
 * Email message based on SwiftMailer library.
 *
 * @see http://swiftmailer.org/docs/messages.html
 * @see \yii\swiftmailer\Mailer
 *
 * @method Mailer getMailer() returns mailer instance.
 * @property \Swift_Message $swiftMessage vendor message instance.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 2.0
 */
class Message extends BaseMessage
{
	/**
	 * @var \Swift_Message Swift message instance.
	 */
	private $_swiftMessage;

	/**
	 * @return \Swift_Message Swift message instance.
	 */
	public function getSwiftMessage()
	{
		if (!is_object($this->_swiftMessage)) {
			$this->_swiftMessage = $this->createSwiftMessage();
		}
		return $this->_swiftMessage;
	}

	/**
	 * @inheritdoc
	 */
	public function setCharset($charset)
	{
		$this->getSwiftMessage()->setCharset($charset);
	}

	/**
	 * @return string the character set of this message.
	 */
	public function getCharset()
	{
		return $this->getSwiftMessage()->getCharset();
	}

	/**
	 * @inheritdoc
	 */
	public function setFrom($from)
	{
		$this->getSwiftMessage()->setFrom($from);
		$this->getSwiftMessage()->setReplyTo($from);
	}

	/**
	 * @return string from address of this message.
	 */
	public function getFrom()
	{
		return $this->getSwiftMessage()->getFrom();
	}

	/**
	 * @inheritdoc
	 */
	public function setTo($to)
	{
		$this->getSwiftMessage()->setTo($to);
	}

	/**
	 * @return array To addresses of this message.
	 */
	public function getTo()
	{
		return $this->getSwiftMessage()->getTo();
	}

	/**
	 * @inheritdoc
	 */
	public function setCc($cc)
	{
		$this->getSwiftMessage()->setCc($cc);
	}

	/**
	 * @return array Cc address of this message.
	 */
	public function getCc()
	{
		return $this->getSwiftMessage()->getCc();
	}

	/**
	 * @inheritdoc
	 */
	public function setBcc($bcc)
	{
		$this->getSwiftMessage()->setBcc($bcc);
	}

	/**
	 * @return array Bcc addresses of this message.
	 */
	public function getBcc()
	{
		return $this->getSwiftMessage()->getBcc();
	}

	/**
	 * @inheritdoc
	 */
	public function setSubject($subject)
	{
		$this->getSwiftMessage()->setSubject($subject);
	}

	/**
	 * @return string the subject of this message.
	 */
	public function getSubject()
	{
		return $this->getSwiftMessage()->getSubject();
	}

	/**
	 * @inheritdoc
	 */
	public function setText($text)
	{
		$this->setBody($text, 'text/plain');
	}

	/**
	 * @inheritdoc
	 */
	public function setHtml($html)
	{
		$this->setBody($html, 'text/html');
	}

	/**
	 * Sets the message body.
	 * If body is already set and its content type matches given one, it will
	 * be overridden, if content type miss match the multipart message will be composed.
	 * @param string $body body content.
	 * @param string $contentType body content type.
	 */
	protected function setBody($body, $contentType)
	{
		$message = $this->getSwiftMessage();
		$oldBody = $message->getBody();
		if (empty($oldBody)) {
			$parts = $message->getChildren();
			$partFound = false;
			foreach ($parts as $key => $part) {
				if (!($part instanceof \Swift_Mime_Attachment)) {
					/* @var $part \Swift_Mime_MimePart */
					if ($part->getContentType() == $contentType) {
						unset($parts[$key]);
						$partFound = true;
						break;
					}
				}
			}
			if ($partFound) {
				reset($parts);
				$message->setChildren($parts);
				$message->addPart($body, $contentType);
			} else {
				$message->setBody($body, $contentType);
			}
		} else {
			$oldContentType = $message->getContentType();
			if ($oldContentType == $contentType) {
				$message->setBody($body, $contentType);
			} else {
				$message->setBody(null);
				$message->setContentType(null);
				$message->addPart($oldBody, $oldContentType);
				$message->addPart($body, $contentType);
			}
		}
	}

	/**
	 * @inheritdoc
	 */
	public function attachFile($fileName, array $options = [])
	{
		$attachment = \Swift_Attachment::fromPath($fileName);
		if (!empty($options['fileName'])) {
			$attachment->setFilename($options['fileName']);
		}
		if (!empty($options['contentType'])) {
			$attachment->setContentType($options['contentType']);
		}
		$this->getSwiftMessage()->attach($attachment);
	}

	/**
	 * @inheritdoc
	 */
	public function attachContent($content, array $options = [])
	{
		$attachment = \Swift_Attachment::newInstance($content);
		if (!empty($options['fileName'])) {
			$attachment->setFilename($options['fileName']);
		}
		if (!empty($options['contentType'])) {
			$attachment->setContentType($options['contentType']);
		}
		$this->getSwiftMessage()->attach($attachment);
	}

	/**
	 * @inheritdoc
	 */
	public function embedFile($fileName, array $options = [])
	{
		$embedFile = \Swift_EmbeddedFile::fromPath($fileName);
		if (!empty($options['fileName'])) {
			$embedFile->setFilename($options['fileName']);
		}
		if (!empty($options['contentType'])) {
			$embedFile->setContentType($options['contentType']);
		}
		return $this->getSwiftMessage()->embed($embedFile);
	}

	/**
	 * @inheritdoc
	 */
	public function embedContent($content, array $options = [])
	{
		$embedFile = \Swift_EmbeddedFile::newInstance($content);
		if (!empty($options['fileName'])) {
			$embedFile->setFilename($options['fileName']);
		}
		if (!empty($options['contentType'])) {
			$embedFile->setContentType($options['contentType']);
		}
		return $this->getSwiftMessage()->embed($embedFile);
	}

	/**
	 * @inheritdoc
	 */
	public function __toString()
	{
		return $this->getSwiftMessage()->toString();
	}

	/**
	 * Creates the Swift email message instance.
	 * @return \Swift_Message email message instance.
	 */
	protected function createSwiftMessage()
	{
		return new \Swift_Message();
	}
}