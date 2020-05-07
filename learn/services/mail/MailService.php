<?php


namespace learn\services\mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * 邮件
 * Class MailService
 * @package learn\services\mail
 */
class MailService
{
    /**
     * 调试模式
     * @var int
     */
    protected static $debug = 0;

    /**
     * 编码格式
     * @var string
     */
    protected static $charSet = "UTF-8";

    /**
     * 实例
     * @var null
     */
    public static $instance = null;

    /**
     * @param array $config
     * @return null
     */
    public static function init(array $config)
    {
        self::$instance->CharSet = self::$charSet;
        self::$instance->SMTPDebug = self::$debug;
        self::$instance->isSMTP();
        self::$instance->Host = $config['host'];
        self::$instance->SMTPAuth = true;
        self::$instance->Username = $config['username'];
        self::$instance->Password = $config['password'];
        self::$instance->SMTPSecure = 'ssl';
        self::$instance->Port = $config['port'];
        self::$instance->setFrom($config['from'],$config['from_name']);
        return self::$instance;
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function options()
    {
        $config = systemConfigMore(['mail_host','mail_username','mail_password','mail_port','mail_from','mail_from_name']);
        return [
            'host' => $config['mail_host'],
            'username' => $config['mail_username'],
            'password' => $config['mail_password'],
            'port' => $config['mail_port'],
            'from' => $config['mail_from'],
            'from_name' => $config['mail_from_name'],
        ];
    }

    /**
     * 邮件对象
     * @return MailService|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function mail()
    {
        (self::$instance === null) && (self::$instance = new PHPMailer(true));
        self::init(self::options());
        return self::$instance;
    }

    /**
     * @return MailService
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function app()
    {
        self::mail();
        return new self();
    }

    /**
     * 接收者
     * @param string $to
     * @return null
     */
    public function to(string $to)
    {
        self::$instance->addAddress($to);
        return $this;
    }

    /**
     * @param string $subject
     * @param string $body
     * @param string $altBody
     * @return bool
     */
    public function send(string $subject, string $body,string $altBody = "邮件客户端不支持HTML")
    {
        try {
            self::$instance->Subject = $subject;
            self::$instance->Body    = $body;
            self::$instance->AltBody = $altBody;
            self::$instance->send();
            return true;
        }catch (Exception $e)
        {
            var_dump($e->errorMessage());
            return false;
        }
    }
}