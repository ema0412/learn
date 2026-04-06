<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail
{
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('【勤怠管理アプリ】メールアドレス認証のお願い')
            ->greeting($notifiable->name . ' 様')
            ->line('勤怠管理アプリにご登録いただきありがとうございます。')
            ->line('以下のURLにアクセスして、メールアドレスの認証を完了してください。')
            ->line($verificationUrl)
            ->line('このメールに心当たりがない場合は、破棄してください。');
    }
}
