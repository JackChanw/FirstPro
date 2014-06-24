<?php
require_once('./PHPMailer_v5.1/class.phpmailer.php');
require_once("./PHPMailer_v5.1/class.smtp.php"); 
$mail  = new PHPMailer(); 

$mail->CharSet    ="UTF-8";                 //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置为 UTF-8
$mail->IsSMTP();                            // 设定使用SMTP服务
$mail->SMTPAuth   = true;                   // 启用 SMTP 验证功能
$mail->SMTPSecure = "ssl";                  // SMTP 安全协议
$mail->Host       = "smtp.domob.com";       // SMTP 服务器
$mail->Port       = 25;                    // SMTP服务器的端口号
$mail->Username   = "zhangli1@domob.cn";  // SMTP服务器用户名
$mail->Password   = "zhangli123";        // SMTP服务器密码
$mail->SetFrom('zhangli1@domob.cn', 'zl');    // 设置发件人地址和名称
$mail->AddReplyTo('zhangli1@domob.cn', 'zl'); 
                                            // 设置邮件回复人地址和名称
$mail->Subject    = 'test';                     // 设置邮件标题
$mail->AltBody    = "为了查看该邮件，请切换到支持 HTML 的邮件客户端"; 
                                            // 可选项，向下兼容考虑
$mail->MsgHTML('test');                         // 设置邮件内容
$mail->AddAddress('zhangli582102953@126.com', "zhangli");
//$mail->AddAttachment("images/phpmailer.gif"); // 附件 
if(!$mail->Send()) {
    echo "发送失败：" . $mail->ErrorInfo;
} else {
    echo "恭喜，邮件发送成功！";
}
 
